<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the aboutme id exists, for example update.php?id=1 will get the aboutme with the id of 1
if (isset($_GET['contactID'])) {
    if (!empty($_POST)) {
        $path = '../../../../assets/upload/logotypes/';
        $icon = $path . $_FILES['profile']['name'];
        move_uploaded_file($_FILES['profile']['tmp_name'], $icon);
        $newPath = '/SIR-gabs/assets/upload/logotypes/';
        $icon = $newPath . $_FILES['profile']['name'];
        // This part is similar to the create.php, but instead we update a record and not insert
        $type = isset($_POST['type']) ? $_POST['type'] : '';
        $value = isset($_POST['value']) ? $_POST['value'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE contacts SET type = ?, value = ?, icon = ? WHERE contactID = ?');
        $stmt->execute([$type, $value, $icon, $_GET['contactID']]);
        header('Location: read.php');
    }
    // Get the fields from the table
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE contactID = ?');
    $stmt->execute([$_GET['contactID']]);
    $contacts = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contacts) {
        exit('contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update contact #<?=$contacts['contactID']?></h2>
    <form action="updateContact.php?contactID=<?=$contacts['contactID']?>" method="post" enctype="multipart/form-data">

        <label for="type">Type</label>
        <input type="text" name="type" placeholder="contact type" value="<?=$contacts['type']?>" id="type">
        <label for="value">Value</label>
        <input type="text" name="value" placeholder="contact value" value="<?=$contacts['value']?>" id="value">
        <label for="icon">icon</label>
        <input type="file" name="profile" value="<?=$contacts['icon']?>" id="profile">
    
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>