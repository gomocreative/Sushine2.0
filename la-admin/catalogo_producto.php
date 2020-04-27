<?php
require('main.php');
if( !boolThereLogin() )
    header('location:error.php');

if( isset($_POST['ajaxEliminar']) ) {
    
    $intId = isset($_POST['ajaxEliminar']) ? $_POST['ajaxEliminar'] : 0;
    $strQuery = "SELECT catalogo,
                        imagen
                 FROM   catalogo 
                 WHERE  catalogo = {$intId}";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        if( file_exists($rTMP['imagen']) ) {
             unlink($rTMP['imagen']);
        }
    }
    db_free_result($qTMP);
    $strQuery = "UPDATE catalogo SET imagen = NULL WHERE catalogo = {$intId}";
    db_consulta($strQuery);
    
    exit();
    
}    
elseif( isset($_POST['ajaxGetSubCategoria']) ) {

    header("Content-Type: text/html; charset=ISO-8859-1");
    $intCategoria = isset($_POST['sltCatcatalogoCategoria']) ? intval($_POST['sltCatcatalogoCategoria']) : 0;
    ?>
    <select name="sltCatcatalogoSubCategoria" class="form-control input-sm">
        <option value="0">Seleccione una opción</option>
        <?php
        $strQuery = "SELECT catalogo_categoria,
                            nombre
                     FROM   catalogo_categoria
                     WHERE  catalogo_categoria_padre = {$intCategoria}
                     ORDER BY nombre";
        $qTMP = db_consulta($strQuery);
        while( $rTMP = db_fetch_assoc($qTMP) ) {
            ?>
            <option value="<?php print $rTMP['catalogo_categoria']; ?>" <?php print ( isset($arrData['catalogo_categoria']) && $arrData['catalogo_categoria'] == $rTMP['catalogo_categoria'] ) ? 'selected="selected"' : '' ?> ><?php print $rTMP['nombre']; ?></option>
            <?php
        }
        db_free_result($qTMP);
        ?>
    </select>
    <?php

    exit();

}
elseif( isset($_POST['ajaxEliminarDetalle1']) ) {
    
    $intId = isset($_POST['ajaxEliminarDetalle1']) ? intval($_POST['ajaxEliminarDetalle1']) : 0;
    $strQuery = "SELECT imagen
                 FROM   catalogo_imagen 
                 WHERE  catalogo_imagen = {$intId}";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        if( file_exists($rTMP['imagen']) ) {
             unlink($rTMP['imagen']);
        }
    }
    db_free_result($qTMP);
    $strQuery = "DELETE FROM catalogo_imagen WHERE catalogo_imagen = {$intId}";
    db_consulta($strQuery);
    
    exit();
    
}
elseif( isset($_POST['ajaxEliminarDetalle2']) ) {
    
    $intId = isset($_POST['ajaxEliminarDetalle2']) ? intval($_POST['ajaxEliminarDetalle2']) : 0;
    $strQuery = "DELETE FROM catalogo_c WHERE catalogo_c = {$intId}";
    db_consulta($strQuery);
    
    exit();
    
}
$strAction = basename(__FILE__);
$boolAlertaCrear = isset($_GET['info']);
$boolAlertaModificada = false;
$boolAlertaEliminar = false;

if( isset($_POST['hdnEliminar']) && intval($_POST['hdnEliminar']) > 0 ) {
    $intId = isset($_POST['hdnEliminar']) ? $_POST['hdnEliminar'] : 0;
    $strQuery = "SELECT catalogo,
                        imagen
                 FROM   catalogo 
                 WHERE  catalogo = {$intId}";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        if( file_exists($rTMP['imagen']) ) {
             unlink($rTMP['imagen']);
        }
    }
    db_free_result($qTMP);
    $strQuery = "DELETE FROM catalogo WHERE catalogo = {$intId}";
    db_consulta($strQuery);
    $boolAlertaEliminar = true;
}
elseif( isset($_POST['hdnCrear']) ) {
    $intId = intval($_POST['hdnCrear']);
    $intIdTmp = $intId;
    $strImagenActual = isset($_POST['hdnImagenActual']) ? $_POST['hdnImagenActual'] : '';
    $strCodigo = isset($_POST['txtCodigo']) ? db_real_escape_string($_POST['txtCodigo']) : '';
    $strNombre = isset($_POST['txtNombre']) ? db_real_escape_string($_POST['txtNombre']) : '';
    $strNombreEn = isset($_POST['txtNombreEn']) ? db_real_escape_string($_POST['txtNombreEn']) : '';
    $sinPrecio = isset($_POST['txtPrecio']) ? floatval($_POST['txtPrecio']) : 0;
    $sinPrecioOferta = isset($_POST['txtPrecioOferta']) ? floatval($_POST['txtPrecioOferta']) : 0;
    $intEnOferta = isset($_POST['chkEnOferta']) ? 'Y' : 'N';
    $intCantidad = isset($_POST['txtCantidad']) ? intval($_POST['txtCantidad']) : 0;
    $strDescripcion = isset($_POST['txtDescripcion']) ? db_real_escape_string($_POST['txtDescripcion']) : '';
    $strDescripcionEn = isset($_POST['txtDescripcionEn']) ? db_real_escape_string($_POST['txtDescripcionEn']) : '';
    $strEspecificacion = isset($_POST['txtEspecificacion']) ? db_real_escape_string($_POST['txtEspecificacion']) : '';
    $intCatcatalogoCategoria = isset($_POST['sltCatcatalogoCategoria']) ? intval($_POST['sltCatcatalogoCategoria']) : 0;
    $intCatcatalogoSubCategoria = isset($_POST['sltCatcatalogoSubCategoria']) ? intval($_POST['sltCatcatalogoSubCategoria']) : 0;
    $intCatcatalogoMarca = isset($_POST['sltCatcatalogoMarca']) ? intval($_POST['sltCatcatalogoMarca']) : 0;
    $intActivo = isset($_POST['chkActivo']) ? 'Y' : 'N';
    $intDestacar = isset($_POST['chkDestacar']) ? 'Y' : 'N';
    $strNuevo = isset($_POST['chkNuevo']) ? 'Y' : 'N';
    $strRecomendar = isset($_POST['chkRecomendar']) ? 'Y' : 'N';
    $strPath = 'imagenes/';

    if( $intId == 0 ) {
        if( !empty($strNombre) ) {
            $strImagen = 'NULL';
            if( is_uploaded_file($_FILES['fileImagen']['tmp_name']) && $_FILES["fileImagen"]["error"] == UPLOAD_ERR_OK ) {
                $strImagen = uniqid('',  true);
                $arrExplode = explode('.', $_FILES['fileImagen']['name']);
                $arrExplode = array_reverse($arrExplode);
                $strImagen = $strPath.$strImagen.'.'.$arrExplode[0];
                move_uploaded_file($_FILES['fileImagen']['tmp_name'], $strImagen);
                $strImagen = "'".$strImagen."'";
            }
            $strQuery ="INSERT INTO catalogo(codigo, nombre, nombre_en, precio, precio_oferta, en_oferta, cantidad, descripcion, descripcion_en, especificacion, imagen, catalogo_categoria, catalogo_sub_categoria, catalogo_marca, activo, destacar, nuevo, recomendar, add_usuario, add_fecha, mod_usuario, mod_fecha) 
                        VALUES ('{$strCodigo}', '{$strNombre}', '{$strNombreEn}', {$sinPrecio}, {$sinPrecioOferta}, '{$intEnOferta}', {$intCantidad}, '{$strDescripcion}', '{$strDescripcionEn}', '{$strEspecificacion}', {$strImagen}, {$intCatcatalogoCategoria}, {$intCatcatalogoSubCategoria}, {$intCatcatalogoMarca}, '{$intActivo}', '{$intDestacar}', '{$strNuevo}', '{$strRecomendar}', 1, now(), 1, now())";
            db_consulta($strQuery);
            $intId = db_insert_id();
        }
    }
    elseif( $intId > 0 ) {
        if( !empty($strNombre) ) {
            
            $strImagen = '';
            if( is_uploaded_file($_FILES['fileImagen']['tmp_name']) && $_FILES["fileImagen"]["error"] == UPLOAD_ERR_OK ) {
                $strImagen = uniqid('',  true);
                $arrExplode = explode('.', $_FILES['fileImagen']['name']);
                $arrExplode = array_reverse($arrExplode);
                $strImagen = $strPath.$strImagen.'.'.$arrExplode[0];
                move_uploaded_file($_FILES['fileImagen']['tmp_name'], $strImagen);
                if( file_exists($strImagenActual) ) {
                     unlink($strImagenActual);
                }
                $strImagen = "imagen = '".$strImagen."',";
            }
            
            $strQuery ="UPDATE  catalogo 
                        SET     codigo = '{$strCodigo}', 
                                nombre = '{$strNombre}',
                                nombre_en = '{$strNombreEn}',
                                precio = {$sinPrecio},
                                precio_oferta = {$sinPrecioOferta},
                                en_oferta = '{$intEnOferta}',
                                cantidad = {$intCantidad},
                                descripcion = '{$strDescripcion}',
                                descripcion_en = '{$strDescripcionEn}',
                                especificacion = '{$strEspecificacion}',
                                {$strImagen}
                                catalogo_categoria = {$intCatcatalogoCategoria}, 
                                catalogo_sub_categoria = {$intCatcatalogoSubCategoria},
                                catalogo_marca = {$intCatcatalogoMarca},
                                activo = '{$intActivo}',
                                destacar = '{$intDestacar}',
                                nuevo = '{$strNuevo}',
                                recomendar = '{$strRecomendar}',
                                mod_usuario = 1, 
                                mod_fecha = now()
                        WHERE   catalogo = {$intId}";
            db_consulta($strQuery);
            $boolAlertaModificada = true;
        }
    }
    
    reset($_POST);
    while( $arrPost = each($_POST) ) {
        
        $arrExplode1 = explode('_', $arrPost['key']);
        if( $arrExplode1[0] == 'hdnImagen' ) {
            
            $intIdImagen = isset($_POST["hdnImagen_{$arrExplode1[1]}"]) ? $_POST["hdnImagen_{$arrExplode1[1]}"] : 0;
            $strImagenActual = isset($_POST["hdnImagenActual_{$arrExplode1[1]}"]) ? $_POST["hdnImagenActual_{$arrExplode1[1]}"] : '';
            if( $intIdImagen == 0 ) {
                $strImagen = 'NULL';
                if( is_uploaded_file($_FILES["fileImagen_{$arrExplode1[1]}"]['tmp_name']) && $_FILES["fileImagen_{$arrExplode1[1]}"]["error"] == UPLOAD_ERR_OK ) {
                    $strImagen = uniqid('',  true);
                    $arrExplode = explode('.', $_FILES["fileImagen_{$arrExplode1[1]}"]['name']);
                    $arrExplode = array_reverse($arrExplode);
                    $strImagen = $strPath.$strImagen.'.'.$arrExplode[0];
                    move_uploaded_file($_FILES["fileImagen_{$arrExplode1[1]}"]['tmp_name'], $strImagen);
                    $strImagen = "'".$strImagen."'";
                }
                $strQuery ="INSERT INTO catalogo_imagen(catalogo, imagen) 
                            VALUES ({$intId}, {$strImagen})";
                db_consulta($strQuery);
                
            }
            elseif( $intIdImagen > 0 ) {
                $strImagen = 'NULL';
                if( is_uploaded_file($_FILES["fileImagen_{$arrExplode1[1]}"]['tmp_name']) && $_FILES["fileImagen_{$arrExplode1[1]}"]["error"] == UPLOAD_ERR_OK ) {
                    $strImagen = uniqid('',  true);
                    $arrExplode = explode('.', $_FILES["fileImagen_{$arrExplode1[1]}"]['name']);
                    $arrExplode = array_reverse($arrExplode);
                    $strImagen = $strPath.$strImagen.'.'.$arrExplode[0];
                    move_uploaded_file($_FILES["fileImagen_{$arrExplode1[1]}"]['tmp_name'], $strImagen);
                    if( file_exists($strImagenActual) ) {
                         unlink($strImagenActual);
                    }
                    $strImagen = "'".$strImagen."'";
                    $strQuery ="UPDATE  catalogo_imagen 
                            SET     imagen = {$strImagen}
                            WHERE   catalogo = {$intIdImagen}";
                    db_consulta($strQuery);
                }
            }
        }
        if( $arrExplode1[0] == 'hdnDetalle2Id' ) {
            $intDetalle2Id = isset($_POST["hdnDetalle2Id_{$arrExplode1[1]}"]) ? intval($_POST["hdnDetalle2Id_{$arrExplode1[1]}"]) : 0;
            $intCatcatalogoCaracteristica = isset($_POST["sltDetalle2Caracteristica_{$arrExplode1[1]}"]) ? intval($_POST["sltDetalle2Caracteristica_{$arrExplode1[1]}"]) : 0;
            $strValor = isset($_POST["txtDetalle2Valor_{$arrExplode1[1]}"]) ? db_real_escape_string($_POST["txtDetalle2Valor_{$arrExplode1[1]}"]) : 0;
            if( $intDetalle2Id == 0 ) {
                $strQuery ="INSERT INTO catalogo_c(catalogo, catalogo_caracteristica, valor ) 
                            VALUES ({$intId}, {$intCatcatalogoCaracteristica}, '{$strValor}')";
                db_consulta($strQuery);
            }
            elseif( $intDetalle2Id > 0 ) {
                $strQuery ="UPDATE  catalogo_c 
                            SET     catalogo_caracteristica = {$intCatcatalogoCaracteristica},
                                    valor = '{$strValor}'
                            WHERE   catalogo_c = {$intDetalle2Id}";
                db_consulta($strQuery);
            }
        }

    }

    if( $intIdTmp == 0 ) {
        header("location:{$strAction}?info=true");
    }
}
drawHeader("LA-Admin - Producto");
?>
        <form name="frmGeneral" id="frmGeneral" method="post" enctype="multipart/form-data">
            <?php 
            $intId = isset($_GET['id']) ? intval($_GET['id']) : -1;
            if( $intId == -1 ) {
                ?>
                <div id="page-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <ol class="breadcrumb">
                                <li><a href="index.php">Inicio</a></li>
                                <li><a href="#">Catálogo</a></li>
                                <li><a href="<?php print $strAction; ?>" class="active">Producto</a></li>
                            </ol>
                            <h1 class="page-header">Productos</h1>
                        </div>
                        <?php
                        if( $boolAlertaCrear ) {
                            ?>
                            <div class="col-lg-4 col-lg-offset-4">
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <span class="glyphicon glyphicon-info-sign"></span>&nbsp;<strong>información:</strong>&nbsp;Producto creado exitosamente.
                                </div>
                            </div>
                            <?php
                        }
                        if( $boolAlertaEliminar ) {
                            ?>
                            <div class="col-lg-4 col-lg-offset-4">
                                <div class="alert alert-warning">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <span class="glyphicon glyphicon-warning-sign"></span>&nbsp;<strong>Aviso:</strong>&nbsp;Producto eliminado.
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="fntCrear();">
                                      <span class="glyphicon glyphicon-plus"></span>&nbsp;Nuevo producto
                                    </button>
                                    <script>
                                        function fntCrear() {
                                            document.location = "<?php print $strAction; ?>?id=0";
                                        }
                                        function fntEditar(intId) {
                                            document.location = "<?php print $strAction; ?>?id="+intId;
                                        }
                                    </script>
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="tblPaginas">
                                            <thead>
                                                <tr>
                                                    <th width="5%">ID</th>
                                                    <th width="15%">Imagen</th>
                                                    <!--th width="15%">Codigo</th-->
                                                    <th width="25%">Nombre</th>
                                                    <th width="25%">Nombre (Inglés)</th>
                                                    <th width="15%">Activo</th>
                                                    <th width="15%">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $strQuery = 'SELECT catalogo,
                                                                    codigo,
                                                                    nombre,
                                                                    nombre_en,
                                                                    activo,
                                                                    imagen
                                                             FROM   catalogo 
                                                             ORDER BY nombre';
                                                $qTMP = db_consulta($strQuery);
                                                while( $rTMP = db_fetch_assoc($qTMP) ) {
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td class="text-center"><a href="<?php print $strAction; ?>?id=<?php print $rTMP["catalogo"]; ?>"><?php print $rTMP["catalogo"]; ?></a></td>
                                                        <td class="text-center">
                                                            <?php
                                                            if( !empty($rTMP['imagen']) ) {
                                                                ?>
                                                                <img src="<?php print $rTMP['imagen']; ?>" style="width: 50px; height: 50px;" alt="">
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <!-td><?php print $rTMP["codigo"]; ?></td-->
                                                        <td><?php print $rTMP["nombre"]; ?></td>
                                                        <td><?php print $rTMP["nombre_en"]; ?></td>
                                                        <td class="text-center"><?php print $rTMP["activo"] == 'Y' ? 'Si' : 'No'; ?></td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-info btn-xs" onclick="fntEditar(<?php print $rTMP["catalogo"]; ?>);" data-toggle="tooltip" data-placement="bottom" title="Editar">
                                                                <span class="glyphicon glyphicon-pencil"></span>
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-xs" onclick="fntEliminar(<?php print $rTMP["catalogo"]; ?>, '<?php print $rTMP["nombre"]; ?>', true);" data-toggle="tooltip" data-placement="bottom" title="Eliminar">
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
                $strQuery = "SELECT catalogo,
                                    codigo,
                                    nombre,
                                    nombre_en,
                                    precio,
                                    precio_oferta,
                                    en_oferta, 
                                    cantidad,
                                    descripcion,
                                    descripcion_en,
                                    especificacion,
                                    imagen,
                                    catalogo_categoria,
                                    catalogo_sub_categoria,
                                    catalogo_marca,
                                    activo,
                                    destacar,
                                    nuevo,
                                    recomendar
                             FROM   catalogo
                             WHERE  catalogo = {$intId}";
                             
                $qTMP = db_consulta($strQuery);
                while( $rTMP = db_fetch_assoc($qTMP) ) {
                    $arrData = $rTMP;
                }
                db_free_result($qTMP);
                $intIdImagen = 1;
                ?>
                <div id="page-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <ol class="breadcrumb">
                                <li><a href="index.php">Inicio</a></li>
                                <li><a href="#">Catálogo</a></li>
                                <li><a href="<?php print $strAction; ?>">Producto</a></li>
                                <li class="active"><?php print isset($arrData['nombre']) ? $arrData['nombre'] : 'Nuevo producto'; ?></li>
                            </ol>
                            <h1 class="page-header">Producto</h1>
                        </div>
                        <?php
                        if( $boolAlertaModificada ) {
                            ?>
                            <div class="col-lg-5 col-lg-offset-4">
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <span class="glyphicon glyphicon-info-sign"></span>&nbsp;<strong>información:</strong>&nbsp;Producto actualizado exitosamente.
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <button type="button" class="btn btn-success btn-sm" onclick="fntGuardar();">
                                        <span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Guardar
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="fntRegresar();">
                                        <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Regresar
                                    </button>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <input type="hidden" name="hdnCrear" value="<?php print $intId; ?>" readonly="readonly">
                                        <input type="hidden" name="hdnImagenActual" value="<?php print isset($arrData['imagen']) ? $arrData['imagen'] : ''; ?>" readonly="readonly">
                                        <div class="col-lg-8 col-lg-offset-2">
                                            <table width="100%" class="table">
                                                <tbody>
                                                    <tr> 
                                                        <td width="20%" class="text-right">Nombre</td>
                                                        <td width="50%"><input type="text" name="txtNombre" id="txtNombre" value="<?php print isset($arrData['nombre']) ? $arrData['nombre'] : ''; ?>" autofocus="autofocus" maxlength="255" required="required" class="form-control input-sm"></td>
                                                        <td width="30%">&nbsp;</td>
                                                    </tr>
                                                    <tr> 
                                                        <td class="text-right">Nombre (Inglés)</td>
                                                        <td><input type="text" name="txtNombreEn" id="txtNombreEn" value="<?php print isset($arrData['nombre_en']) ? $arrData['nombre_en'] : ''; ?>" autofocus="autofocus" maxlength="255" required="required" class="form-control input-sm"></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr style="display: none;"> 
                                                        <td class="text-right">Código</td>
                                                        <td><input type="text" name="txtCodigo" id="txtCodigo" value="<?php print isset($arrData['codigo']) ? $arrData['codigo'] : ''; ?>" maxlength="255" required="required" class="form-control input-sm"></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr style="display: none;"> 
                                                        <td class="text-right">Precio</td>
                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <span class="input-group-addon">Q</span>
                                                                <input type="text" name="txtPrecio" id="txtPrecio" value="<?php print isset($arrData['precio']) ? $arrData['precio'] : ''; ?>" class="form-control input-sm">
                                                            </div>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr style="display: none;"> 
                                                        <td class="text-right">En oferta</td>
                                                        <td><input type="checkbox" name="chkEnOferta" id="chkEnOferta" value="1" <?php print isset($arrData['en_oferta']) && $arrData['en_oferta'] == "Y"  ? 'checked="checked"' : ''; ?>></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr style="display: none;"> 
                                                        <td class="text-right">Precio oferta</td>
                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <span class="input-group-addon">Q</span>
                                                                <input type="text" name="txtPrecioOferta" id="txtPrecioOferta" value="<?php print isset($arrData['precio_oferta']) ? $arrData['precio_oferta'] : ''; ?>" class="form-control input-sm">
                                                            </div>
                                                        </td>                                                            
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr style="display: none;"> 
                                                        <td class="text-right">Cantidad</td>
                                                        <td><input type="text" name="txtCantidad" id="txtCantidad" value="<?php print isset($arrData['cantidad']) ? $arrData['cantidad'] : ''; ?>" class="form-control input-sm"></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr> 
                                                        <td class="text-right">Descripción</td>
                                                        <td>
                                                            <textarea name="txtDescripcion" id="txtDescripcion" class="form-control input-sm"><?php print isset($arrData['descripcion']) ? $arrData['descripcion'] : ''; ?></textarea>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr> 
                                                        <td class="text-right">Descripción (Inglés)</td>
                                                        <td>
                                                            <textarea name="txtDescripcionEn" id="txtDescripcionEn" class="form-control input-sm"><?php print isset($arrData['descripcion_en']) ? $arrData['descripcion_en'] : ''; ?></textarea>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr style="display: none;"> 
                                                        <td class="text-right">Especificaciones</td>
                                                        <td>
                                                            <textarea name="txtEspecificacion" id="txtEspecificacion" class="form-control input-sm"><?php print isset($arrData['especificacion']) ? $arrData['especificacion'] : ''; ?></textarea>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr> 
                                                        <td class="text-right">Imagen</td>
                                                        <td>
                                                            <div class="form-group has-feedback">
                                                                <label class="control-label" for="inputSuccess2">&nbsp;</label>
                                                                <input type="text" name="txtImagen" id="txtImagen" value="" class="form-control input-sm">
                                                                <span id="btnImagen" class="glyphicon glyphicon-picture form-control-feedback" style="cursor: pointer;"></span>
                                                            </div>
                                                            <input type="file" name="fileImagen" id="fileImagen" value="" accept="image/*" class="hide">
                                                        </td>
                                                        <td id="tdImagen">
                                                            <?php
                                                            if( !empty($arrData['imagen']) ) {
                                                                ?>
                                                                <img src="<?php print $arrData['imagen']; ?>" style="width: 100px; height: 100px;" alt="">
                                                                <button id="btnEliminar" type="button" class="btn btn-default btn-xs" onclick="fntEliminarImagen(<?php print $intId; ?>);" title="Eliminar imagen">
                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                </button>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr style="display: none;"> 
                                                        <td class="text-right">Marca</td>
                                                        <td>
                                                            <select name="sltCatcatalogoMarca" id="sltCatcatalogoMarca" class="form-control input-sm">
                                                                <option value="0">Seleccione una opción</option>
                                                                <?php
                                                                $strQuery = "SELECT catalogo_marca,
                                                                                    nombre
                                                                             FROM   catalogo_marca
                                                                             ORDER BY nombre";
                                                                $qTMP = db_consulta($strQuery);
                                                                while( $rTMP = db_fetch_assoc($qTMP) ) {
                                                                    ?>
                                                                    <option value="<?php print $rTMP['catalogo_marca']; ?>" <?php print ( isset($arrData['catalogo_marca']) && $arrData['catalogo_marca'] == $rTMP['catalogo_marca'] ) ? 'selected="selected"' : '' ?> ><?php print $rTMP['nombre']; ?></option>
                                                                    <?php
                                                                }
                                                                db_free_result($qTMP);
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr> 
                                                        <td class="text-right">Categoría</td>
                                                        <td>
                                                            <select name="sltCatcatalogoCategoria" id="sltCatcatalogoCategoria" class="form-control input-sm">
                                                                <option value="0">Seleccione una opción</option>
                                                                <?php
                                                                $strQuery = "SELECT catalogo_categoria,
                                                                                    nombre
                                                                             FROM   catalogo_categoria
                                                                             WHERE  catalogo_categoria_padre IS NULL
                                                                             ORDER BY nombre";
                                                                $qTMP = db_consulta($strQuery);
                                                                while( $rTMP = db_fetch_assoc($qTMP) ) {
                                                                    ?>
                                                                    <option value="<?php print $rTMP['catalogo_categoria']; ?>" <?php print ( isset($arrData['catalogo_categoria']) && $arrData['catalogo_categoria'] == $rTMP['catalogo_categoria'] ) ? 'selected="selected"' : '' ?> ><?php print $rTMP['nombre']; ?></option>
                                                                    <?php
                                                                }
                                                                db_free_result($qTMP);
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr style="display: none;"> 
                                                        <td class="text-right">Sub categoría</td>
                                                        <td>
                                                            <div id="divSubCategoria">
                                                                <select name="sltCatcatalogoSubCategoria" class="form-control input-sm">
                                                                    <option value="0">Seleccione una opción</option>
                                                                    <?php
                                                                    if( isset($arrData['catalogo_categoria']) ) {
                                                                        $strQuery = "SELECT catalogo_categoria,
                                                                                            nombre
                                                                                     FROM   catalogo_categoria
                                                                                     WHERE  catalogo_categoria_padre = {$arrData['catalogo_categoria']}
                                                                                     ORDER  BY nombre";
                                                                        $qTMP = db_consulta($strQuery);
                                                                        while( $rTMP = db_fetch_assoc($qTMP) ) {
                                                                            ?>
                                                                            <option value="<?php print $rTMP['catalogo_categoria']; ?>" <?php print ( isset($arrData['catalogo_sub_categoria']) && $arrData['catalogo_sub_categoria'] == $rTMP['catalogo_categoria'] ) ? 'selected="selected"' : '' ?> ><?php print $rTMP['nombre']; ?></option>
                                                                            <?php
                                                                        }
                                                                        db_free_result($qTMP);
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr> 
                                                        <td class="text-right">Activo</td>
                                                        <td><input type="checkbox" name="chkActivo" id="chkActivo" value="1" <?php print isset($arrData['activo']) && $arrData['activo'] == 'Y' ? 'checked="checked"' : ''; ?>></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr> 
                                                        <td class="text-right">Destacar</td>
                                                        <td><input type="checkbox" name="chkDestacar" id="chkDestacar" value="1" <?php print isset($arrData['destacar']) && $arrData['destacar'] == 'Y' ? 'checked="checked"' : ''; ?>></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr style="display: none;"> 
                                                        <td class="text-right">Es nuevo</td>
                                                        <td><input type="checkbox" name="chkNuevo" id="chkNuevo" value="1" <?php print isset($arrData['nuevo']) && $arrData['nuevo'] == 'Y' ? 'checked="checked"' : ''; ?>></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr style="display: none;"> 
                                                        <td class="text-right">Recomendar</td>
                                                        <td><input type="checkbox" name="chkRecomendar" id="chkRecomendar" value="1" <?php print isset($arrData['recomendar']) && $arrData['recomendar'] == 'Y' ? 'checked="checked"' : ''; ?>></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    Galería
                                                </div>
                                                <!-- /.panel-heading -->
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table class="table" id="tblImagen">
                                                            <tbody>
                                                                <?php
                                                                $strQuery = "SELECT catalogo_imagen,
                                                                                    catalogo,
                                                                                    imagen
                                                                             FROM   catalogo_imagen
                                                                             WHERE  catalogo = {$intId}";
                                                                $qTMP = db_consulta($strQuery);
                                                                if( db_num_rows($qTMP) == 0 ) {
                                                                    ?>
                                                                    <tr id="trDetalle1_0">
                                                                        <td colspan="3" class="text-center info">No hay imagenes registradas!</td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                                else {
                                                                    while( $rTMP = db_fetch_assoc($qTMP) ) {
                                                                        ?>
                                                                        <tr id="trDetalle_<?php print $intIdImagen; ?>">
                                                                            <td style="vertical-align: top;">
                                                                                <input type="hidden" name="hdnImagen_<?php print $intIdImagen; ?>" id="hdnImagen_<?php print $intIdImagen; ?>" value="<?php print $rTMP['catalogo_imagen'] ?>" readonly="readonly">
                                                                                <input type="text" name="txtImagen_<?php print $intIdImagen; ?>" id="txtImagen_<?php print $intIdImagen; ?>" value="" readonly="readonly">
                                                                                <button id="btnImagen_<?php print $intIdImagen; ?>" type="button" class="btn btn-default btn-xs">
                                                                                    <span class="glyphicon glyphicon-picture"></span>
                                                                                </button>
                                                                                <input type="file" name="fileImagen_<?php print $intIdImagen; ?>" id="fileImagen_<?php print $intIdImagen; ?>" value="" accept="image/*" class="hide">
                                                                                <input type="hidden" name="hdnImagenActual_<?php print $intIdImagen; ?>" value="<?php print isset($rTMP['imagen']) ? $rTMP['imagen'] : ''; ?>" readonly="readonly">
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                if( !empty($rTMP['imagen']) ) {
                                                                                    ?>
                                                                                    <img src="<?php print $rTMP['imagen']; ?>" style="width: 100px; height: 100px;" alt="">
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <button id="btnDetalleEliminar_<?php print $intIdImagen; ?>" type="button" class="btn btn-default btn-xs" onclick="fntEliminarDetalle(<?php print $rTMP['catalogo_imagen'] ?>,<?php print $intIdImagen; ?>);" title="Eliminar">
                                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                        ++$intIdImagen;
                                                                    }
                                                                }
                                                                db_free_result($qTMP);
                                                                ?>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="3">
                                                                        <button id="btnImagenAgregar" type="button" class="btn btn-default btn-xs">
                                                                            <span class="glyphicon glyphicon-plus"></span>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $arrCaracteristica = array();
                                            $strQuery = "SELECT catalogo_caracteristica,
                                                                nombre
                                                         FROM   catalogo_caracteristica
                                                         ORDER  BY nombre";
                                            $qTMP = db_consulta($strQuery);
                                            while( $rTMP = db_fetch_assoc($qTMP) ) {
                                                $arrCaracteristica[$rTMP['catalogo_caracteristica']] = $rTMP['nombre'];
                                            }
                                            db_free_result($qTMP);
                                            $intDetalle2 = 1;
                                            ?>
                                            <div class="panel panel-default" style="display: none;">
                                                <div class="panel-heading">
                                                    Características
                                                </div>
                                                <!-- /.panel-heading -->
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table class="table" id="tblDetalle2">
                                                            <thead>
                                                                <tr>
                                                                    <th width="50%">Característica</th>
                                                                    <th width="45%">Valor</th>
                                                                    <th width="5%">&nbsp;</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $strQuery = "SELECT catalogo_c,
                                                                                    catalogo,
                                                                                    catalogo_caracteristica,
                                                                                    valor
                                                                             FROM   catalogo_c
                                                                             WHERE  catalogo = {$intId}
                                                                             ORDER  BY catalogo_caracteristica, valor";
                                                                $qTMP = db_consulta($strQuery);
                                                                if( db_num_rows($qTMP) == 0 ) {
                                                                    ?>
                                                                    <tr id="trDetalle2_0">
                                                                        <td colspan="3" class="text-center info">No hay caracteristicas registradas!</td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                                else {
                                                                    while( $rTMP = db_fetch_assoc($qTMP) ) {
                                                                        ?>
                                                                        <tr id="trDetalle2_<?php print $intDetalle2; ?>">
                                                                            <td>
                                                                                <input type="hidden" name="hdnDetalle2Id_<?php print $intDetalle2; ?>" id="hdnDetalle2Id_<?php print $intDetalle2; ?>" value="<?php print $rTMP['catalogo_c'] ?>" readonly="readonly">
                                                                                <select name="sltDetalle2Caracteristica_<?php print $intDetalle2; ?>" class="form-control input-sm">
                                                                                    <?php
                                                                                    reset($arrCaracteristica);
                                                                                    while( $arrC = each($arrCaracteristica) ) {
                                                                                        ?>
                                                                                        <option value="<?php print $arrC['key']; ?>" <?php print ($arrC['key'] == $rTMP['catalogo_caracteristica']) ? 'selected="selected"' : ''; ?> ><?php print $arrC['value']; ?></option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" name="txtDetalle2Valor_<?php print $intDetalle2; ?>" id="txtDetalle2Valor_<?php print $intDetalle2; ?>" value="<?php print $rTMP['valor'] ?>" class="form-control input-sm">
                                                                            </td>
                                                                            <td>
                                                                                <button id="btnDetalle2Eliminar_<?php print $intDetalle2; ?>" type="button" class="btn btn-default btn-xs" onclick="fntEliminarDetalle2(<?php print $rTMP['catalogo_c'] ?>,<?php print $intDetalle2; ?>);" title="Eliminar">
                                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                        ++$intDetalle2;
                                                                    }
                                                                }
                                                                db_free_result($qTMP);
                                                                ?>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="3">
                                                                        <button id="btnDetalle2Agregar" type="button" class="btn btn-default btn-xs" onclick="fntAgregarDetalle2();" title="Agregar">
                                                                            <span class="glyphicon glyphicon-plus"></span>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                        <!-- /.col-lg-12 -->
                        <script>
                            
                            var objAjaxEliminarImagen;
                            var objAjaxEliminarDetalle;
                            intNoticiaImagen = <?php print $intIdImagen; ?>;
                            
                            function fntGuardar() {
                                boolValido = true;
                                $('#txtImagen').removeAttr("title");
                                
                                objInput = $('#txtImagen');
                                if( objInput.val().length > 0 ) {
                                    var patt1 = /[A-z0-9]+.gif|[A-z0-9]+.jpg$|[A-z0-9]+.png$/gi;
                                    var result = objInput.val().match(patt1);
                                    console.log(result);
                                    if( result == null ) {
                                        boolValido = false;
                                        $('#txtImagen').attr("title", "Debes seleccionar una imagen.").tooltip({
                                            placement: 'right'
                                        });
                                        $('#txtImagen').tooltip('show');
                                    }
                                }
                                
                                file = document.getElementById('fileImagen').files;
                                if( file.length ) {
                                    if( file[0].size > 2097152 ) {
                                        boolValido = false;
                                        $('#txtImagen').attr("title", "Imagen muy grande. Selecciona una menor a 2 megabytes.").tooltip({
                                            placement: 'right'
                                        });
                                        $('#txtImagen').tooltip('show');
                                    }
                                }   

                                if( boolValido ) {
                                    console.log(boolValido);
                                    $("#frmGeneral").submit();    
                                }

                            }
                            function fntRegresar() {
                                document.location = "<?php print $strAction; ?>";
                            }
                            function fntNoticiaImagenSet() {
                                $("input[id^='txtImagen_']").click( function() {
                                    arrSplit = $(this).attr("id").split("_");
                                    $("#fileImagen_"+ arrSplit[1]).click(); 
                                });
                                $("button[id^='btnImagen_']").click( function() {
                                    arrSplit = $(this).attr("id").split("_");
                                    $("#fileImagen_"+ arrSplit[1]).click(); 
                                });
                                $("input[id^='fileImagen_']").change( function() {
                                    arrSplit = $(this).attr("id").split("_");
                                    $("#txtImagen_"+ arrSplit[1]).val($(this).val()).attr("title", $(this).val());  
                                });
                            }
                            
                            var objAjaxSubCategoria;
                            function fntGetSubCategoria(){
                                if(objAjaxSubCategoria) objAjaxSubCategoria.abort();
                                objAjaxSubCategoria = $.ajax({
                                    url: "<?php print $strAction; ?>",
                                    async: false,
                                    data: "ajaxGetSubCategoria=1&"+$("#frmGeneral").serialize(),
                                    type: "post",
                                    dataType: "html",
                                    beforeSend: function() {
                                    },
                                    success: function(data) {
                                        $("#divSubCategoria").html("");
                                        $("#divSubCategoria").html(data);
                                    }
                                });                            
                            }
                             
                            function fntEliminarImagen(intId){
                                if(objAjaxEliminarImagen) objAjaxEliminarImagen.abort();
                                objAjaxEliminarImagen = $.ajax({
                                    url: "<?php print $strAction; ?>",
                                    async: false,
                                    data: "ajaxEliminar="+intId,
                                    type: "post",
                                    dataType: "html",
                                    success: function(data) {
                                        $("#tdImagen").html('');
                                    }
                                });                            
                            }
                            function fntEliminarDetalle(intId, intCorrelativo){
                                if(objAjaxEliminarDetalle) objAjaxEliminarDetalle.abort();
                                objAjaxEliminarDetalle = $.ajax({
                                    url: "<?php print $strAction; ?>",
                                    async: false,
                                    data: "ajaxEliminarDetalle1="+intId,
                                    type: "post",
                                    dataType: "html",
                                    success: function(data) {
                                        $("#trDetalle_"+intCorrelativo).remove();
                                    }
                                });                            
                            }
                            function fntEliminarDetalleNuevo(intCorrelativo){
                                $("#trDetalle_"+intCorrelativo).remove();
                            }
                            
                            var objAjaxEliminarDetalle2;
                            intDetalle2 = <?php print $intDetalle2; ?>;
                            function fntAgregarDetalle2() {
                                $("#trDetalle2_0").remove();
                                strHtml  = '<tr id="trDetalle2_'+ intDetalle2 +'">';
                                strHtml += '    <td>';
                                strHtml += '        <input type="hidden" name="hdnDetalle2Id_'+ intDetalle2 +'" id="hdnDetalle2Id_'+ intDetalle2 +'" value="0" readonly="readonly">';
                                strHtml += '        <select name="sltDetalle2Caracteristica_'+ intDetalle2 +'" class="form-control input-sm">';
                                            <?php
                                            reset($arrCaracteristica);
                                            while( $arrC = each($arrCaracteristica) ) {
                                                ?>
                                strHtml += '                <option value="<?php print $arrC['key']; ?>"><?php print $arrC['value']; ?></option>';
                                                <?php
                                            }
                                            ?>
                                strHtml += '        </select>';
                                strHtml += '    </td>';
                                strHtml += '    <td>';
                                strHtml += '        <input type="text" name="txtDetalle2Valor_'+ intDetalle2 +'" id="txtDetalle2Valor_'+ intDetalle2 +'" value="" class="form-control input-sm">';
                                strHtml += '    </td>';
                                strHtml += '    <td>';
                                strHtml += '        <button id="btnDetalle2Eliminar_'+ intDetalle2 +'" type="button" class="btn btn-default btn-xs" onclick="fntEliminarDetalle2Nuevo('+ intDetalle2 +');" title="Eliminar">';
                                strHtml += '            <span class="glyphicon glyphicon-trash"></span>';
                                strHtml += '        </button>';
                                strHtml += '    </td>';
                                strHtml += '</tr>';
                                $("#tblDetalle2 > tbody").append(strHtml);
                                intDetalle2++;
                            }                            
                            function fntEliminarDetalle2(intId, intCorrelativo) {
                                if(objAjaxEliminarDetalle2) objAjaxEliminarDetalle2.abort();
                                objAjaxEliminarDetalle2 = $.ajax({
                                    url: "<?php print $strAction; ?>",
                                    async: false,
                                    data: "ajaxEliminarDetalle2="+intId,
                                    type: "post",
                                    dataType: "html",
                                    success: function(data) {
                                        $("#trDetalle2_"+intCorrelativo).remove();
                                    }
                                });                            
                            }
                            function fntEliminarDetalle2Nuevo(intCorrelativo) {
                                $("#trDetalle2_"+intCorrelativo).remove();
                            }
                            
                            $(function() {

                                $("#txtImagen").click( function() {
                                   $("#fileImagen").click(); 
                                });
                                $("#btnImagen").click( function() {
                                   $("#fileImagen").click(); 
                                });
                                $("#fileImagen").change( function() {
                                   $("#txtImagen").val($(this).val()).attr("title", $(this).val()); 
                                });
                                $("#sltCatcatalogoCategoria").change(function() {
                                    fntGetSubCategoria();    
                                });
                                $("#btnImagenAgregar").click( function() {
                                    $("#trDetalle1_0").remove();
                                    strHtml = '<tr id="trDetalle_'+ intNoticiaImagen +'">';
                                    strHtml += '<td>';                                    
                                    strHtml += '<input type="hidden" name="hdnImagen_'+ intNoticiaImagen +'" id="hdnImagen_'+ intNoticiaImagen +'" value="0" readonly="readonly">&nbsp;';
                                    strHtml += '<input type="text" name="txtImagen_'+ intNoticiaImagen +'" id="txtImagen_'+ intNoticiaImagen +'" value="" readonly="readonly">&nbsp;';
                                    strHtml += '<button id="btnImagen_'+ intNoticiaImagen +'" type="button" class="btn btn-default btn-xs">';
                                    strHtml += '<span class="glyphicon glyphicon-picture"></span>';
                                    strHtml += '</button>';                                    
                                    strHtml += '<input type="file" name="fileImagen_'+ intNoticiaImagen +'" id="fileImagen_'+ intNoticiaImagen +'" value="" accept="image/*" class="hide">';
                                    strHtml += '</td>';
                                    strHtml += '<td>&nbsp;</td>';
                                    strHtml += '<td>';
                                        strHtml += '<button id="btnDetalleEliminar_'+ intNoticiaImagen +'" type="button" class="btn btn-default btn-xs" onclick="fntEliminarDetalleNuevo('+ intNoticiaImagen +');" title="Eliminar">';
                                            strHtml += '<span class="glyphicon glyphicon-trash"></span>';
                                        strHtml += '</button>';
                                    strHtml += '</td>';
                                    strHtml += '</tr>';
                                    
                                    $("#tblImagen > tbody").append(strHtml);
                                    fntNoticiaImagenSet();
                                    intNoticiaImagen++;
                                    $("button").tooltip({
                                        placement: 'bottom'
                                    }); 
                                    
                                });
                                $("button").tooltip({
                                    placement: 'bottom'
                                });
                                
                                $("#txtDescripcion").summernote({
                                    //width: 600,
                                    height: 500,
                                    tabsize: 2,
                                    codemirror: {
                                        theme: 'monokai'
                                    }
                                });
                                
                                $("#txtDescripcionEn").summernote({
                                    //width: 600,
                                    height: 500,
                                    tabsize: 2,
                                    codemirror: {
                                        theme: 'monokai'
                                    }
                                });
                                fntNoticiaImagenSet();

                            });
                        </script>
                    </div>
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
                        <h4 class="modal-title">Eliminar el producto</h4>
                    </div>
                    <div class="modal-body" id="divEliminarModalBody">
                        ¿Está seguro?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="fntEliminar(0,'', false)">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function fntEliminar(intId, strTexto, boolConfirmar) {
                
                if( intId > 0 ) {
                    $("#hdnEliminar").val(intId);
                }
                if( strTexto.length > 0 ) {
                    $("#divEliminarModalBody").html('¿Está seguro de eliminar el producto<i>"'+strTexto+'"</i>?');
                }
                if( boolConfirmar ) {
                    $('#myModal').modal();
                }
                else {
                    $('#myModal').modal('hide');
                    $("#frmGeneral").submit();
                }
                
            }
        </script>
    <?php
drawFooter();
?>