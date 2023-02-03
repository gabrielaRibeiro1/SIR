<?php
require "../../../utils/header.php";
require "../../db/connection.php";

// Connect to MySQL database
$pdo = pdo_connect_mysql();

// Prepare the SQL statement and get records from introduction table, and only show the one that belongs to the user logged in
$stmt = $pdo->prepare("SELECT * FROM introduction");
$stmt->execute();
// Fetch the records so we can display them in our template.
$introduction = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare the SQL statement and get records from introduction table, and only show the one that belongs to the user logged in
$stmt2 = $pdo->prepare("SELECT * FROM contacts as c, introduction as i WHERE c.introID = i.introID ORDER BY contactID");

$stmt2->execute();
// Fetch the records so we can display them in our template.
$contacts= $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>

<?=template_header('Read')?>

<div class="content read">
    <h2>About Me</h2>
    <!-- To hide the "Create About me" link if the user already has an "About me" section, we wrap the link in an if statement and check if the $introduction variable is empty or not.-->
    <?php if (empty($introduction)): ?>
    <a href="create.php" class="create-language">Create Introduction</a>
    <?php endif; ?>
	<table>
        <thead>
            <tr>
                <td>User ID</td>
                <td>Intro ID</td>
                <td>Description</td>
                <td>User Photo</td>
                <td>Options</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($introduction as $intro): ?>
            <tr>
                <td><?=$intro['userID']?></td>
                <td><?=$intro['introID']?></td>
                <td><?=$intro['description']?></td>
                <td>
                <img witdh="100" height="100" src="<?php echo $intro['profilePicture']; ?>">
                </td>
                <?php if ($_SESSION["userType"] == "Admin"): ?>
                <td class="actions">
                    <a href="update.php?introID=<?=$intro['introID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?introID=<?=$intro['introID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?=template_footer()?>