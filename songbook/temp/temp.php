<?php
    /**
     * This class contain the all validate method for registerform.
     */
    class Account
    {
        private $con;  // this private variable help to connect the database.
        private $errorArray; //this array store the error message.
        //this code create the instance of the class.
        public function __construct($con)
        {
            $this->con = $con;
            $this->errorArray = array();//we assign the error to an array which store the error messages.
        }

        public function register($un, $fn, $ln, $em, $em2, $pw, $pw2){

            // means , this class's Instance have all this method.
            $this->toValidateUserName($un);
            $this->toValdateFirstName($fn);
            $this->toValidateLastName($ln);
            $this->toValidateEmail($em,$em2);
            $this->toValidatePassword($pw,$pw2);


            //if errorArray is empty then all condition is satisfied.
            if(empty($this->errorArray) == true){
                /*now Into to Database,if errorArray is empty,for that we create function gertIntoUserdeetails() and return it.,we write $this before
                gertIntoUserdeetails() beacuse it is aprivate function.*/
                return $this->gertIntoUserDetails($un, $fn, $ln, $em, $pw);
            }
            else{
                return false;
            }
        }

        //get error function
        public function getError($error){
            /*in_array(given function array, error array) function check that error is in errorArray or not*/
            if(!in_array($error, $this->errorArray)){
                //if error not found, then we set error as ""(empty string.);
                $error = "";
            }
            return "<span class='errorMessage'>$error</span>";
            //we also return html element in php through return.
        }

        private function gertIntoUserDetails($un, $fn, $ln, $em, $pw){
            $encrypted_password = md5($pw); //we use md6 encryption.
            $date = Date('Y-m-d');
            $profilePic = "assets/images/profile-pic/head_emerald.png";

            /*
            mysqli_query(connection,query,resultmode);
            you must write values between ''.
            */
            $result = mysqli_query($this->con,"INSERT INTO users VALUES('', '$un', '$fn', '$ln', '$em', '$encrypted_password', '$date', '$profilePic')");
            return $result;
        }

        /* Validate UserName Function */
        private function toValidateUserName($un){

            if(strlen($un) > 25 || strlen($un) <= 5 ){
                array_push($this->errorArray,Constants::$usernameCharacters);
                //assign var,message
                return;
            }

            //TODO: Check, If user already exits.It is easy.This logic same for email.
            $checkUserNameQuery = mysqli_query($this->con,"SELECT userName FROM users WHERE  userName='$un'");
            if(mysqli_num_rows($checkUserNameQuery) != 0){
                //this checked our selected username in table's existed rows.
                array_push($this->errorArray,Constants::$usernameTaken);
                //assign var,message
                return;
            }
        }

        /* Validate firstName Function */
        private function toValdateFirstName($fn){
            if(strlen($fn) > 25 || strlen($fn) < 2 ){
                array_push($this->errorArray,Constants::$firstNameCharacters);
                //assign var,message
                return;
            }

        }

        /* Validate lastName Function */
        private function toValidateLastName($ln){
            if(strlen($ln) > 25 || strlen($ln) < 2 ){
                array_push($this->errorArray,Constants::$lastNameCharacters);
                //assign var,message
                return;
            }

        }

        /* Validate Email Function */
        private function toValidateEmail($em,$em2){
            //validate email.
            if($em != $em2){
                array_push($this->errorArray,Constants::$emailsDoNotMatch);
            }

            /*
            (1)how though this part checked,wheather our email in correct format.
            (2)although we define the email as type is already check,email,but after @ if we write some text,not domain , then also it accepted as valid email.
            (3)For that we use filter_var() method,first attribute is variable and other is email format which is FILTER_VALIDATE_EMAIL , which check format of email also for .com,.in etc..
            (4)filter_var() method check, 2  variable.
            */

            if(!filter_var($em, FILTER_VALIDATE_EMAIL) ){
                array_push($this->errorArray,Constants::$emailInvalid);
                return;
            }

            /*TODO: Check that Username hasn't already been used.work for database section*/
            $checkEmailQuery = mysqli_query($this->con,"SELECT email FROM users WHERE  email='$em'");

            if(mysqli_num_rows($checkEmailQuery) != 0){
                //this checked our selected username in table's existed rows.
                array_push($this->errorArray,Constants::$emailTaken);
                //assign var,message
                return;
            }


        }

        /* Validate Password Function */
        private function toValidatePassword($pw,$pw2){
            if($pw != $pw2){
                array_push($this->errorArray,Constants::$passwordsDoNoMatch);
                return;
            }
            /*here preg_match fuction check patten with password.
                here ^ means not. IF pattern not match then password not valid.
            */
            if(preg_match("/[^A-Za-z0-9]/", $pw)){
                array_push($this->errorArray,Constants::$passwordNotAlphanumeric);
                return;
            }

            /*here we only check password not password2 beacuse, if passwprd != password2 then we return and functio stio beacuse we write the return , so other two function is not checked.*/

            if(strlen($pw) > 25 || strlen($pw) <=5 ){
                array_push($this->errorArray,Constants::$passwordCharacters);
                //array_push(var,message);
                return;
            }

        }

    }


?>

