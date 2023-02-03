<?php
require "../../../../utils/header.php";
require "../../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check that the language ID exists
if (isset($_GET['softskillID'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM soft_skills WHERE softskillID = ?');
    $stmt->execute([$_GET['softskillID']]);
    $softskill = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$softskill) {
        exit('Language doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM soft_skills WHERE softskillID = ?');
            $stmt->execute([$_GET['softskillID']]);
            header('Location: ../read.php');
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: ../read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete soft skill #<?=$softskill['softskillID']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete soft skill #<?=$softskill['softskillID']?>?</p>
    <div class="yesno">
        <a href="deleteSoftSkill.php?softskillID=<?=$softskill['softskillID']?>&confirm=yes">Yes</a>
        <a href="deleteSoftSkill.php?softskillID=<?=$softskill['softskillID']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>