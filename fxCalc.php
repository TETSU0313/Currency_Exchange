<!DOCTYPE html>

<?php
require_once( 'FxDataModel.php' );
require_once( 'LoginDataModel.php' );


//Invoke FxDataModel & Methods
$fxDModel = new FxDataModel();
$loginDM2 = new LoginDataModel();
$iniArray = $fxDModel->getIniArray();
$fxCurrencies = $fxDModel->getFxCurrencies();
$_SESSION['fxDModel'] = serialize($fxDModel);
$fxDModel = unserialize($_SESSION['fxDModel']);

//}
if (!(isset($_SESSION['fxDModel']))) {
    session_start();
    include 'login.php';
    exit();
} 
//echo 'session: ';
//print_r($_SESSION['fx.skey']);

if (array_key_exists($iniArray[FxDataModel::SRC_AMT_KEY], $_POST)) {
    $srcAmt = $_POST[$iniArray[FxDataModel::SRC_AMT_KEY]];
    if (is_numeric($srcAmt)) {
        $dstCucy = $_POST[$iniArray[FxDataModel::DST_CUCY_KEY]];
        $srcCucy = $_POST[$iniArray[FxDataModel::SRC_CUCY_KEY]];

        $dstAmt = $fxDModel->getFxRate($srcCucy, $dstCucy) * $srcAmt;
    } else {
        $dstAmt = '';
        $dstCucy = $fxCurrencies[0];
        $srcAmt = '';
        $srcCucy = $fxCurrencies[0];
    }
} else {
    $dstAmt = '';
    $dstCucy = $fxCurrencies[0];
    $srcAmt = '';
    $srcCucy = $fxCurrencies[0];
}
?>

<!--HTML documentation-->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <title>F/X Calculator</title>
    </head>

    <body>

        <!--App Title-->
        <h1 align="center">Money Banks F/X Calculator</h1>
        <hr/><br/>
        <!--FORM-->
        <form name="fxCalc" action="fxCalc.php" method="post">

            <center>
                <h2>Welcome <?php echo $_SESSION[FxDataModel::SESSION_IN_PROGRESS] ?></h2>
                <!--Input currency selector-->
                <select name="<?php echo $iniArray[FxDataModel::SRC_CUCY_KEY] ?>">
                    <?php
                    foreach ($fxCurrencies as $fxCurrency) {
                        ?>
                        <option value="<?php echo $fxCurrency ?>"
                        <?php
                        if ($fxCurrency === $srcCucy) {
                            ?>   
                                    selected
                                    <?php
                                }
                                ?>
                                ><?php echo $fxCurrency ?></option>
                                <?php
                            }
                            ?>
                </select>
                <!--Output currency selector-->
                <input type="text" name="<?php echo $iniArray[FxDataModel::SRC_AMT_KEY] ?>" value="<?php echo $srcAmt ?>" autocomplete="off"/>
                <select name="dstCucy">
                    <?php
                    foreach ($fxCurrencies as $fxCurrency) {
                        ?>
                        <option value="<?php echo $fxCurrency ?>"
                        <?php
                        if ($fxCurrency === $dstCucy) {
                            ?>
                                    selected
                                    <?php
                                }
                                ?>
                                ><?php echo $fxCurrency ?></option>
                                <?php
                            }
                            ?>
                </select>
                <!--Output field-->
                <input type="text" name="<?php echo $iniArray[FxDataModel::DST_AMT_KEY] ?>" disabled="disabled" value="<?php echo $dstAmt ?>"/>

                <br/><br/>

                <!--Convert Button-->
                <input type="submit" value="Convert"/>

                <!--Reset button will not work unless Javascript implemented-->
                <input type="reset"/>

            </center>
        </form>

    </body>
</html>
