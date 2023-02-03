<?php

require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';


// Check if POST data is not empty
if (!empty($_POST)) {
    $path = '../../../assets/upload/images/';
    $profilePicture = $path . $_FILES['profile']['name'];
    move_uploaded_file($_FILES['profile']['tmp_name'], $profilePicture);
    $newPath = '/SIR-gabs/assets/upload/images/';
    $profilePicture = $newPath . $_FILES['profile']['name'];
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $introID = isset($_POST['introID']) && !empty($_POST['introID']) && $_POST['introID'] != 'auto' ? $_POST['introID'] : NULL;
    // Check if POST variables exists, if not default the value to blank, basically the same for all variables
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    // Insert new record into the introduction table
    $stmt = $pdo->prepare('INSERT INTO introduction VALUES (?, ?, ?, ?)');
    $stmt->execute([$introID, $_SESSION["id"], $description, $profilePicture]);
    header('Location: read.php');

}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Introduction</h2>
    <form action="create.php" method="post" enctype="multipart/form-data">

        <label for="introID">introID</label>
        <input type="text" name="introID" disabled placeholder="26" value="auto" id="introID">
        <label for="description">Descripton</label>
        <input type="text" name="description" placeholder="Description" id="description">
        <label for="userPhoto">User Photo</label>
        <input type="file" name="profile" value="" id=profile/>
    
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>