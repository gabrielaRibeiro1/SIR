<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check that the language ID exists
if (isset($_GET['contact_requestID'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM contact_request WHERE contact_requestID = ?');
    $stmt->execute([$_GET['contact_requestID']]);
    $contact_request = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact_request) {
        exit('contact_request doesn\'t exist with that ID!');
    }
    // Make sure the user confirms before deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM contact_request WHERE contact_requestID = ?');
            $stmt->execute([$_GET['contact_requestID']]);
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
	<h2>Delete contact request #<?=$contact_request['contact_requestID']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete the contact request #<?=$contact_request['contact_requestID']?>?</p>
    <div class="yesno">
        <a href="delete.php?contact_requestID=<?=$contact_request['contact_requestID']?>&confirm=yes">Yes</a>
        <a href="delete.php?contact_requestID=<?=$contact_request['contact_requestID']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>