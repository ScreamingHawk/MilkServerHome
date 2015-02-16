<?php

$mysqli = new mysqli($_SERVER['DB_HOST'], $_SERVER['DB_USER'], $_SERVER['DB_PASSWORD'], $_SERVER['DB_DB_NAME'], $_SERVER['DB_DB_PORT']);

// Force database update
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/db_create.php';