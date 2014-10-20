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

    // simple array
    $postVars = array('variavel' => '1', 'valor' => 60);

    $valorGauge = $smartAPI->methodPost($connMK, $schema, 'variaveis_valores', $postVars, 'insert');

    echo "<pre>";
    print_r($valorGauge);
    echo "</pre>";

    $smartAPI->connectionClose();

?>
