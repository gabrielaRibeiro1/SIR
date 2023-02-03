<?php
require "../../../utils/header.php";
require "../../db/connection.php";

// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 4;

// Prepare the SQL statement and get records from our languages table, LIMIT will determine the page
$stmt = $pdo->prepare("SELECT * FROM languages ORDER BY languageID LIMIT :current_page, :record_per_page");
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$languages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare the SQL statement and get records from table, and only show the one that belongs to the user logged in
$stmt2 = $pdo->prepare("SELECT * FROM soft_skills ORDER BY softskillID LIMIT :current_page, :record_per_page");
$stmt2->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt2->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt2->execute();
// Fetch the records so we can display them in our template.
$soft_skills= $stmt2->fetchAll(PDO::FETCH_ASSOC);

// Prepare the SQL statement and get records from table, and only show the one that belongs to the user logged in
$stmt3 = $pdo->prepare("SELECT * FROM hard_skills ORDER BY hardskillID LIMIT :current_page, :record_per_page");
$stmt3->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt3->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt3->execute();
// Fetch the records so we can display them in our template.
$hard_skills= $stmt3->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of languages, this is so we can determine whether there should be a next and previous button
$num_languages = $pdo->query('SELECT COUNT(*) FROM languages')->fetchColumn();
$num_softskills = $pdo->query('SELECT COUNT(*) FROM soft_skills')->fetchColumn();
$num_hardskills = $pdo->query('SELECT COUNT(*) FROM hard_skills')->fetchColumn();
?>

<?=template_header('Read')?>

<div class="content read">
	<h2>Languages</h2>
	<a href="languages/create.php" class="create-language">Create Language</a>
	<table>
        <thead>
            <tr>
                <td>User ID</td>
                <td>Language ID</td>
                <td>Language Name</td>
                <td>Language Level</td>
                <td>Options</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($languages as $language): ?>
            <tr>
                <td><?=$language['userID']?></td>
                <td><?=$language['languageID']?></td>
                <td><?=$language['language_name']?></td>
                <td><?=$language['language_level']?></td>
                <td class="actions">
                    <a href="languages/update.php?languageID=<?=$language['languageID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="languages/delete.php?languageID=<?=$language['languageID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_languages): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<div class="content read">
    <h2>Soft Skills</h2>
    <a href="soft-skills/createSoftSkill.php" class="create-language">Create New Soft Skill</a>
	<table>
        <thead>
            <tr>
                <td>User ID</td>
                <td>SoftSkill ID</td>
                <td>SoftSkill Name</td>
                <td>Options</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($soft_skills as $softskill): ?>
            <tr>
                <td><?=$softskill['userID']?></td>
                <td><?=$softskill['softskillID']?></td>
                <td><?=$softskill['softskill_name']?></td>
                <td class="actions">
                    <a href="soft-skills/updateSoftSkill.php?softskillID=<?=$softskill['softskillID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="soft-skills/deleteSoftSkill.php?softskillID=<?=$softskill['softskillID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_softskills): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<div class="content read">
    <h2>Hard Skills</h2>
    <a href="hard-skills/createHardSkill.php" class="create-language">Create New Hard Skill</a>
	<table>
        <thead>
            <tr>
                <td>User ID</td>
                <td>HardSkill ID</td>
                <td>HardSkill Name</td>
                <td>Options</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($hard_skills as $hardskill): ?>
            <tr>
                <td><?=$hardskill['userID']?></td>
                <td><?=$hardskill['hardskillID']?></td>
                <td><?=$hardskill['hardskill_name']?></td>
                <td class="actions">
                    <a href="hard-skills/updateHardSkill.php?hardskillID=<?=$hardskill['hardskillID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="hard-skills/deleteHardSkill.php?hardskillID=<?=$hardskill['hardskillID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_hardskills): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>