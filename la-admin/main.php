<?php
ini_set('default_charset', 'ISO-8859-1');
date_default_timezone_set("America/Guatemala");
session_start();
include('configuracion.php');
include('db_mysqli.php');
$objConexion = db_conectar(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_DBNAME);
include('functions.php');