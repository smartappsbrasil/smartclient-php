<?php

error_reporting(E_ALL);

require("../config.php");

# Instance S.M.A.R.T API Class
$SMARTAPI = new SMARTAPI();

$connMK = $SMARTAPI->connect("controls");

$schemas = $SMARTAPI->getSchemas($connMK);

if (!empty($schemas->data[0])) {
	echo "Works!";
} else {
	echo "Don't work :'(";
}

$SMARTAPI->connectionClose();

?>