<?php

require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';


// Check if POST data is not empty
if (!empty($_POST)) {

    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $experienceID = isset($_POST['educationID']) && !empty($_POST['educationID']) && $_POST['educationID'] != 'auto' ? $_POST['educationID'] : NULL;
    // Check if POST variables exists, if not default the value to blank, basically the same for all variables
    $school_title = isset($_POST['school_title']) ? $_POST['school_title'] : '';
    $course_name = isset($_POST['course_name']) ? $_POST['course_name'] : '';
    // Insert new record into the about_me table
    $stmt = $pdo->prepare('INSERT INTO education VALUES (?, ?, ?, ?)');
    $stmt->execute([$experienceID, $_SESSION["id"], $school_title, $course_name]);
    header('Location: read.php');

}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create New Education</h2>
    <form action="create.php" method="post">
        
        <label for="educationID">Education ID</label>
        <input type="text" name="educationID" disabled placeholder="26" value="auto" id="educationID">
        <label for="school_title">School Title</label>
        <input type="text" name="school_title" placeholder="School Title" id="school_title">
        <label for="course_name">Course Title</label>
        <input type="text" name="course_name" placeholder="Course Name" id="course_name">
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>