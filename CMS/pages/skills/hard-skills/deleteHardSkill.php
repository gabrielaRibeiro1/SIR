<?php
require "../../../../utils/header.php";
require "../../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check that the language ID exists
if (isset($_GET['hardskillID'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM hard_skills WHERE hardskillID = ?');
    $stmt->execute([$_GET['hardskillID']]);
    $hardskill = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$hardskill) {
        exit('Skill doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM hard_skills WHERE hardskillID = ?');
            $stmt->execute([$_GET['hardskillID']]);
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
	<h2>Delete hard skill #<?=$hardskill['hardskillID']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete hard skill #<?=$hardskill['hardskillID']?>?</p>
    <div class="yesno">
        <a href="deleteHardSkill.php?hardskillID=<?=$hardskill['hardskillID']?>&confirm=yes">Yes</a>
        <a href="deleteHardSkill.php?hardskillID=<?=$hardskill['hardskillID']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>