<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the aboutme id exists, for example update.php?id=1 will get the aboutme with the id of 1
if (isset($_GET['contact_requestID'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $contact_requestID = isset($_POST['contact_requestID']) ? $_POST['contact_requestID'] : NULL;
        $contact_name = isset($_POST['contact_name']) ? $_POST['contact_name'] : '';
        $contact_email = isset($_POST['contact_email']) ? $_POST['contact_email'] : '';
        $message = isset($_POST['message']) ? $_POST['message'] : '';
        // Change the line below to your timezone!
        date_default_timezone_set('Europe/London');
        $created = date('m/d/Y h:i:s a', time());
        // Update the record
        $stmt = $pdo->prepare('UPDATE contact_request SET contact_name = ?, contact_email = ?, message = ?, created = ? WHERE contact_requestID = ?');
        $stmt->execute([$contact_name, $contact_email, $message, $created, $_GET['contact_requestID']]);
        header('Location: read.php');
    }
    // Get the fields from the about_me table
    $stmt = $pdo->prepare('SELECT * FROM contact_request WHERE contact_requestID = ?');
    $stmt->execute([$_GET['contact_requestID']]);
    $contact_request = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact_request) {
        exit('contact request doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update contact request #<?=$contact_request['contact_requestID']?></h2>
    <form action="update.php?contact_requestID=<?=$contact_request['contact_requestID']?>" method="post">

        <label for="contact_name">Contact Name</label>
        <input type="text" name="contact_name" placeholder="First Name" value="<?=$contact_request['contact_name']?>" id="contact_name">
        <label for="contact_email">Contact Email</label>
        <input type="text" name="contact_email" placeholder="Email" value="<?=$contact_request['contact_email']?>" id="contact_email">
        <label for="message">message</label>
        <input type="text" name="message" placeholder="message" value="<?=$contact_request['message']?>" id="message">
    
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>