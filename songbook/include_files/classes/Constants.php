<?php
class Constants {

    //static means it is not acced by Instace of class, Instead of it's only accessed by Class.

    /* Constant messages for Login Form.    */
    public static $loginFailed = "Your username or password was incorrect";


    /* Constant messages for Register Form.    */
    // stored error message for USERNAME.
    public static $usernameCharacters = "Your username must be between 5 and 25 characters";
    public static $usernameTaken = "This Username is already Taken.";



    // stored error message for FIRSTNAME AND LASTNAME.
    public static $firstNameCharacters = "Your first name must be between 2 and 25 characters";
    public static $lastNameCharacters = "Your last name must be between 2 and 25 characters";

    // stored error message for EMAIL.
    public static $emailInvalid = "Email is invalid";
    public static $emailsDoNotMatch = "Your emails don't match";
    public static $emailTaken = "This Email is already Taken.";



    // stored error message for password.
    public static $passwordsDoNoMatch = "Your passwords don't match";
    public static $passwordNotAlphanumeric = "Your password can only contain numbers and letters";
    public static $passwordCharacters = "Your password must be between 5 and 30 characters";

}

?>
