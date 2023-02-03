<?php
require "../../../../utils/header.php";
require "../../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $softskillID = isset($_POST['softskillID']) && !empty($_POST['softskillID']) && $_POST['softskillID'] != 'auto' ? $_POST['softskillID'] : NULL;
    $softskill_name = isset($_POST['softskill_name']) ? $_POST['softskill_name'] : '';
    // Insert new record into the languages table
    $stmt = $pdo->prepare('INSERT INTO soft_skills VALUES (?, ?, ?)');
    $stmt->execute([$softskillID, $_SESSION["id"], $softskill_name]);
    header('Location: ../read.php');
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Soft Skill</h2>
    <form action="createSoftSkill.php" method="post">

        <label for="softskill_name">Soft Skill Name</label>
        <input type="text" name="softskill_name" placeholder="Soft Skill Name" id="softskill_name">
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>