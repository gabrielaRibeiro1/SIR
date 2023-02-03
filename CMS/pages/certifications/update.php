<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the certification id exists, for example update.php?id=1 will get the certification with the id of 1
if (isset($_GET['certificationID'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $certification_name = isset($_POST['certification_name']) ? $_POST['certification_name'] : '';
        $certification_date = isset($_POST['certification_date']) ? $_POST['certification_date'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE certifications SET certification_name = ?, certification_date = ? WHERE certificationID = ?');
        $stmt->execute([$certification_name, $certification_date, $_GET['certificationID']]);
        header('Location: read.php');
    }
    // Get the certification from the certifications table
    $stmt = $pdo->prepare('SELECT * FROM certifications WHERE certificationID = ?');
    $stmt->execute([$_GET['certificationID']]);
    $certification = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$certification) {
        exit('certification doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update certification #<?=$certification['certificationID']?></h2>
    <form action="update.php?certificationID=<?=$certification['certificationID']?>" method="post" enctype="multipart/form-data">

        <label for="certification_name">Certification Name</label>
        <input type="text" name="certification_name" placeholder="Certification Name" value="<?=$certification['certification_name']?>" id="certification_name">
        <label for="certification_date">Certification Date</label>
        <input type="month" name="certification_date" placeholder="Certification Date" value="<?=$certification['certification_date']?>" id="certification_date">

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>