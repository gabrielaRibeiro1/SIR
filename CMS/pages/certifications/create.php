<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $certificationID = isset($_POST['certificationID']) && !empty($_POST['certificationID']) && $_POST['certificationID'] != 'auto' ? $_POST['certificationID'] : NULL;
    $certification_name = isset($_POST['certification_name']) ? $_POST['certification_name'] : '';
    // Insert new record into the certifications table
    $stmt = $pdo->prepare('INSERT INTO certifications VALUES (?, ?, ?)');
    $stmt->execute([$certificationID, $_SESSION["id"], $certification_name]);
    header('Location: read.php');
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Certification</h2>
    <form action="create.php" method="post">

        <label for="certification_name">Certification Name</label>
        <input type="text" name="certification_name" placeholder="Certification Name" id="certification_name">
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>