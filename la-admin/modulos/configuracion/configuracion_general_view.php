<?php
require_once("configuracion_general_model.php");

class configuracion_general_view {
    
    public $objModel;
    public $strAlertaTipo = "";

    function __construct() {
        $this->objModel = new configuracion_general_model();
    }

    function drawContenido() {
        global $strAction, $boolEdicion, $strDirectorio, $strDirectorioBase;
        ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li><a href="index.php">Inicio</a></li>
                        <li><a href="<?php print $strAction; ?>" class="active">Configuración</a></li>
                        <li><a href="<?php print $strAction; ?>" class="active">General</a></li>
                    </ol>
                    <h3 class="page-header">General</h3>
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
                    <div class="panel-heading">
                        <button type="button" class="btn btn-success btn-sm" onclick="fntGuardar();">
                            <span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Guardar
                        </button>
                        <script>
                            function fntGuardar() {
                                $("#frmGeneral").submit();
                            }
                        </script>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <?php
                        $arrConfiguracionGeneral = $this->objModel->getConfiguracionGeneral();
                        reset($arrConfiguracionGeneral);
                        while( $arrCG = each($arrConfiguracionGeneral) ) {
                            ?>
                            <div class="form-group form-group-sm">
                                <?php
                                if( $arrCG["value"]["tipo"] == "text" ){
                                    ?>
                                    <label class="col-sm-3 col-sm-offset-1 control-label"><?php print $arrCG["value"]["nombre"]; ?></label>
                                    <div class="col-sm-5">
                                        <input type="text" name="<?php print $arrCG["value"]["codigo"]; ?>" value="<?php print $arrCG["value"]["valor"]; ?>" class="form-control input-sm">
                                    </div>
                                    <?php    
                                }
                                elseif( $arrCG["value"]["tipo"] == "textarea" ) {
                                    ?>
                                    <label class="col-sm-3 col-sm-offset-1 control-label"><?php print $arrCG["value"]["nombre"]; ?></label>
                                    <div class="col-sm-5">
                                        <textarea name="<?php print $arrCG["value"]["codigo"]; ?>" class="form-control input-sm"><?php print $arrCG["value"]["valor"]; ?></textarea>
                                    </div>
                                    <?php
                                }
                                elseif( $arrCG["value"]["tipo"] == "img" ) {
                                    $strValor = "";
                                    if( file_exists("imagenes/{$arrCG["value"]["valor"]}")) {
                                        $strValor = $arrCG["value"]["valor"];
                                    }
                                    ?>
                                    <label class="col-sm-3 col-sm-offset-1 control-label"><?php print $arrCG["value"]["nombre"]; ?></label>
                                    <div class="col-sm-2">
                                        <div id="<?php print $arrCG["value"]["codigo"]; ?>" class="btngf btngf-getFile btngf-primary">Seleccione imagen</div>
                                        <div class="progress">
                                            <div id="progressBar<?php print $arrCG["value"]["codigo"]; ?>" class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" name="<?php print $arrCG["value"]["codigo"]; ?>" id="tags<?php print $arrCG["value"]["codigo"]; ?>" class="" value="<?php print $strValor; ?>">
                                    </div>
                                    <script>
                                        <?php
                                        if( !empty($strValor) ){
                                            ?>
                                            $.data(document, '<?php print $strValor; ?>', '#<?php print $arrCG["value"]["codigo"]; ?>');
                                            $('#progressBar<?php print $arrCG["value"]["codigo"]; ?>').html("100%");
                                            $('#progressBar<?php print $arrCG["value"]["codigo"]; ?>').attr('aria-valuenow', 100);
                                            $('#progressBar<?php print $arrCG["value"]["codigo"]; ?>').css('width', 100 + '%');
                                            <?php
                                        }
                                        ?>
                                        $('#tags<?php print $arrCG["value"]["codigo"]; ?>').tagsInput({
                                            'width':        '100%',
                                            'height':       'auto',
                                            'interactive':  false,
                                            'defaultText':  '',
                                            'onRemoveTag': function(value) {
                                                var button = $.data(document, value);
                                                var reference = $(button).data('getFile');
                                                deleteFile<?php print $arrCG["value"]["codigo"]; ?>(reference, reference.options.folder + '/' + value, true);
                                            }
                                        });
                                        $('#<?php print $arrCG["value"]["codigo"]; ?>').getFile({
                                            urlPlugin: '<?php print $strDirectorioBase; ?>',
                                            folder: '/<?php print $strDirectorio; ?>/imagenes',
                                            tmpFolder: '/<?php print $strDirectorio; ?>/imagenes/tmp',
                                            //urlPlugin: '../../',
                                            //folder: '/demo/la-admin/imagenes',
                                            //tmpFolder: '/demo/la-admin/imagenes/tmp',
                                            //urlPlugin: '../',
                                            //folder: '/la-admin/imagenes',
                                            //tmpFolder: '/la-admin/imagenes/tmp',
                                            crop: {
                                                active:         true,
                                                width:          <?php print $arrCG["value"]["ancho"]; ?>,
                                                height:         <?php print $arrCG["value"]["alto"]; ?>,
                                                aspectRatio:    2
                                            },
                                        },
                                        function(data){
                                            if(data.success && data.action == "loading") {
                                                $('#progressBar<?php print $arrCG["value"]["codigo"]; ?>').html(data.percentage + '%');
                                                $('#progressBar<?php print $arrCG["value"]["codigo"]; ?>').attr('aria-valuenow', data.percentage);
                                                $('#progressBar<?php print $arrCG["value"]["codigo"]; ?>').css('width', data.percentage + '%');
                                            }
                                            else {
                                                if(data.success) {
                                                    
                                                    if( $('#tags<?php print $arrCG["value"]["codigo"]; ?>').val().length > 0 ) {
                                                        var button = $.data(document, $('#tags<?php print $arrCG["value"]["codigo"]; ?>').val());
                                                        var reference = $(button).data('getFile');
                                                        deleteFile<?php print $arrCG["value"]["codigo"]; ?>(reference, reference.options.folder + '/' + $('#tags<?php print $arrCG["value"]["codigo"]; ?>').val(), false);
                                                    }
                                                    $('#tags<?php print $arrCG["value"]["codigo"]; ?>').importTags('');
                                                    $('#tags<?php print $arrCG["value"]["codigo"]; ?>').addTag(data.name);
                                                    $.data(document, data.name, '#<?php print $arrCG["value"]["codigo"]; ?>');
                                                }
                                            }
                                        });
                                        function deleteFile<?php print $arrCG["value"]["codigo"]; ?>(reference, url, boolProgresBar){
                                            reference.delete(url, function(data) {
                                                if( boolProgresBar ) {
                                                    $('#progressBar<?php print $arrCG["value"]["codigo"]; ?>').html("");
                                                    $('#progressBar<?php print $arrCG["value"]["codigo"]; ?>').attr('aria-valuenow', 0);
                                                    $('#progressBar<?php print $arrCG["value"]["codigo"]; ?>').css('width', 0 + '%');
                                                }
                                            });
                                        }
                                    </script>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                        <script>
                            function syntaxHighlight(json) // By Pumbaa80
                            {
                                if (typeof json != 'string') {
                                    json = JSON.stringify(json, undefined, 2);
                                }
                                json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                                return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
                                    var cls = 'number';
                                    if (/^"/.test(match)) {
                                        if (/:$/.test(match)) {
                                            cls = 'key';
                                        } else {
                                            cls = 'string';
                                        }
                                    } else if (/true|false/.test(match)) {
                                        cls = 'boolean';
                                    } else if (/null/.test(match)) {
                                        cls = 'null';
                                    }
                                    return '<span class="' + cls + '">' + match + '</span>';
                                });
                            }
                        </script>
                    </div>
                </div>
            </form>
        </div>
        <?php
    }

}