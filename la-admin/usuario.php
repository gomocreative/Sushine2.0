<?php
require('main.php'); 
if( !boolThereLogin() )
    header('location:error.php');

$strAction = basename(__FILE__);
$strForm = 'frmUsuario';
$boolAlertaEliminar = false;
$boolAlertaCreada = isset($_GET['info']);
$boolAlertaModificada = false;

if( isset($_POST['hdnEliminar']) && intval($_POST['hdnEliminar']) > 0 ) {
    $intUsuario = isset($_POST['hdnEliminar']) ? $_POST['hdnEliminar'] : 0;
    $strQuery ="UPDATE  usuario
                SET     activo = 'Y',
                        eliminado = 'Y'
                WHERE   usuario = {$intUsuario}";
    db_consulta($strQuery);
    $boolAlertaEliminar = true;
}
elseif( isset($_POST['hdnUsuario']) ) {
    
    $intUsuario = isset($_POST['hdnUsuario']) ? intval($_POST['hdnUsuario']) : 0;
    $intUsuarioTmp = $intUsuario;
    $strNombre = isset($_POST['txtNombre']) ? db_real_escape_string($_POST['txtNombre']) : '';
    $strCuenta = isset($_POST['txtCuenta']) ? db_real_escape_string($_POST['txtCuenta']) : '';
    $strEmail = isset($_POST['txtEmail']) ? db_real_escape_string($_POST['txtEmail']) : '';
    $strDireccion = isset($_POST['txtDireccion']) ? db_real_escape_string($_POST['txtDireccion']) : '';
    $strTelefono = isset($_POST['txtTelefono']) ? db_real_escape_string($_POST['txtTelefono']) : '';
    $strTipoUsuario = isset($_POST['sltTipoUsuario']) ? db_real_escape_string($_POST['sltTipoUsuario']) : '';
    $intActivo = isset($_POST['chkActivo']) ? 'Y' : 'N';
    if( $intUsuario == 0 ) {
        $boolPasswordAleatoria = isset($_POST['chkPasswordAleatoria']) ? true : false;
        $strPassword = "";
        if( $boolPasswordAleatoria ) {
            $strPassword = substr(uniqid(), -6);
        }
        else {
            $strPassword = isset($_POST['txtPassword']) ? db_real_escape_string($_POST['txtPassword']) : "";
        }
        if( !empty($strNombre) && !empty($strEmail) && !empty($strPassword) && !empty($strTipoUsuario) ) {
            $strQuery ="INSERT INTO usuario(nombre,cuenta,password,tipo_usuario,activo,email,direccion,telefono,add_usuario,add_fecha) 
                        VALUES ('{$strNombre}','{$strCuenta}',MD5('{$strPassword}'),'{$strTipoUsuario}','{$intActivo}','{$strEmail}','{$strDireccion}','{$strTelefono}',{$_SESSION['usuario']},now())";
            db_consulta($strQuery);
            $intUsuario = db_insert_id();
            
            $strMessage = "Estimado(a) {$strNombre},<br/><br/>Te damos la bienvenida a nuestro portal.<br><br>Para acceder al portal ingresa al siguiente link <a href=''>Link</a> con el siguiente usuario y contraseña.<br/><br/>Usuario:&nbsp;{$strEmail}<br/>Contraseña:&nbsp;{$strPassword}<br/><br/>Saludos cordiales,<br/>Webmaster";
            
            $strFrom = "webmaster@dominio.com";                           
            $strSubject = "Acceso a portal";
            $intUniqId = md5(uniqid(time()));
            
            $strHeader = "From: ".$strFrom."\r\n";
            $strHeader .= "MIME-Version: 1.0\r\n";
            $strHeader .= "Content-Type: multipart/mixed; boundary=\"".$intUniqId."\"\r\n\r\n";
            $strHeader .= "This is a multi-part message in MIME format.\r\n";
            $strHeader .= "--".$intUniqId."\r\n";
            $strHeader .= "Content-type:text/html; charset=iso-8859-1\r\n";
            $strHeader .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
            $strHeader .= $strMessage."\r\n\r\n";
            $strHeader .= "--".$intUniqId."\r\n";
            
            @mail($strEmail, $strSubject, "", $strHeader);
            
        }
    }
    elseif( $intUsuario > 0 ) {
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
    
    $arrLlaves["usuario"] = $intUsuario;
    base_dbDelete("usuario_pantalla",$arrLlaves);
    base_dbDelete("usuario_rol",$arrLlaves);
    
    reset($_POST);
    while( $arrP = each($_POST) ) {

        $arrExplode = explode("_",$arrP["key"]);
        if( $arrExplode[0] == "chkPantalla" ) {
            $strQuery = "INSERT INTO usuario_pantalla(usuario,pantalla,add_usuario,add_fecha) VALUES ({$intUsuario},'{$arrP["value"]}',{$_SESSION['usuario']},now())";
            db_consulta($strQuery);
        }
        elseif( $arrExplode[0] == "chkRol" ) {
            $arrDatos["usuario"] = $intUsuario;
            $arrDatos["rol"] = $arrP["value"];
            $arrDatos["add_usuario"] = $_SESSION['usuario'];
            $arrDatos["add_fecha"] = "now()";
            base_dbInsert("usuario_rol",$arrDatos);
        }

    }
    
    if( $intUsuarioTmp == 0 ) {
        header("location:{$strAction}?info=true");
    }
}
drawHeader("LA-Admin - Usuarios");
    ?>
    <form name="<?php print  $strForm; ?>" id="<?php print $strForm; ?>" method="post" action="<?php print $strAction; ?>" class="form-horizontal">
        <?php 
        $intUsuario = isset($_GET['usuario']) ? intval($_GET['usuario']) : -1;
        if( $intUsuario == -1 ) {
            ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="index.php">Inicio</a></li>
                            <li><a href="<?php print $strAction; ?>" class="active">Usuarios</a></li>
                        </ol>
                    </div>
                    <?php
                    if( $boolAlertaEliminar ) {
                        ?>
                        <div class="col-lg-4 col-lg-offset-4">
                            <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span class="glyphicon glyphicon-warning-sign"></span>&nbsp;<strong>Aviso:</strong>&nbsp;Usuario eliminado.
                            </div>
                        </div>
                        <?php
                    }
                    if( $boolAlertaCreada ) {
                        ?>
                        <div class="col-lg-5 col-lg-offset-3">
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span class="glyphicon glyphicon-info-sign"></span>&nbsp;<strong>información:</strong>&nbsp;Usuario creado exitosamente.
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <button type="button" class="btn btn-primary btn-sm" onclick="fntNuevoUsuario();">
                                  <span class="glyphicon glyphicon-plus"></span>&nbsp;Nuevo usuario
                                </button>
                                <script>
                                    function fntNuevoUsuario() {
                                        document.location = "<?php print $strAction; ?>?usuario=0";
                                    }
                                    function fntEditarUsuario(intNoticiaCategoria) {
                                        document.location = "<?php print $strAction; ?>?usuario="+intNoticiaCategoria;
                                    }
                                </script>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="tblPaginas">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ID</th>
                                                <th width="30%">&nbsp;&nbsp;Nombre&nbsp;&nbsp;</th>
                                                <th width="21%">&nbsp;&nbsp;Cuenta&nbsp;&nbsp;</th>
                                                <th width="20%">&nbsp;&nbsp;Correo electrónico&nbsp;&nbsp;</th>
                                                <th width="8%">&nbsp;&nbsp;Tipo&nbsp;&nbsp;</th>
                                                <th width="7%" class="text-center">Activo</th>
                                                <th width="8%" class="text-center">&nbsp;Acción&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $strWhere = ($_SESSION['tipo_usuario'] == 'administrador') ? "" : " AND tipo_usuario IN('normal') ";
                                            $strQuery = "SELECT usuario,
                                                                nombre,
                                                                cuenta,
                                                                tipo_usuario,
                                                                activo,
                                                                email
                                                         FROM   usuario
                                                         WHERE  eliminado = 'N'
                                                         {$strWhere}    
                                                         ORDER  BY nombre";
                                            $qTMP = db_consulta($strQuery);
                                            while( $rTMP = db_fetch_assoc($qTMP) ) {
                                                ?>
                                                <tr>
                                                    <td class="text-center"><a href="<?php print $strAction; ?>?usuario=<?php print $rTMP["usuario"]; ?>"><?php print $rTMP["usuario"]; ?></a></td>
                                                    <td><?php print $rTMP["nombre"]; ?></td>
                                                    <td><?php print $rTMP["cuenta"]; ?></td>
                                                    <td><?php print $rTMP["email"]; ?></td>
                                                    <td><?php print ucfirst($rTMP["tipo_usuario"]); ?></td>
                                                    <td class="text-center"><?php print $rTMP["activo"] == 'Y' ? 'Si' : 'No'; ?></td>
                                                    <td class=" text-center">
                                                        <button type="button" class="btn btn-info btn-xs" onclick="fntEditarUsuario(<?php print $rTMP["usuario"]; ?>);" data-toggle="tooltip" data-placement="bottom" title="Editar usuario">
                                                          <span class="glyphicon glyphicon-pencil"></span>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-xs" onclick="fntEliminarNoticiaCategoria(<?php print $rTMP["usuario"]; ?>, '<?php print $rTMP["nombre"]; ?>', true);" data-toggle="tooltip" data-placement="bottom" title="Eliminar usuario">
                                                          <span class="glyphicon glyphicon-trash"></span>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            db_free_result($qTMP);
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
            </div>
            <!-- /#page-wrapper -->
            <script>
                $(document).ready(function() {
                    $('#tblPaginas').dataTable({
                        "language": {
                            "emptyTable":     "No hay datos disponibles en la tabla",
                            "info":           "Mostrando del _START_ al _END_ de _TOTAL_ filas",
                            "infoEmpty":      "Mostrando 0 de 0 filas",
                            "infoFiltered":   "(filtradas de _MAX_ filas totales)",
                            "infoPostFix":    "",
                            "thousands":      ",",
                            "lengthMenu":     "Mostrar _MENU_ filas",
                            "loadingRecords": "Loading...",
                            "processing":     "Processing...",
                            "search":         "Buscar: ",
                            "zeroRecords":    "No hay registros coincidentes encontrados",
                            "paginate": {
                                "first":      "Primero",
                                "last":       "Ultimo",
                                "next":       "Siguiente",
                                "previous":   "Anterior"
                            },
                            "aria": {
                                "sortAscending":  ": activate to sort column ascending",
                                "sortDescending": ": activate to sort column descending"
                            }
                        }
                    });
                    $('button').tooltip();
                });
            </script>
            <?php
        }
        else {
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
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="index.php">Inicio</a></li>
                            <li><a href="<?php print $strAction; ?>">Usuarios</a></li>
                            <li class="active"><?php print isset($arrData['titulo']) ? $arrData['titulo'] : 'Nuevo usuario'; ?></li>
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
                                <button type="button" class="btn btn-primary btn-sm" onclick="fntRegresar();">
                                    <span class="glyphicon glyphicon-th-list"></span>&nbsp;Ir al listado
                                </button>
                            </div>
                            <div class="panel-body">
                                <input type="hidden" name="hdnUsuario" value="<?php print $intUsuario; ?>" readonly="readonly">
                                <div class="form-group has-feedback" id="txtNombreGrupo">
                                    <label for="txtNombre" class="col-lg-3 col-lg-offset-1 control-label">Nombre *</label>
                                    <div class="col-lg-5">
                                        <input type="text" name="txtNombre" id="txtNombre" value="<?php print isset($arrData['nombre']) ? $arrData['nombre'] : ''; ?>" class="form-control input-sm" autofocus="autofocus" maxlength="75" required="required" aria-describedby="txtNombreEstado">
                                        <span id="txtNombreIcono" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span id="txtNombreMensaje" class="sr-only">(Este campo es requerido)</span>
                                    </div>
                                </div>
                                <div class="form-group has-feedback" id="txtCuentaGrupo">
                                    <label for="txtCuenta" class="col-lg-3 col-lg-offset-1 control-label">Cuenta *</label>
                                    <div class="col-lg-5">
                                        <input type="text" name="txtCuenta" id="txtCuenta" value="<?php print isset($arrData['cuenta']) ? $arrData['cuenta'] : ''; ?>" class="form-control input-sm" maxlength="75" required="required">
                                        <span id="txtCuentaIcono" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span id="txtCuentaMensaje" class="sr-only">(Este campo es requerido)</span>
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
                                    <div class="col-lg-5">
                                        <select name="sltTipoUsuario" id="sltTipoUsuario" class="form-control input-sm">
                                            <?php
                                            if( $_SESSION['tipo_usuario'] == 'administrador' ) {
                                                ?>
                                                <option value="administrador" <?php print ( isset($arrData['tipo_usuario']) && $arrData['tipo_usuario'] == 'administrador' ) ? "selected='selected'" : ''; ?>>Administrador</option>
                                                <?php
                                                }
                                            ?>
                                            <option value="normal" <?php print ( isset($arrData['tipo_usuario']) && $arrData['tipo_usuario'] == 'normal' ) ? "selected='selected'" : ''; ?>>Normal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="chkActivo" class="col-lg-3 col-lg-offset-1 control-label">Activo</label>
                                    <div class="col-lg-5 form-control-static">
                                        <input type="checkbox" name="chkActivo" id="chkActivo" value="1" <?php print isset($arrData['activo']) && $arrData['activo'] == 'Y' ? 'checked="checked"' : ''; ?>>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8 col-lg-offset-2">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <strong>Accesos</strong>
                                            </div>
                                            <div class="panel-body">
                                                <?php
                                                $arrUsuarioPantalla = array();
                                                $strQuery = "SELECT usuario_pantalla.usuario,
                                                                    usuario_pantalla.pantalla
                                                             FROM   usuario_pantalla
                                                             WHERE  usuario_pantalla.usuario = {$intUsuario}";
                                                $qTMP = db_consulta($strQuery);
                                                while( $rTMP = db_fetch_assoc($qTMP) ) {
                                                    $arrUsuarioPantalla[$rTMP["pantalla"]] = $rTMP["pantalla"];
                                                }
                                                db_free_result($qTMP);
                                                
                                                $arrData = array();
                                                $strQuery = "SELECT modulo.modulo,
                                                                    modulo.nombre AS nombreModulo,
                                                                    pantalla.pantalla,
                                                                    pantalla.nombre AS nombrePantalla
                                                             FROM   modulo
                                                                    INNER JOIN pantalla
                                                                        ON  pantalla.modulo = modulo.modulo
                                                             WHERE  modulo.activo = 'Y'
                                                             AND    pantalla.activo = 'Y'
                                                             ORDER  BY modulo.orden, modulo.nombre, pantalla.orden, pantalla.nombre";
                                                $qTMP = db_consulta($strQuery);
                                                while( $rTMP = db_fetch_assoc($qTMP) ) {
                                                    $arrData[$rTMP["modulo"]]["nombreModulo"] = $rTMP["nombreModulo"];
                                                    $arrData[$rTMP["modulo"]]["pantallas"][$rTMP["pantalla"]]["nombrePantalla"] = $rTMP["nombrePantalla"];
                                                }
                                                db_free_result($qTMP);
                                                reset($arrData);                                            
                                                while( $arrM = each($arrData) ) {
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-sm-12"><strong><?php print $arrM["value"]["nombreModulo"]; ?></strong></div>
                                                    </div>
                                                    <?php
                                                    reset($arrM["value"]["pantallas"]);
                                                    while( $arrP = each($arrM["value"]["pantallas"]) ) {
                                                        $strChecked = isset($arrUsuarioPantalla[$arrP["key"]]) ? 'checked="checked"' : '';
                                                        ?>
                                                        <div class="row">
                                                            <div class="col-sm-4 text-left">&nbsp;--&nbsp;<input type="checkbox" <?php print $strChecked; ?> name="chkPantalla_<?php print $arrP["key"]; ?>" value="<?php print $arrP["key"]; ?>">&nbsp;<?php print $arrP["value"]["nombrePantalla"]; ?></div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <strong>Roles</strong>
                                            </div>
                                            <div class="panel-body">
                                                <?php
                                                $arrUsuarioRol = array();
                                                $strQuery = "SELECT usuario_rol.usuario,
                                                                    usuario_rol.rol
                                                             FROM   usuario_rol
                                                             WHERE  usuario_rol.usuario = {$intUsuario}";
                                                $qTMP = db_consulta($strQuery);
                                                while( $rTMP = db_fetch_assoc($qTMP) ) {
                                                    $arrUsuarioRol[$rTMP["rol"]] = $rTMP["rol"];
                                                }
                                                db_free_result($qTMP);
                                                
                                                $arrData = array();
                                                $strQuery = "SELECT rol.rol,
                                                                    rol.nombre AS nombreRol
                                                             FROM   rol
                                                             ORDER  BY rol.nombre";
                                                $qTMP = db_consulta($strQuery);
                                                while( $rTMP = db_fetch_assoc($qTMP) ) {
                                                    $arrData[$rTMP["rol"]]["nombreRol"] = $rTMP["nombreRol"];
                                                }
                                                db_free_result($qTMP);
                                                reset($arrData);
                                                while( $arrR = each($arrData) ) {
                                                    $strChecked = isset($arrUsuarioRol[$arrR["key"]]) ? 'checked="checked"' : '';
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-sm-4 text-left">&nbsp;--&nbsp;<input type="checkbox" <?php print $strChecked; ?> name="chkRol_<?php print $arrR["key"]; ?>" value="<?php print $arrR["key"]; ?>">&nbsp;<?php print $arrR["value"]["nombreRol"]; ?></div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
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

                    function fntRegresar() {
                        document.location = "<?php print $strAction; ?>";
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
            <?php
        }
        ?>
        <input type="hidden" name="hdnEliminar" id="hdnEliminar" value="0"  readonly="readonly">
    </form>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Eliminar usuario</h4>
                </div>
                <div class="modal-body" id="divEliminarModalBody">
                    ¿Está seguro?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="fntEliminarNoticiaCategoria(0,'', false)">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function fntEliminarNoticiaCategoria(intNoticiaCategoria, strTexto, boolConfirmar) {
            
            if( intNoticiaCategoria > 0 ) {
                $("#hdnEliminar").val(intNoticiaCategoria);
            }
            if( strTexto.length > 0 ) {
                $("#divEliminarModalBody").html('¿Está seguro de eliminar el usuario <i>"'+strTexto+'"</i>?');
            }
            if( boolConfirmar ) {
                $('#myModal').modal();
            }
            else {
                $('#myModal').modal('hide');
                $("#<?php print $strForm; ?>").submit();
            }
            
        }
    </script>
    <?php
drawFooter();
?>