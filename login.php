<?php
require_once( 'LoginDataModel.php' );
require_once( 'FxDataModel.php' );


//Invoke LoginDataModel & Methods
$loginDM = new LoginDataModel();
$fxDModel = new FxDataModel();
$iniLoginArray = $loginDM->getIniLoginArray();
$iniNameArray = $loginDM->getIniNameArray();


//key boolean condition


if (array_key_exists($iniLoginArray[LoginDataModel::USERNAME], $_POST)) {

    $username = $_POST[$iniLoginArray[LoginDataModel::USERNAME]];

    $password = $_POST[$iniLoginArray[LoginDataModel::PASSWORD]];

    if ($loginDM->validateUsers($username, $password)) {

        //Start the Session
        session_start();

        unset($_SESSION[FxDataModel::SESSION_IN_PROGRESS]);


        $_SESSION[FxDataModel::SESSION_IN_PROGRESS] = $username;
        

        include 'fxCalc.php';
        exit();
    } else {

        $username = '';

        $password = '';
    }
} else {

    $username = '';

    $password = '';
}
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <title>F/X Calculator - Login</title>
    </head>

    <body>

        <!--App Title-->
        <h1 align="center">Money Banks Login</h1>
        <hr/><br/>

        <!--FORM-->
        <form name="login" action="login.php" method="post">

            <center>

                <label class="username">Username:</label>
                <input type="text" placeholder="<?php echo $username ?>" name="<?php echo $iniLoginArray[LoginDataModel::USERNAME] ?>" required/>
                <br><br>         
                <label class="password">Password:</label>
                <input type="password" placeholder="<?php echo $password ?>" name="<?php echo $iniLoginArray[LoginDataModel::PASSWORD] ?>" required autocomplete="off"/>
                <br/><br/>

                <input type="submit" value="Login"/>

                <input type="reset"/>

            </center>
        </form>

    </body>
</html>

