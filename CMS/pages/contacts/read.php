<?php
require "../../../utils/header.php";
require "../../db/connection.php";

// Connect to MySQL database
$pdo = pdo_connect_mysql();

// Prepare the SQL statement and get records from introduction table, and only show the one that belongs to the user logged in
$stmt2 = $pdo->prepare("SELECT * FROM contacts as c, introduction as i WHERE c.introID = i.introID ORDER BY contactID");

$stmt2->execute();
// Fetch the records so we can display them in our template.
$contacts= $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>

<?=template_header('Read')?>

<div class="content read">
    <h2>Contacts</h2>
    <?php if ($_SESSION["userType"] == "Admin"): ?>
    <a href="createContact.php" class="create-language">Create New Contact</a>
    <?php endif; ?>
	<table>
        <thead>
            <tr>
                <td>Intro ID</td>
                <td>Contact ID</td>
                <td>Type</td>
                <td>Value</td>
                <td>Icon</td>
                <td>Options</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?=$contact['introID']?></td>
                <td><?=$contact['contactID']?></td>
                <td><?=$contact['type']?></td>
                <td><?=$contact['value']?></td>
                <td>
                <img witdh="30" height="30" src="<?php echo $contact['icon']; ?>">
                </td>
                <?php if ($_SESSION["userType"] == "Admin"): ?>
                <td class="actions">
                    <a href="updateContact.php?contactID=<?=$contact['contactID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="deleteContact.php?contactID=<?=$contact['contactID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?=template_footer()?>