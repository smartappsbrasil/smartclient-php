<?php

    error_reporting(E_ALL);

    # Load S.M.A.R.T API Lib
    require("../config.php");
    require("../PHP/SMART_API.php");

    # EXECUTANDO MÉTODO

    $smartAPI = new SMARTAPI();
    $connMK = $smartAPI->connect("maany");

    $schemas = $smartAPI->getSchemas($connMK);
    $schema = $schemas->data[0];

    $horasDetalhadas = $smartAPI->method($connMK, $schema, 'getClientesHorasDetalhes','1,2013-01-01,2013-05-31');

    echo "<pre>";
    print_r($horasDetalhadas);
    echo "<br>";
    print_r(json_decode($horasDetalhadas->data));
    echo "</pre>";

    $smartAPI->connectionClose();

?>
