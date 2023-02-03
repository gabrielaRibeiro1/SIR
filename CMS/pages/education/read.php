<?php
require "../../../utils/header.php";
require "../../db/connection.php";

// Connect to MySQL database
$pdo = pdo_connect_mysql();

// Prepare the SQL statement and get records from about_me table, and only show the one that belongs to the user logged in
$stmt = $pdo->prepare("SELECT * FROM education");
$stmt->execute();
// Fetch the records so we can display them in our template.
$educations = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?=template_header('Read')?>

<div class="content read">
    <h2>Education</h2>
    <?php if ($_SESSION["userType"] == "Admin"): ?>
    <a href="create.php" class="create-language">Create Education</a>
    <?php endif; ?>
	<table>
        <thead>
            <tr>
                <td>User ID</td>
                <td>Education ID</td>
                <td>School Title</td>
                <td>Course Name</td>
                <td>Options</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($educations as $education): ?>
            <tr>
                <td><?=$education['userID']?></td>
                <td><?=$education['educationID']?></td>
                <td><?=$education['school_title']?></td>
                <td><?=$education['course_name']?></td>
                <?php if ($_SESSION["userType"] == "Admin"): ?>
                <td class="actions">
                    <a href="update.php?educationID=<?=$education['educationID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?educationID=<?=$education['educationID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?=template_footer()?>