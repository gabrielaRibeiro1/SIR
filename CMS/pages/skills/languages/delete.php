<?php
require "../../../../utils/header.php";
require "../../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check that the language ID exists
if (isset($_GET['languageID'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM languages WHERE languageID = ?');
    $stmt->execute([$_GET['languageID']]);
    $language = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$language) {
        exit('Language doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM languages WHERE languageID = ?');
            $stmt->execute([$_GET['languageID']]);
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
	<h2>Delete language #<?=$language['languageID']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete language #<?=$language['languageID']?>?</p>
    <div class="yesno">
        <a href="delete.php?languageID=<?=$language['languageID']?>&confirm=yes">Yes</a>
        <a href="delete.php?languageID=<?=$language['languageID']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>