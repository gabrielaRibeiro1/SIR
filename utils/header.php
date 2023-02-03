<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /SIR-gabs/CMS/auth/login.php");
    exit;
}

function create_menu() {
    $userRole = $_SESSION["userType"];

        echo '<a href="/SIR-gabs">Frontoffice</a>';
        echo '<a href="/SIR-gabs/CMS/pages/users/read.php">Users</a>';
        echo '<a href="/SIR-gabs/CMS/pages/introduction/read.php">Introduction</a>';
        echo '<a href="/SIR-gabs/CMS/pages/skills/read.php">Skills</a>';
        echo '<a href="/SIR-gabs/CMS/pages/certifications/read.php">Certifications</a>';
        echo '<a href="/SIR-gabs/CMS/pages/education/read.php">Education</a>';
		echo '<a href="/SIR-gabs/CMS/pages/contacts/read.php">Contacts</a>';
        echo '<a href="/SIR-gabs/CMS/pages/contact-requests/read.php">Contact Requests</a>';
		echo '<a href="/SIR-gabs/CMS/pages/salary/salary.php">Salary</a>';
}

function template_header($title) {
	$username  = $_SESSION["username"];
	$userID  = $_SESSION["id"];
	$userRole = $_SESSION["userType"];

echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>My CMS</title>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css">
		<link href="/SIR-gabs/utils/style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
	<nav class="navtop">
		<div>
			<h1>Hello, $username </h1>
EOT;
create_menu();
echo <<<EOT
			<a href="/SIR-gabs/CMS/auth/logout.php">Logout</a>
		</div>
	</nav>
EOT;
}
function template_footer() {
echo <<<EOT
    </body>
</html>
EOT;
}
?>