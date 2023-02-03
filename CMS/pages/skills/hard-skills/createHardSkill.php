<?php
require "../../../../utils/header.php";
require "../../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $hardskillID = isset($_POST['hardskillID']) && !empty($_POST['hardskillID']) && $_POST['hardskillID'] != 'auto' ? $_POST['hardskillID'] : NULL;
    $hardskill_name = isset($_POST['hardskill_name']) ? $_POST['hardskill_name'] : '';
    // Insert new record into the languages table
    $stmt = $pdo->prepare('INSERT INTO hard_skills VALUES (?, ?, ?)');
    $stmt->execute([$hardskillID, $_SESSION["id"], $hardskill_name]);
    header('Location: ../read.php');
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Hard Skill</h2>
    <form action="createHardSkill.php" method="post">

        <label for="hardskill_name">Hard Skill Name</label>
        <input type="text" name="hardskill_name" placeholder="Soft Skill Name" id="hardskill_name">
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>