<?php

// Create and include a configuration file with the database connection
include('config.php');

// If form submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Get username and password from the form as variables
    $side = rand(1,2);
    
    if($side == 1){
        $faction = "Earth";
    }
    else{
        $faction = "Mars";
    }
    $userId = rand(10,50);
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	// Query records that have usernames and passwords that match those in the customers table
	$sql = file_get_contents('sql/attemptRegister.sql');
	$params = array(
        'userId' => $userId,
		'username' => $username,
		'password' => $password
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
    
    $sql = file_get_contents('sql/attemptFaction.sql');
	$params = array(
        'userId' => $userId,
		'faction' => $faction,
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	
	// If $users is not empty
	if(!empty($users)) {
		// Set $user equal to the first result of $users
		$user = $users[0];
		
		// Set a session variable with a key of customerID equal to the customerID returned
		$_SESSION['userId'] = $user['userId'];
		
		// Redirect to the index.php file
	}
    header('location: login.php');
}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Login</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/style.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
    
	<div class="login">
		<h1>Register</h1>
		<form method="POST">
			<input type="text" name="username" placeholder="Enter Username" /><br />
			<input type="password" name="password" placeholder="Enter Password" /><br />
			<input type="submit" value="Register" />
		</form>
	</div>
</body>
</html>