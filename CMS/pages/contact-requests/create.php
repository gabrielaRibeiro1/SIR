<?php

require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';


// Check if POST data is not empty
if (!empty($_POST)) {    
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $contact_requestID = isset($_POST['contact_requestID']) && !empty($_POST['contact_requestID']) && $_POST['contact_requestID'] != 'auto' ? $_POST['contact_requestID'] : NULL;
    // Check if POST variables exists, if not default the value to blank, basically the same for all variables
    $contact_name = isset($_POST['contact_name']) ? $_POST['contact_name'] : '';
    $contact_email = isset($_POST['contact_email']) ? $_POST['contact_email'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';
    $seen = isset($_POST['seen']) == 'true' ? 1 : 0;
    if ($seen) {
        // Update the value of seen_at only if seen is true
        $seen_at = date('m/d/Y h:i:s a', time());
    } else {
        $seen_at = "not seen yet";
    }
    // Change the line below to your timezone!
    date_default_timezone_set('Europe/London');
    $created = date('m/d/Y h:i:s a', time());
    // Insert new record into the about_me table
    $stmt = $pdo->prepare('INSERT INTO contact_request VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$contact_requestID, $_SESSION["id"], $contact_name, $contact_email, $message, $seen, $seen_at, $created]);
    header('Location: read.php');

}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Contact Request</h2>
    <form action="create.php" method="post">

        <label for="contact_requestID">Contact ID</label>
        <input type="text" name="contact_requestID" disabled placeholder="26" value="auto" id="contact_requestID">
        <label for="contact_name">First Name</label>
        <input type="text" name="contact_name" placeholder="First Name" id="contact_name">
        <label for="email">Email</label>
        <input type="text" name="email" placeholder="Email" id="email">
        <label for="message">Message</label>
        <input type="text" name="message" placeholder="Message" id="message">
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>