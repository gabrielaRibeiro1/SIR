<?php
require "../../../../utils/header.php";
require "../../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the id exists, for example update.php?id=1 will get the language with the id of 1
if (isset($_GET['softskillID'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $softskill_name = isset($_POST['softskill_name']) ? $_POST['softskill_name'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE soft_skills SET softskill_name = ? WHERE softskillID = ?');
        $stmt->execute([$softskill_name, $_GET['softskillID']]);
        header('Location: ../read.php');
    }
    // Get the language from the languages table
    $stmt = $pdo->prepare('SELECT * FROM soft_skills WHERE softskillID = ?');
    $stmt->execute([$_GET['softskillID']]);
    $softskill = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$softskill) {
        exit('soft skill doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update soft skill #<?=$softskill['softskillID']?></h2>
    <form action="updateSoftSkill.php?softskillID=<?=$softskill['softskillID']?>" method="post">

        <label for="softskill_name">SoftSkill Name</label>
        <input type="text" name="softskill_name" placeholder="SoftSkill Name" value="<?=$softskill['softskill_name']?>" id="softskill_name">

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>