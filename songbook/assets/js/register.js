// jquery syntax
$(document).ready(function(){

    console.log('document is ready.');
    //by writing $(".hideLogin") jquery create element object

    // code for hide login
    $("#hideLogin").click(function(){
        console.log('login hide button was pressed.');
        $("#loginForm").hide(); //when click on span,hide the login form
        $("#registerForm").show(); //show the registerform
    });

    // code for hide login
    $("#hideRegister").click(function(){
        console.log('register hide button was pressed.');
        $("#registerForm").hide(); //when click on span,hide the login form
        $("#loginForm").show(); //show the registerform
    });
});
