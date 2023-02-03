<?php
require "../../../../utils/header.php";
require "../../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the id exists, for example update.php?id=1 will get the language with the id of 1
if (isset($_GET['hardskillID'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $hardskill_name = isset($_POST['hardskill_name']) ? $_POST['hardskill_name'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE hard_skills SET hardskill_name = ? WHERE hardskillID = ?');
        $stmt->execute([$hardskill_name, $_GET['hardskillID']]);
        $msg = 'Updated Successfully! You will be redirected to your account page in 2 seconds....';
        header('Location: ../read.php');
    }
    // Get the language from the languages table
    $stmt = $pdo->prepare('SELECT * FROM hard_skills WHERE hardskillID = ?');
    $stmt->execute([$_GET['hardskillID']]);
    $softskill = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$softskill) {
        exit('hard skill doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update Hard skill #<?=$softskill['hardskillID']?></h2>
    <form action="updateHardSkill.php?hardskillID=<?=$softskill['hardskillID']?>" method="post">

        <label for="hardskill_name">HardSkill Name</label>
        <input type="text" name="hardskill_name" placeholder="SoftSkill Name" value="<?=$softskill['hardskill_name']?>" id="hardskill_name">

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>