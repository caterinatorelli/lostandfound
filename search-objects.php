<?php
require_once("templates/bootstrap.php");

$templateParams["titolo"] = "Lost and Found - Cerca Oggetti";
$templateParams["nome"] = "components/search-form.php";

require_once(__DIR__ . "/utils/functions.php");

$items = $db_obj->getFoundObjects();
$templateParams["items"] = $items;

require_once("templates/base.php");
?>