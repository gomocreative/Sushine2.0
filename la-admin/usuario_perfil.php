<?php
require('main.php'); 
if( !boolThereLogin() )
    header('location:error.php');

$strAction = basename(__FILE__);
$strForm = 'frmUsuario';
$boolAlertaEliminar = false;
$boolAlertaCreada = isset($_GET['info']);
$boolAlertaModificada = false;

if( isset($_POST['hdnUsuario']) ) {
    $intUsuario = isset($_POST['hdnUsuario']) ? intval($_POST['hdnUsuario']) : 0;
    $intUsuarioTmp = $intUsuario;
    $strNombre = isset($_POST['txtNombre']) ? db_real_escape_string($_POST['txtNombre']) : '';
    $strCuenta = isset($_POST['txtCuenta']) ? db_real_escape_string($_POST['txtCuenta']) : '';
    $strEmail = isset($_POST['txtEmail']) ? db_real_escape_string($_POST['txtEmail']) : '';
    $strDireccion = isset($_POST['txtDireccion']) ? db_real_escape_string($_POST['txtDireccion']) : '';
    $strTelefono = isset($_POST['txtTelefono']) ? db_real_escape_string($_POST['txtTelefono']) : '';
    $strTipoUsuario = isset($_POST['sltTipoUsuario']) ? db_real_escape_string($_POST['sltTipoUsuario']) : '';
    $intActivo = isset($_POST['chkActivo']) ? 'Y' : 'N';
    if( $intUsuario > 0 ) {
        $boolPasswordCambiar = isset($_POST['chkPasswordCambiar']) ? true : false;
        $strPassword = "";
        if( $boolPasswordCambiar ) {
            $strPassword = isset($_POST['txtPassword']) ? db_real_escape_string($_POST['txtPassword']) : "";
        }
        if( !empty($strNombre) && !empty($strCuenta) && !empty($strTipoUsuario) ) {
            
            $strPassword = empty($strPassword) ? "" : "password = MD5('".$strPassword."'),";
            $strQuery ="UPDATE  usuario 
                        SET     nombre = '{$strNombre}',
                                cuenta = '{$strCuenta}',
                                {$strPassword}
                                tipo_usuario = '{$strTipoUsuario}',
                                activo =  '{$intActivo}',
                                email = '{$strEmail}',
                                direccion = '{$strDireccion}',
                                telefono = '{$strTelefono}',
                                mod_usuario = {$_SESSION['usuario']},
                                mod_fecha = now()
                        WHERE   usuario = {$intUsuario}";
            db_consulta($strQuery);
            $boolAlertaModificada = true;
        }
    }
    if( $intUsuarioTmp == 0 ) {
        header("location:{$strAction}?info=true");
    }
}

$objController = new usuario_perfil_controller();
$objController->submit();

drawHeader("LA-Admin - Perfil");
    $objController->drawContenido();
drawFooter();

class usuario_perfil_controller {

    public $objModel;
    public $objView;

    function __construct() {
        $this->objView = new usuario_perfil_view();
        $this->objModel = new usuario_perfil_model();
    }

    public function submit(){
        if( isset($_POST['hdnUsuario']) ) {
            $intUsuario = isset($_POST['hdnUsuario']) ? intval($_POST['hdnUsuario']) : 0;
            $intUsuarioTmp = $intUsuario;
            $strNombre = isset($_POST['txtNombre']) ? db_real_escape_string($_POST['txtNombre']) : '';
            $strCuenta = isset($_POST['txtCuenta']) ? db_real_escape_string($_POST['txtCuenta']) : '';
            $strEmail = isset($_POST['txtEmail']) ? db_real_escape_string($_POST['txtEmail']) : '';
            $strDireccion = isset($_POST['txtDireccion']) ? db_real_escape_string($_POST['txtDireccion']) : '';
            $strTelefono = isset($_POST['txtTelefono']) ? db_real_escape_string($_POST['txtTelefono']) : '';
            $strTipoUsuario = isset($_POST['sltTipoUsuario']) ? db_real_escape_string($_POST['sltTipoUsuario']) : '';
            $intActivo = isset($_POST['chkActivo']) ? 'Y' : 'N';
            if( $intUsuario > 0 ) {
                $boolPasswordCambiar = isset($_POST['chkPasswordCambiar']) ? true : false;
                $strPassword = "";
                if( $boolPasswordCambiar ) {
                    $strPassword = isset($_POST['txtPassword']) ? db_real_escape_string($_POST['txtPassword']) : "";
                }
                if( !empty($strNombre) && !empty($strCuenta) && !empty($strTipoUsuario) ) {
                    
                    $strPassword = empty($strPassword) ? "" : "password = MD5('".$strPassword."'),";
                    $strQuery ="UPDATE  usuario 
                                SET     nombre = '{$strNombre}',
                                        cuenta = '{$strCuenta}',
                                        {$strPassword}
                                        tipo_usuario = '{$strTipoUsuario}',
                                        activo =  '{$intActivo}',
                                        email = '{$strEmail}',
                                        direccion = '{$strDireccion}',
                                        telefono = '{$strTelefono}',
                                        mod_usuario = {$_SESSION['usuario']},
                                        mod_fecha = now()
                                WHERE   usuario = {$intUsuario}";
                    db_consulta($strQuery);
                    $this->objView->strAlertaTipo = "update";
                }
            }
        }
    }
    
    public function drawContenido() {
        $this->objView->drawContenido();
    }

}
class usuario_perfil_view {
    
    public $objModel;
    public $strAlertaTipo = "";

    function __construct() {
        $this->objModel = new usuario_perfil_model();
    }
    
    function drawContenido() {
        global $strAction,$strForm;
        $intUsuario = $_SESSION['usuario'];
        if( $intUsuario > 0 ) {
            $arrData = array();
            $strQuery = "SELECT usuario,
                                nombre,
                                cuenta,
                                tipo_usuario,
                                activo,
                                email,
                                direccion,
                                telefono
                         FROM   usuario
                         WHERE  usuario = {$intUsuario}";
                         
            $qTMP = db_consulta($strQuery);
            while( $rTMP = db_fetch_assoc($qTMP) ) {
                $arrData = $rTMP;
            }
            db_free_result($qTMP);
            ?>
            <form name="<?php print  $strForm; ?>" id="<?php print $strForm; ?>" method="post" action="<?php print $strAction; ?>" class="form-horizontal">
                <div id="page-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <ol class="breadcrumb">
                                <li><a href="index.php">Inicio</a></li>
                                <li><a href="<?php print $strAction; ?>">Perfil</a></li>
                                <li class="active"><?php print isset($arrData['nombre']) ? $arrData['nombre'] : 'Nuevo usuario'; ?></li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <button type="button" class="btn btn-success btn-sm" onclick="fntGuardar();">
                                        <span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Guardar
                                    </button>
                                </div>
                                <div class="panel-body">
                                    <input type="hidden" name="hdnUsuario" value="<?php print $intUsuario; ?>" readonly="readonly">
                                    <input type="hidden" name="chkActivo" id="chkActivo" value="1" <?php print isset($arrData['activo']) && $arrData['activo'] == 'Y' ? 'checked="checked"' : ''; ?>>
                                    <div class="form-group has-feedback" id="txtNombreGrupo">
                                        <label for="txtNombre" class="col-lg-3 col-lg-offset-1 control-label">Nombre *</label>
                                        <div class="col-lg-5">
                                            <input type="text" name="txtNombre" id="txtNombre" value="<?php print isset($arrData['nombre']) ? $arrData['nombre'] : ''; ?>" class="form-control input-sm" autofocus="autofocus" maxlength="75" required="required" aria-describedby="txtNombreEstado">
                                            <span id="txtNombreIcono" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span id="txtNombreMensaje" class="sr-only">(Este campo es requerido)</span>
                                        </div>
                                    </div>
                                    <div class="form-group" id="txtCuentaGrupo">
                                        <label for="txtCuenta" class="col-lg-3 col-lg-offset-1 control-label">Cuenta *</label>
                                        <div class="col-lg-5 form-control-static">
                                            <input type="hidden" name="txtCuenta" value="<?php print $arrData['cuenta']; ?>" readonly="readonly">
                                            <?php print $arrData['cuenta']; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                        if( $intUsuario == 0 ) {
                                            ?>
                                            <label for="chkPasswordAleatoria" class="col-lg-3 col-lg-offset-1 control-label">Generar contraseña aleatoria</label>
                                            <div class="col-lg-5 form-control-static">
                                                <input type="checkbox" name="chkPasswordAleatoria" id="chkPasswordAleatoria" value="1">
                                            </div>
                                            <?php
                                        }
                                        else {
                                            ?>
                                            <label for="chkPasswordCambiar" class="col-lg-3 col-lg-offset-1 control-label">Cambiar contraseña</label>
                                            <div class="col-lg-5 form-control-static">
                                                <input type="checkbox" name="chkPasswordCambiar" id="chkPasswordCambiar" value="1">
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group has-feedback" id="txtPasswordGrupo" <?php print $intUsuario == 0 ? "" : "style='display: none'"; ?>>
                                        <label for="txtPassword" class="col-lg-3 col-lg-offset-1 control-label">Contraseña *</label>
                                        <div class="col-lg-5">
                                            <input type="password" name="txtPassword" id="txtPassword" value="" class="form-control input-sm" maxlength="33" <?php print $intUsuario == 0 ? "required='required'" : ""; ?>>
                                            <span id="txtPasswordIcono" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span id="txtPasswordMensaje" class="sr-only">(Este campo es requerido)</span>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback" id="txtConfirmarPasswordGrupo" <?php print $intUsuario == 0 ? "" : "style='display: none'"; ?>>
                                        <label for="txtConfirmarPassword" class="col-lg-3 col-lg-offset-1 control-label">Confirmar Contraseña *</label>
                                        <div class="col-lg-5">
                                            <input type="password" name="txtConfirmarPassword" id="txtConfirmarPassword" value="" class="form-control input-sm" maxlength="33" <?php print $intUsuario == 0 ? "required='required'" : ""; ?>>
                                            <span id="txtConfirmarPasswordIcono" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span id="txtConfirmarPasswordMensaje" class="sr-only">(Este campo es requerido)</span>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback" id="txtEmailGrupo">
                                        <label for="txtEmail" class="col-lg-3 col-lg-offset-1 control-label">Correo electrónico *</label>
                                        <div class="col-lg-5">
                                            <input type="text" name="txtEmail" id="txtEmail" value="<?php print isset($arrData['email']) ? $arrData['email'] : ''; ?>" class="form-control input-sm" maxlength="255" required="required">
                                            <span id="txtEmailIcono" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span id="txtEmailMensaje" class="sr-only">(Este campo es requerido)</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtDireccion" class="col-lg-3 col-lg-offset-1 control-label">Dirección</label>
                                        <div class="col-lg-5">
                                            <textarea name="txtDireccion" id="txtDireccion" class="form-control input-sm"><?php print isset($arrData['direccion']) ? $arrData['direccion'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtTelefono" class="col-lg-3 col-lg-offset-1 control-label">Teléfono</label>
                                        <div class="col-lg-5">
                                            <input type="text" name="txtTelefono" id="txtTelefono" value="<?php print isset($arrData['telefono']) ? $arrData['telefono'] : ''; ?>" class="form-control input-sm" maxlength="255">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sltTipoUsuario" class="col-lg-3 col-lg-offset-1 control-label">Tipo de usuario</label>
                                        <div class="col-lg-5 form-control-static">
                                            <input type="hidden" name="sltTipoUsuario" value="<?php print $arrData['tipo_usuario']; ?>" readonly="readonly">
                                            <?php print ucfirst($arrData['tipo_usuario']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        function fntGuardar() {
                            boolCorrecto = true;
                            boolCorrecto = fntCamposRequeridosEach(boolCorrecto);
                            if( boolCorrecto ) {
                                $("#<?php print $strForm; ?>").submit();    
                            }

                        }

                        function fntCamposRequeridosChange() {
                            $("[required='required']").change( function() {
                                if( $(this).val().length == 0 ) {
                                    $("#"+$(this).attr("name")+"Grupo").removeClass("has-success").addClass("has-error");
                                    $("#"+$(this).attr("name")+"Icono").removeClass("glyphicon-ok").addClass("glyphicon-remove");
                                    $("#"+$(this).attr("name")+"Mensaje").removeClass("sr-only");
                                }
                                else {
                                    $("#"+$(this).attr("name")+"Grupo").removeClass("has-error").addClass("has-success");
                                    $("#"+$(this).attr("name")+"Icono").removeClass("glyphicon-remove").addClass("glyphicon-ok");
                                    $("#"+$(this).attr("name")+"Mensaje").addClass("sr-only");
                                }
                            });
                        }
                        
                        function fntCamposRequeridosEach(boolCorrecto) {
                            boolCorrecto = boolCorrecto;
                            $("[required='required']").each( function() {
                                if( $(this).val().length == 0 ) {
                                    $("#"+$(this).attr("name")+"Grupo").removeClass("has-success").addClass("has-error");
                                    $("#"+$(this).attr("name")+"Icono").removeClass("glyphicon-ok").addClass("glyphicon-remove");
                                    $("#"+$(this).attr("name")+"Mensaje").removeClass("sr-only");
                                    boolCorrecto = false;
                                }
                                else {
                                    $("#"+$(this).attr("name")+"Grupo").removeClass("has-error").addClass("has-success");
                                    $("#"+$(this).attr("name")+"Icono").removeClass("glyphicon-remove").addClass("glyphicon-ok");
                                    $("#"+$(this).attr("name")+"Mensaje").addClass("sr-only");
                                }
                            });
                            return boolCorrecto;
                        }

                        $(function() {
                            fntCamposRequeridosChange();
                            $("#txtPassword").val("");
                            $("#txtConfirmarPassword").val("");
                            $("#chkPasswordAleatoria").click(function() {
                                if( $(this).prop("checked") ) {
                                    $("#txtPasswordGrupo").hide();
                                    $("#txtConfirmarPasswordGrupo").hide();
                                    $("#txtPassword").val("").removeAttr("required");
                                    $("#txtConfirmarPassword").val("").removeAttr("required");
                                    $("#txtConfirmarPasswordGrupo").hide();
                                    $("#txtPasswordGrupo").removeClass("has-error").removeClass("has-success");
                                    $("#txtPasswordIcono").removeClass("glyphicon-remove").removeClass("glyphicon-ok");
                                    $("#txtPasswordMensaje").addClass("sr-only");
                                    $("#txtConfirmarPasswordGrupo").removeClass("has-error").removeClass("has-success");
                                    $("#txtConfirmarPasswordIcono").removeClass("glyphicon-remove").removeClass("glyphicon-ok");
                                    $("#txtConfirmarPasswordMensaje").addClass("sr-only");
                                    fntCamposRequeridosChange();
                                }
                                else {
                                    $("#txtPassword").val("").attr("required","required");
                                    $("#txtConfirmarPassword").val("").attr("required","required");
                                    $("#txtPasswordGrupo").show();
                                    $("#txtConfirmarPasswordGrupo").show();
                                    fntCamposRequeridosChange();
                                }
                            });
                            $("#chkPasswordCambiar").click(function() {
                                if( $(this).prop("checked") ) {
                                    $("#txtPassword").val("").attr("required","required");
                                    $("#txtConfirmarPassword").val("").attr("required","required");
                                    $("#txtPasswordGrupo").show();
                                    $("#txtConfirmarPasswordGrupo").show();
                                    fntCamposRequeridosChange();
                                }
                                else {
                                    $("#txtPasswordGrupo").hide();
                                    $("#txtConfirmarPasswordGrupo").hide();
                                    $("#txtPassword").val("").removeAttr("required");
                                    $("#txtConfirmarPassword").val("").removeAttr("required");
                                    $("#txtConfirmarPasswordGrupo").hide();
                                    $("#txtPasswordGrupo").removeClass("has-error").removeClass("has-success");
                                    $("#txtPasswordIcono").removeClass("glyphicon-remove").removeClass("glyphicon-ok");
                                    $("#txtPasswordMensaje").addClass("sr-only");
                                    $("#txtConfirmarPasswordGrupo").removeClass("has-error").removeClass("has-success");
                                    $("#txtConfirmarPasswordIcono").removeClass("glyphicon-remove").removeClass("glyphicon-ok");
                                    $("#txtConfirmarPasswordMensaje").addClass("sr-only");
                                    fntCamposRequeridosChange();
                                }
                            });
                        });
                    </script>
                </div>
            </form>
            <?php
        }
    }
}

class usuario_perfil_model {
    
    function __construct() {
        
    }
    
}
?>