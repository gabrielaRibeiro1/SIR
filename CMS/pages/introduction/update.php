<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the aboutme id exists, for example update.php?id=1 will get the aboutme with the id of 1
if (isset($_GET['introID'])) {
    if (!empty($_POST)) {
        $path = '../../../assets/upload/images/';
        $location = $path . $_FILES['profile']['name'];
        move_uploaded_file($_FILES['profile']['tmp_name'], $location);
        $newPath = '/SIR-gabs/assets/upload/images/';
        $profilePicture = $newPath . $_FILES['profile']['name'];
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $stmt = $pdo->prepare('UPDATE introduction SET description = ?, profilePicture = ?, phone_number = ?, email = ? WHERE introID = ?');
        $stmt->execute([$description, $profilePicture, $phone_number, $email, $_GET['introID']]);
        header('Location: read.php');
    }
    // Get the fields from the introduction table
    $stmt = $pdo->prepare('SELECT * FROM introduction WHERE introID = ?');
    $stmt->execute([$_GET['introID']]);
    $introduction = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$introduction) {
        exit('introduction doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update introduction #<?=$introduction['introID']?></h2>
    <form action="update.php?introID=<?=$introduction['introID']?>" method="post" enctype="multipart/form-data">


        <label for="description">Description</label>
        <input type="text" name="description" placeholder="Description" value="<?=$introduction['description']?>" id="description">
        <label for="profilePicture">User Photo</label>
        <input type="file" name="profile" value="<?=$introduction['profilePicture']?>" id="profile">
        <label for="phone_number">Phone Number</label>
        <input type="text" name="phone_number" placeholder="Phone Number" value="<?=$introduction['phone_number']?>" id="phone_number">
        <label for="email">Email</label>
        <input type="text" name="email" placeholder="Email" value="<?=$introduction['email']?>" id="email">
    
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>