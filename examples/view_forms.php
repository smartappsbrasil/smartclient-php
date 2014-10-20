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

    $forms = $smartAPI->getForms($connMK, $schema);

    echo "<pre>";
    print_r($forms);
    echo "</pre>";

    $smartAPI->connectionClose();

?>
