<?php
/* database file */
include ("include_files/config.php");
/* login,regsiter validation file */
include("include_files/classes/Account.php");
/* error messages file */
include("include_files/classes/Constants.php");
$account = new Account($con);
	/*
		we crete the reference of the Account class. here because,this Account used by also other include file in Future.
		we call account object register() method in register_handler.
	*/
		/* Register Info Taken file */
include('include_files/form_handlers/register_handler.php');
		/* Login Info Taken file */
include('include_files/form_handlers/login_handler.php');
function getInputValue($value){

		if(isset($_POST[$value])){
			echo $_POST[$value];
		//we don't write $_POST['value'] beacuse we pass name later by call function.
		}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon/s.ico">
		<title>Login to songbook</title>
		<link rel="stylesheet" type="text/css" href="/songbook/assets/css/register.css">

		<!-- OffLine jQuery
			<script type="text/javascript" src="/songbook/assets/jQuery/jQuery-min-3.3.1.js"></script> -->

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script type="text/javascript" src="/songbook/assets/js/register.js"></script>
	</head>
	<body>
		<?php
			if(isset($_POST['registerButton'])){
				// if register button clicked.
				//jquery code
				echo '<script>

					$(document).ready(function(){
						$("#loginForm").hide();
						$("#registerForm").show();
					});
					</script>';
			}
			else {
				// if login button clicked.
				//jquery code
				echo '<script>

					$(document).ready(function(){
						$("#loginForm").show();
						$("#registerForm").hide();
					});
				</script>';
			}
		?>
		<div id="background-div" class="mySlides">
			<div id = "login-Container">
				<!-- action attribute is used for on what page you send data. -->
				<div id="input-Container">
					<!-- Login Form -->
					<form id = "loginForm" action="register.php" method="post">
						<h2 class="header-1">Login To Your Account</h2>
						<!-- we give input in diffent p because,each paragraph start on new line. -->
						<p>
							<!--
								label is very useful,usually use for writeing text,like name,etc.
								Advantage: If we click on label text it automatically show the form type field.
							-->
							<!-- we only put login error on top of username because it will show on top of username and password on screen. -->
							<?php echo $account->getError(Constants::$loginFailed); ?>
							<label for="loginUserName">Username</label>
							<input id="loginUserName" type="text" name="loginUserName" placeholder="e.g. lalu-labad" value="<?php getInputValue('loginUserName')?>" required>
						</p>
						<p>
							<label for="loginUserPassword">Password</label>
							<input id="loginUserPassword" type="password" name="loginUserPassword"  placeholder="Your Password" required>
						</p>
						<button type="submit" name="loginButton">LOG IN</button>

						<div class="hasAccountText">
							<span id="hideLogin">Don't have an account yet? Signup here.</span>
						</div>
					</form>

					<!-- Register form -->
					<form id = "registerForm" action="register.php" method="post" >
						<h2 class="header-2">Register Your Free Account</h2>
						<!-- we give input in diffent p because,each paragraph start on new line. -->
						<p>
							<!--
								label is very useful,usually use for writeing text,like name,etc.
								Advantage: If we click on label text it automatically show the form type field.
							-->
							<!-- Now put validation error for each registration form element. -->
							<!-- username error -->
							<?php echo $account->getError(Constants::$usernameCharacters); ?>
							<?php echo $account->getError(Constants::$usernameTaken); ?>
							<label for="userName" form="resiterForm">Username</label>
							<input id="userName" type="text" name="userName" placeholder="e.g. lalu-labad"  value="<?php getInputValue('userName')?>" required>
						</p>
						<p>
							<!-- firstName error -->
							<?php echo $account->getError(Constants::$firstNameCharacters); ?>
							<label for="firstName">Firstname</label>
							<input id="firstName" type="text" name="firstName" placeholder="e.g. lalu-labad" value="<?php getInputValue('firstName')?>" required>
						</p>
						<p>
							<!-- lastname error -->
							<?php echo $account->getError(Constants::$lastNameCharacters); ?>
							<label for="lastName">Lastname</label>
							<input id="lastName" type="text" name="lastName" placeholder="e.g. lalu-labad" value="<?php getInputValue('lastName')?>" required>
						</p>
						<p>
							<!-- email error -->
							<?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
							<?php echo $account->getError(Constants::$emailInvalid); ?>
							<?php echo $account->getError(Constants::$emailTaken); ?>
							<label for="email">Email</label>
							<input id="email" type="email" name="email" placeholder="e.g. lalu-labad@xyz.com" value="<?php getInputValue('email')?>"	required>
						</p>
						<p>
							<!-- we don't need to check error for email2 error. -->
							<label for="confirm-email">Confirm Email</label>
							<input id="confirm-email" type="email" name="email2" placeholder="e.g. lalu-labad@xyz.com" value="<?php getInputValue('email2')?>" required>
						</p>
						<!-- give some space upper of password to do php stuff -->
						<p>
							<?php echo $account->getError(Constants::$passwordsDoNoMatch); ?>
							<?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
							<?php echo $account->getError(Constants::$passwordCharacters); ?>
							<label for="userPassword">Password</label>
							<input id="userPassword" type="password" name="password" placeholder="Your Password"  required>
						</p>
						<p>
							<!-- we don't need to check error for password2 error. -->
							<label for="confirm-Password">Confirm Password</label>
							<input id="confirm-Password" type="password" name="password2" placeholder="Your Password" required>
						</p>
						<button type="submit" name="registerButton">SIGN UP</button>
						<div class="hasAccountText">
							<span id="hideRegister">Already have an account? Log in here.</span>
						</div>
					</form>
				</div>
				<!-- Right Section -->
				<div id="rightLoginText">
					<h1>Get best music right now</h1>
					<h2>Listen a lot of songs free</h2>
					<ul>
						<li>Find your favourite music</li>
						<li>Crete your own playlist</li>
						<li>follow your favourite artist</li>
						<li>Keep up to date with your favourite artist</li>
					</ul>
				</div>
			</div>
		</div>
	</body>
</html>
