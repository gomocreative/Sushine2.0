<?php
require('main.php'); 
if( !boolThereLogin() )
    header('location:error.php');

$strAction = basename(__FILE__);
$strForm = 'frmCatcatalogoCategoria';
$boolAlertaEliminar = false;
$boolAlertaCreada = isset($_GET['info']);
$boolAlertaModificada = false;

if( isset($_POST['hdnEliminarcatalogoCategoria']) && intval($_POST['hdnEliminarcatalogoCategoria']) > 0 ) {
    $intCatcatalogoCategoria = isset($_POST['hdnEliminarcatalogoCategoria']) ? $_POST['hdnEliminarcatalogoCategoria'] : 0;
    $strQuery = "DELETE FROM catalogo_categoria WHERE catalogo_categoria = {$intCatcatalogoCategoria}";
    db_consulta($strQuery);
    $boolAlertaEliminar = true;
}
elseif( isset($_POST['hdnCatcatalogoCategoria']) ) {
    
    $intCatcatalogoCategoria = isset($_POST['hdnCatcatalogoCategoria']) ? intval($_POST['hdnCatcatalogoCategoria']) : 0;
    $intCatcatalogoCategoriaTmp = $intCatcatalogoCategoria;
    $strNombre = isset($_POST['txtNombre']) ? db_real_escape_string($_POST['txtNombre']) : '';
    $strNombreEn = isset($_POST['txtNombreEn']) ? db_real_escape_string($_POST['txtNombreEn']) : '';
    $strActivo = isset($_POST['chkActivo']) ? 'Y' : 'N';
    if( $intCatcatalogoCategoria == 0 ) {
        if( !empty($strNombre) ) {
            $strQuery ="INSERT INTO catalogo_categoria(nombre, nombre_en, activo) 
                        VALUES ('{$strNombre}', '{$strNombreEn}', '{$strActivo}')";
            db_consulta($strQuery);
            $intCatcatalogoCategoria = db_insert_id();
        }
    }
    elseif( $intCatcatalogoCategoria > 0 ) {
        if( !empty($strNombre) ) {
            $strQuery ="UPDATE  catalogo_categoria 
                        SET     nombre = '{$strNombre}',
                                nombre_en = '{$strNombreEn}',
                                activo =  '{$strActivo}'
                        WHERE   catalogo_categoria = {$intCatcatalogoCategoria}";
            db_consulta($strQuery);
            $boolAlertaModificada = true;
        }
    }
    if( $intCatcatalogoCategoriaTmp == 0 ) {
        header("location:{$strAction}?info=true");
    }
}
drawHeader("LA-Admin - Categorias");
    ?>
    <form name="<?php print  $strForm; ?>" id="<?php print $strForm; ?>" method="post" action="<?php print $strAction; ?>">
        <?php 
        $intcatalogoCategoria = isset($_GET['catalogo_categoria']) ? intval($_GET['catalogo_categoria']) : -1;
        if( $intcatalogoCategoria == -1 ) {
            ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="index.php">Inicio</a></li>
                            <li><a href="#">Catálogo</a></li>
                            <li><a href="<?php print $strAction; ?>" class="active">Categoria</a></li>
                        </ol>
                        <h1 class="page-header">Categorias</h1>
                    </div>
                    <?php
                    if( $boolAlertaEliminar ) {
                        ?>
                        <div class="col-lg-4 col-lg-offset-4">
                            <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span class="glyphicon glyphicon-warning-sign"></span>&nbsp;<strong>Aviso:</strong>&nbsp;Categoria eliminada.
                            </div>
                        </div>
                        <?php
                    }
                    if( $boolAlertaCreada ) {
                        ?>
                        <div class="col-lg-5 col-lg-offset-3">
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span class="glyphicon glyphicon-info-sign"></span>&nbsp;<strong>información:</strong>&nbsp;Categoria creada exitosamente.
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <button type="button" class="btn btn-primary btn-sm" onclick="fntNuevacatalogoCategoria();">
                                  <span class="glyphicon glyphicon-asterisk"></span>&nbsp;Nueva categoria
                                </button>
                                <script>
                                    function fntNuevacatalogoCategoria() {
                                        document.location = "<?php print $strAction; ?>?catalogo_categoria=0";
                                    }
                                    function fntEditarcatalogoCategoria(intcatalogoCategoria) {
                                        document.location = "<?php print $strAction; ?>?catalogo_categoria="+intcatalogoCategoria;
                                    }
                                </script>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="tblPaginas">
                                        <thead>
                                            <tr>
                                                <th width="10%" class="text-center">ID</th>
                                                <th width="35%">Nombre</th>
                                                <th width="30%">Nombre (Inglés)</th>
                                                <th width="10%" class="text-center">Activo</th>
                                                <th width="15%" class="text-center">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $strQuery = 'SELECT catalogo_categoria,
                                                                nombre,
                                                                nombre_en,
                                                                activo
                                                         FROM   catalogo_categoria
                                                         WHERE  catalogo_categoria_padre IS NULL
                                                         ORDER  BY catalogo_categoria';
                                            $qTMP = db_consulta($strQuery);
                                            while( $rTMP = db_fetch_assoc($qTMP) ) {
                                                ?>
                                                <tr class="odd gradeX">
                                                    <td class="text-center"><a href="<?php print $strAction; ?>?catalogo_categoria=<?php print $rTMP["catalogo_categoria"]; ?>"><?php print $rTMP["catalogo_categoria"]; ?></a></td>
                                                    <td><?php print $rTMP["nombre"]; ?></td>
                                                    <td><?php print $rTMP["nombre_en"]; ?></td>
                                                    <td class="text-center"><?php print $rTMP["activo"] == 'Y' ? 'Si' : 'No'; ?></td>
                                                    <td class=" text-center">
                                                        <button type="button" class="btn btn-info btn-xs" onclick="fntEditarcatalogoCategoria(<?php print $rTMP["catalogo_categoria"]; ?>);" data-toggle="tooltip" data-placement="bottom" title="Editar categoria de catalogo">
                                                          <span class="glyphicon glyphicon-pencil"></span>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-xs" onclick="fntEliminarcatalogoCategoria(<?php print $rTMP["catalogo_categoria"]; ?>, '<?php print $rTMP["nombre"]; ?>', true);" data-toggle="tooltip" data-placement="bottom" title="Eliminar categoria de catalogo">
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
            $strQuery = "SELECT catalogo_categoria,
                                nombre,
                                nombre_en,
                                activo
                         FROM   catalogo_categoria
                         WHERE  catalogo_categoria = {$intcatalogoCategoria}";
                         
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
                            <li><a href="#">Catálogo</a></li>
                            <li><a href="<?php print $strAction; ?>">Categoria</a></li>
                            <li class="active"><?php print isset($arrData['nombre']) ? $arrData['nombre'] : 'Nueva categoria'; ?></li>
                        </ol>
                        <h1 class="page-header">Categoria</h1>
                    </div>
                    <?php
                    if( $boolAlertaModificada ) {
                        ?>
                        <div class="col-lg-5 col-lg-offset-4">
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span class="glyphicon glyphicon-info-sign"></span>&nbsp;<strong>información:</strong>&nbsp;Categoria modificada exitosamente.
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
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <input type="hidden" name="hdnCatcatalogoCategoria" value="<?php print $intcatalogoCategoria; ?>" readonly="readonly">
                                    <div class="col-lg-8 col-lg-offset-2">
                                        <table width="100%" class="table">
                                            <tbody>
                                                <tr> 
                                                    <td width="20%" class="text-right">Nombre</td>
                                                    <td width="50%"><input type="text" name="txtNombre" id="txtNombre" value="<?php print isset($arrData['nombre']) ? $arrData['nombre'] : ''; ?>" autofocus="autofocus" maxlength="255" required="required"></td>
                                                    <td width="30%">&nbsp;</td>
                                                </tr>
                                                <tr> 
                                                    <td class="text-right">Nombre (Inglés)</td>
                                                    <td><input type="text" name="txtNombreEn" id="txtNombreEn" value="<?php print isset($arrData['nombre_en']) ? $arrData['nombre_en'] : ''; ?>" autofocus="autofocus" maxlength="255" required="required"></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr> 
                                                    <td class="text-right">Activo</td>
                                                    <td><input type="checkbox" name="chkActivo" id="chkActivo" value="1" <?php print isset($arrData['activo']) && $arrData['activo'] == 'Y' ? 'checked="checked"' : ''; ?>></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>                                            
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
                        function fntGuardar() {
                            boolValido = true;
                            
                            if( boolValido ) {
                                $("#<?php print $strForm; ?>").submit();    
                            }

                        }
                        function fntRegresar() {
                            document.location = "<?php print $strAction; ?>";
                        }
                    </script>
                </div>
            </div>
            <?php
        }
        ?>
        <input type="hidden" name="hdnEliminarcatalogoCategoria" id="hdnEliminarcatalogoCategoria" value="0"  readonly="readonly">
    </form>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Eliminar categoria de catalogo</h4>
                </div>
                <div class="modal-body" id="divEliminarModalBody">
                    ¿Está seguro?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="fntEliminarcatalogoCategoria(0,'', false)">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function fntEliminarcatalogoCategoria(intcatalogoCategoria, strTexto, boolConfirmar) {
            
            if( intcatalogoCategoria > 0 ) {
                $("#hdnEliminarcatalogoCategoria").val(intcatalogoCategoria);
            }
            if( strTexto.length > 0 ) {
                $("#divEliminarModalBody").html('¿Está seguro de eliminar la categoria de catalogo <i>"'+strTexto+'"</i>?');
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