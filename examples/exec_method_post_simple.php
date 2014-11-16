<?php

    error_reporting(E_ALL);

    # Load S.M.A.R.T API Lib
    require("../config.php");

    # EXECUTANDO MÉTODO

    $smartAPI = new SMARTAPI();
    $connMK = $smartAPI->connect("controls");

    $schemas = $smartAPI->getSchemas($connMK);
    $schema = $schemas->data[0];

    // simple array
    $postVars = array('variavel' => '1', 'valor' => 60);

    $execInsert = $smartAPI->methodPost($connMK, $schema, 'variaveis_valores', $postVars, 'insert');

    echo "<pre>";
    print_r($execInsert);
    echo "</pre>";

    $smartAPI->connectionClose();

?>
