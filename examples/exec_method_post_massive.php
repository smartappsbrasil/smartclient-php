<?php

    error_reporting(E_ALL);

    # Load S.M.A.R.T API Lib
    require("../config.php");
    require("../PHP/SMART_API.php");

    # EXECUTANDO MÉTODO

    $smartAPI = new SMARTAPI();
    $connMK = $smartAPI->connect("controls");

    $schemas = $smartAPI->getSchemas($connMK);
    $schema = $schemas->data[0];

    // multiple array - (tmd: transfer massive data)
    $postVars = "variavel[]=1&valor[]=60&variavel[]=1&valor[]=35&tmd=1";

    $valorGauge = $smartAPI->methodPost($connMK, $schema, 'variaveis_valores', $postVars, 'insert');

    echo "<pre>";
    print_r($valorGauge);
    echo "</pre>";

    $smartAPI->connectionClose();

?>
