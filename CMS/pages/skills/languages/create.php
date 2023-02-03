<?php
require "../../../../utils/header.php";
require "../../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $languageID = isset($_POST['languageID']) && !empty($_POST['languageID']) && $_POST['languageID'] != 'auto' ? $_POST['languageID'] : NULL;
    $language_name = isset($_POST['language_name']) ? $_POST['language_name'] : '';
    $language_level = isset($_POST['language_level']) ? $_POST['language_level'] : '';
    // Insert new record into the languages table
    $stmt = $pdo->prepare('INSERT INTO languages VALUES (?, ?, ?, ?)');
    $stmt->execute([$languageID, $_SESSION["id"], $language_name, $language_level]);
    header('Location: ../read.php');
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Language</h2>
    <form action="create.php" method="post" enctype="multipart/form-data">

        <label for="language_name">Language Name</label>
        <input type="text" name="language_name" placeholder="Language Name" id="language_name">
        <label for="language_level">Language Level</label>
        <input type="text" name="language_level" placeholder="Language Level" id="language_level">
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>