<?php
    function sanatizeFormUserName($inputText)
    {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        return $inputText;
    }

    function sanatizeFormPassword($inputText)
    {
        $inputText = strip_tags($inputText);
        return $inputText;
    }

    //temparory.
    function sanatizeFormEmail($inputText)
    {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ","",$inputText);


        return $inputText;
    }

    function sanatizeFormString($inputText)
    {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ","",$inputText);
        $inputText = ucfirst(strtolower($inputText));

        return $inputText;
    }

    if(isset($_POST['registerButton'])){
        // echo "Register Button Clilcked.";
        // $username = _POST('userName');
        // //to remove any html tag or something use strip_tags() function
        // $username = strip_tags($username);

        // //to remove space in userName,
        // //use str_replace(given,replace doing,variable)
        // $username = str_replace(" ","",$username);

        //to convert fisrtname in Uppercase,use ucfirst(),it may be posible thar user put some uppercase in lower name so ,first we transform string into lowercase using strtolower(),after that ucfirst().

        // $firstName = _POST('firstName');
        // $firstName  = strtolower($firstName);
        // $firstName = strip_tags($firstName);

        //to remove this hardcoded,text we set the function(){}
        $username = sanatizeFormUserName($_POST['userName']);
        $fisrtname = sanatizeFormString($_POST['firstName']);
        $lastname = sanatizeFormString($_POST['lastName']);
        $email = sanatizeFormEmail($_POST['email']);
        $email2 = sanatizeFormEmail($_POST['email2']);
        $password = sanatizeFormPassword($_POST['password']);
        $password2 = sanatizeFormPassword($_POST['password2']);

        //validate the user data:to handle many of this function we need one class which handle this functions.
        // toValidateUserName($username);
        // toValdateFirstName($firstname);
        // toValidateLastName($lastname);
        // toValidateEmail($email,$email2);
        // toValidatePassword($password,$password2);

        //we call this file from the Account class,by create it's instance.

        // $account = new Account();

        //$wasSignUPSuccessful variable store account class register() method return type.
        $wasSignUPSuccessful =  $account->register($username, $fisrtname, $lastname, $email ,$email2, $password, $password2);

        if($wasSignUPSuccessful == true){
            //header() fuction take us on given location,here index.php
            $_SESSION['userLoggedIn'] = $username;
            header("Location: index.php");
        }

    }


?>
