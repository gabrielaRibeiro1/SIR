<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check that the language ID exists
if (isset($_GET['contactID'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE contactID = ?');
    $stmt->execute([$_GET['contactID']]);
    $contacts = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contacts) {
        exit('contact doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM contacts WHERE contactID = ?');
            $stmt->execute([$_GET['contactID']]);
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
	<h2>Delete contact #<?=$contacts['contactID']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete contact #<?=$contacts['contactID']?>?</p>
    <div class="yesno">
        <a href="deleteContact.php?contactID=<?=$contacts['contactID']?>&confirm=yes">Yes</a>
        <a href="deleteContact.php?contactID=<?=$contacts['contactID']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>