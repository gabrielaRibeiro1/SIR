<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the aboutme id exists, for example update.php?id=1 will get the aboutme with the id of 1
if (isset($_GET['educationID'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $school_title = isset($_POST['school_title']) ? $_POST['school_title'] : '';
        $course_name = isset($_POST['course_name']) ? $_POST['course_name'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE education SET school_title = ?, course_name = ? WHERE educationID = ?');
        $stmt->execute([$school_title, $course_name, $_GET['educationID']]);
        header('Location: read.php');
    }
    // Get the fields from the about_me table
    $stmt = $pdo->prepare('SELECT * FROM education WHERE educationID = ?');
    $stmt->execute([$_GET['educationID']]);
    $education = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$education) {
        exit('education doesn\'t exist with that ID!');
    }
} else {
    exit('No educationID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update education #<?=$education['educationID']?></h2>
    <form action="update.php?educationID=<?=$education['educationID']?>" method="post">

        <label for="school_title">School Title</label>
        <input type="text" name="school_title" placeholder="School Title" value="<?=$education['school_title']?>" id="school_title">
        <label for="course_name">Course Name</label>
        <input type="text" name="course_name" placeholder="Course Name" value="<?=$education['course_name']?>" id="course_name">
    
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>