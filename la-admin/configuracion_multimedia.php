<?php
require('main.php'); 
if( !boolThereLogin() )
    header('location:error.php');

$strAction = basename(__FILE__);
$objController = new configuracion_multimedia_controller();
$objController->submit();

drawHeader("Sepco - Multimedia");
$objController->drawContenido();
drawFooter();
    
class configuracion_multimedia_controller {
    
    public $objModel;
    public $objView;
    public $strAlertaTipo = "";
    
    function __construct() {
        $this->objView = new configuracion_multimedia_view();
        $this->objModel = new configuracion_multimedia_model();
    }
    
    public function submit(){
        $boolEdicion = false;
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

class configuracion_multimedia_view {
    
    public $objModel;
    public $strAlertaTipo = "";

    function __construct() {
        $this->objModel = new configuracion_multimedia_model();
    }

    function drawContenido() {
        global $strAction, $boolEdicion;
        ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li><a href="index.php">Inicio</a></li>
                        <li><a href="<?php print $strAction; ?>" class="active">Configuración</a></li>
                        <li><a href="<?php print $strAction; ?>" class="active">Multimedia</a></li>
                    </ol>
                </div>
            </div>
            <?php
            if( $this->strAlertaTipo == "update" ) {
                ?>
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3">
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <span class="glyphicon glyphicon-info-sign"></span>&nbsp;<strong>información:</strong>&nbsp;Configuración general guardada exitosamente.
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <form name="frmGeneral" id="frmGeneral" class="form-horizontal" method="POST">
                <input type="hidden" name="hdnGeneral" value="1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <iframe  width="100%" height="550" frameborder="0" src="../../filemanager/dialog.php?type=0">
                        </iframe>
                    </div>
                </div>
            </form>
        </div>
        <?php
    }

}

class configuracion_multimedia_model {
    
    function __construct() {
        
    }
    
    public function getConfiguracionGeneral() {
        $arrData = array();
        
        $strQuery ="SELECT  codigo,nombre,valor,tipo,ancho,alto
                    FROM    configuracion_general
                    WHERE   activo = 'Y'
                    ORDER BY orden";
        $qTMP = db_consulta($strQuery);
        while( $rTMP = db_fetch_assoc($qTMP) ) {
            $arrData[$rTMP["codigo"]] = $rTMP;
        }
        db_free_result($qTMP);
        
        return $arrData;
        
    }
    
    public function updateConfiguracionGeneral($strCodigo, $strValor) {
        $strQuery = "UPDATE configuracion_general SET valor = '{$strValor}' WHERE codigo = '{$strCodigo}'";
        db_consulta($strQuery);
    }
    
}
?>