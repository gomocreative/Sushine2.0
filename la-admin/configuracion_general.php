<?php
require('main.php'); 
if( !boolThereLogin() )
    header('location:error.php');
    
require_once("modulos/configuracion/configuracion_general_controller.php");

$strDirectorio = str_replace(DIRECTORY_SEPARATOR,"/",str_replace(str_replace("/",DIRECTORY_SEPARATOR,$_SERVER["DOCUMENT_ROOT"]),"",__DIR__));
$arrDirectorio = explode("/",$strDirectorio);
$strDirectorioBase = "";
while( $arrD = each($arrDirectorio) ) {
    $strDirectorioBase .= "../";
}

$strAction = basename(__FILE__);
$objController = new configuracion_general_controller();
$objController->submit();

drawHeader("LA-Admin - General");
    $objController->drawContenido();
drawFooter();