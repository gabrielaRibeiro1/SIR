<?php

require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';


// Check if POST data is not empty
if (!empty($_POST)) {
    $path = '../../../../assets/upload/logotypes/';
    $icon = $path . $_FILES['profile']['name'];
    move_uploaded_file($_FILES['profile']['tmp_name'], $icon);
    $newPath = '/SIR-gabs/assets/upload/logotypes/';
    $icon = $newPath . $_FILES['profile']['name'];
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    // Check if POST variables exists, if not default the value to blank, basically the same for all variables
    $contactID = isset($_POST['contactID']) && !empty($_POST['contactID']) && $_POST['contactID'] != 'auto' ? $_POST['contactID'] : NULL;
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $value = isset($_POST['value']) ? $_POST['value'] : '';
    // Insert new record into the about_me table
   
    $stmt = $pdo->prepare("SELECT introID FROM introduction");
    $stmt->execute();
    $intro = $stmt->fetch();

    if ($intro) {
        // The aboutmeID value exists in the about_me table, so we can insert it into the connect_links table
        $stmt = $pdo->prepare('INSERT INTO contacts VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$contactID, $intro['introID'], $type, $value, $icon]);
        header('Location: read.php');
    } else {
        
    }
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create New Form of Contact</h2>
    <form action="createContact.php" method="post" enctype="multipart/form-data">

        <label for="type">Type</label>
        <input type="text" name="type" placeholder="contact type" id="type">
        <label for="value">Value</label>
        <input type="text" name="value" placeholder="contact value" id="value">
        <label for="icon">Icon</label>
        <input type="file" name="profile" value="" id="profile"/>

        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>