<?php

# REQUISITANDO DADOS PUROS DE UM FORM

# Load S.M.A.R.T API Lib
require("../config.php");

$smartAPI = new SMARTAPI();
$connMK = $smartAPI->connect("controls");
echo "oie";
$schemas = $smartAPI->getSchemas($connMK);
$schema = $schemas->data[0];

$data = $smartAPI->getData($connMK, $schema, "variaveis_valores/_last");

echo "<pre>";
print_r($data);
echo "</pre>";

$smartAPI->connectionClose();

?>
