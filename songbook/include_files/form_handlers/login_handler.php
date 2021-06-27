<?php

 if(isset($_POST['loginButton'])){
    //logic button pressed.
    $username = $_POST['loginUserName'];
    $password = $_POST['loginUserPassword'];

    //calling login function which is in Account.php ,and it is public.
    $result = $account->login($username, $password);

    if($result == true){
        // $_SESSION['session match username'] = $loginUsername;
        $_SESSION['userLoggedIn'] = $username;
        header("Location: index.php");
    }
 }

?>
