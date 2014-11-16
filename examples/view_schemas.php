<?php

    error_reporting(E_ALL);

    # Load S.M.A.R.T API Lib
    require("../config.php");

    # EXECUTANDO MÉTODO

    $smartAPI = new SMARTAPI();
    $connMK = $smartAPI->connect("controls");

    $schemas = $smartAPI->getSchemas($connMK);

    echo "<pre>";
    print_r($schemas);
    echo "</pre>";

    $smartAPI->connectionClose();

?>
