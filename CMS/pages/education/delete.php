<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check that the language ID exists
if (isset($_GET['educationID'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM education WHERE educationID = ?');
    $stmt->execute([$_GET['educationID']]);
    $education = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$education) {
        exit('education doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM education WHERE educationID = ?');
            $stmt->execute([$_GET['educationID']]);
            header('Location: read.php');
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete education #<?=$education['educationID']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete education #<?=$education['educationID']?>?</p>
    <div class="yesno">
        <a href="delete.php?educationID=<?=$education['educationID']?>&confirm=yes">Yes</a>
        <a href="delete.php?educationID=<?=$education['educationID']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>