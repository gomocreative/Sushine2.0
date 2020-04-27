<?php
require_once("configuracion_general_view.php");
require_once("configuracion_general_model.php");

class configuracion_general_controller {
    
    public $objView;
    public $objModel;
    
    function __construct() {
        $this->objView = new configuracion_general_view();
        $this->objModel = new configuracion_general_model();
    }
    
    public function submit(){
        if( isset($_POST["hdnGeneral"]) ) {
            
            while( $arrP = each($_POST) ) {
                $this->objModel->updateConfiguracionGeneral($arrP["key"],$arrP["value"]);
            }
            $this->objView->strAlertaTipo = "update";

        }
    }
    
    public function drawContenido() {
        $this->objView->drawContenido();
    }
    
}