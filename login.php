<?php
ini_set('session.use_strict_mode', '1');
session_set_cookie_params([
	'lifetime' => 0,
	'path' => '/',
	'httponly' => true,
	'samesite' => 'Strict',
	'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
]);
session_start();

if (!empty($_SESSION['authenticated'])) {
	header('Location: index.php');
	exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	session_regenerate_id(true);
	$_SESSION['authenticated'] = true;
	$_SESSION['email'] = strtolower(trim($_POST['email'] ?? ''));
	header('Location: index.php');
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Log in</title>
	<style>
		body { font-family: Arial, sans-serif; margin: 0; background: #f3f4f6; color: #1f2937; }
		main { max-width: 420px; margin: 10vh auto; padding: 2rem; background: #fff; border-radius: 10px; box-shadow: 0 8px 24px rgba(0, 0, 0, .08); }
		label { display: block; margin: 1rem 0 .35rem; font-weight: 600; }
		input { box-sizing: border-box; width: 100%; padding: .7rem; border: 1px solid #9ca3af; border-radius: 6px; }
		button { width: 100%; margin-top: 1.25rem; padding: .7rem; border: 0; border-radius: 6px; background: #2563eb; color: #fff; cursor: pointer; }
		.error { min-height: 1.25rem; margin: .4rem 0 0; color: #b91c1c; font-size: .9rem; }
		a { color: #2563eb; }
	</style>
</head>
<body>
	<main>
		<h1>Log in</h1>
		<form id="login-form" method="post" novalidate>
			<label for="email">Email</label>
			<input id="email" name="email" type="email" autocomplete="email" required>
			<p id="email-error" class="error" role="alert" aria-live="polite"></p>

			<label for="password">Password</label>
			<input id="password" name="password" type="password" autocomplete="current-password" required>
			<p id="password-error" class="error" role="alert" aria-live="polite"></p>

			<button type="submit">Log in</button>
		</form>
		<p>Need an account? <a href="register.php">Register</a></p>
	</main>
	<script>
		const loginForm = document.getElementById('login-form');
		const emailInput = document.getElementById('email');
		const passwordInput = document.getElementById('password');
		const emailError = document.getElementById('email-error');
		const passwordError = document.getElementById('password-error');

		loginForm.addEventListener('submit', (event) => {
			emailError.textContent = '';
			passwordError.textContent = '';

			const email = emailInput.value.trim().toLowerCase();
			const registeredEmail = localStorage.getItem('registeredEmail');
			const registeredPassword = localStorage.getItem('registeredPassword');
			let isValid = true;

			if (!emailInput.validity.valid || !email) {
				emailError.textContent = 'Please enter a valid email address.';
				isValid = false;
			} else if (!registeredEmail || email !== registeredEmail) {
				emailError.textContent = 'This email is not registered.';
				isValid = false;
			}

			if (!passwordInput.value) {
				passwordError.textContent = 'Please enter your password.';
				isValid = false;
			} else if (registeredPassword && passwordInput.value !== registeredPassword) {
				passwordError.textContent = 'Incorrect password.';
				isValid = false;
			}

			if (!isValid) {
				event.preventDefault();
			}
		});
	</script>
</body>
</html>
