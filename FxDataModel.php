<?php

//Global Constant
define('INI_FILE', "fxCalc.ini");

class FxDataModel {

    //Class constants
    const DST_AMT_KEY = 'dst.amt';
    const DST_CUCY_KEY = 'dst.cucy';
    const CSV_FILE = 'fx.rates.file';
    const SRC_AMT_KEY = 'src.amt';
    const SRC_CUCY_KEY = 'src.cucy';
    const SESSION_IN_PROGRESS = 'fx.skey';

    private $iniArray;
    private $fxCurrencies;
    private $fxRates;

    //Constructor
    function __construct() {

        //Parse ini file
        $this->iniArray = parse_ini_file(INI_FILE);
        $extractCsv = fopen($this->iniArray[FxDataModel::CSV_FILE], "r");
        $this->fxCurrencies = (fgetcsv($extractCsv));

        //Rates iterations
        while (!feof($extractCsv)) {
            $setFxRates = fgetcsv($extractCsv);
            if ($setFxRates === false)
                continue;
            $this->fxRates[] = $setFxRates;
        }
        fclose($extractCsv);
    }

    //Getters
    public function getFxCurrencies() {
        return $this->fxCurrencies;
    }

    public function getFxRate($srcCucy, $dstCucy) {
        $in = 0;
        $len = count($this->fxCurrencies);
        $out = 0;

        for (; $in < $len; $in++) {
            if ($this->fxCurrencies[$in] == $srcCucy) {
                break;
            }
        }

        for (; $out < $len; $out++) {
            if ($this->fxCurrencies[$out] == $dstCucy) {
                break;
            }
        }

        return $this->fxRates[$in][$out];
    }

    public function getIniArray() {
        return $this->iniArray;
    }

}

?>
