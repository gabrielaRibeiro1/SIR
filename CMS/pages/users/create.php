<?php 
    require "../../../utils/header.php";
    require "../../db/connection.php";
    $username = $_SESSION["username"];
    $userRole = $_SESSION["userType"];

    $pdo = pdo_connect_mysql();
    $msg = '';


    // Check if POST data is not empty
if (!empty($_POST)) {    
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variables exists, if not default the value to blank, basically the same for all variables
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $userType = isset($_POST['userType']) ? $_POST['userType'] : '';
    // Change the line below to your timezone!
    date_default_timezone_set('Europe/London');
    // Insert new record into the about_me table
    $sql = "INSERT INTO users (id, userType, username, password) VALUES (id, :userType, :username, :password)";

    if($stmt = $pdo->prepare($sql)){
        $param_username = $username;
        $param_userType= $userType;
        $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
        
        $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
        $stmt->bindParam(":userType", $param_userType, PDO::PARAM_STR);
        $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
        
        if($stmt->execute()){
            header("location: read.php");
        } 
        else{
            var_dump($pdo);
            echo "Ups! Try again please.";
        }

        unset($stmt);
    }

    header('Location: read.php');

}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create User</h2>
    <form action="create.php" method="post">

        <label for="id">User ID</label>
        <input type="text" name="id" disabled placeholder="26" value="auto" id="id">

        <label>Select a role</label>
        <select for="userType" name="userType">
            <?php
                
                $output="";
                $stmt = $pdo->prepare("SELECT * FROM roles");
                $stmt->execute();
                // Fetch the records so we can display them in our template.
                $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($roles as $row) {
                    $role = $row['userRole'];
                
                $output .= "<option value='$role'>$role</option>";     
                }    
                $output .="";
                echo $output;
        ?>
        </select>

        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Username" id="username">
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Password" id="password">
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>


<?=template_footer()?>