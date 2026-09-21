<?php
session_start();

if (empty($_SESSION['authenticated'])) {
	header('Location: login.php');
	exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
	$_SESSION = [];
	session_destroy();
	header('Location: login.php');
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard</title>
	<style>
		body { font-family: Arial, sans-serif; margin: 0; background: #f3f4f6; color: #1f2937; }
		main { max-width: 680px; margin: 10vh auto; padding: 2rem; background: #fff; border-radius: 10px; box-shadow: 0 8px 24px rgba(0, 0, 0, .08); }
		button { padding: .7rem 1rem; border: 0; border-radius: 6px; background: #2563eb; color: #fff; cursor: pointer; }
	</style>
</head>
<body>
	<main>
		<h1>Welcome to your dashboard</h1>
		<p>You are authenticated and can access this protected page.</p>
		<form method="post">
			<button type="submit" name="logout" value="1">Log out</button>
		</form>
	</main>
</body>
</html>
