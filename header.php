<?php
	session_start();
	
	function validate($pageName) {
		$_GET['redirect'] = $pageName;
		if(!isset($_SESSION['loggedIn']) ||
			!$_SESSION['loggedIn']) {
			header("location: password.php");
		} else {
			if(isset($_POST['password']) && $_POST['password'] == 'snowball') {
				$_SESSION['loggedIn'] = true;
			} else {
				header("location: password.php");
			}
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="style.css" type="text/css" />
	</head>
	
	<body>
		<ul class="navbar">
			<li><a href="index.php">Create Page</a></li>
			<li><a href="tag.php">Tags</a></li>
			<li><a href="page.php">Pages</a></li>
		</ul>