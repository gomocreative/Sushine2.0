<?php
require('main.php');
if( isset($_GET['logout']) && $_GET['logout'] == '4236a440a662cc8253d7536e5aa17942' ) {
    unset($_SESSION['login']);
    unset($_SESSION['usuario']);
    unset($_SESSION['nombre']);
    unset($_SESSION['cuenta']);
    unset($_SESSION['email']);
    unset($_SESSION['tipo_usuario']);
}
getConfiguracionGeneral();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php print NOMBRE_EMPRESA; ?> (Administrador 2.0)</title>
    <link rel="shortcut icon" href="imagenes/<?php print FAVICON_EMPRESA; ?>">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/sb-admin.css" rel="stylesheet">
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/sb-admin.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-md-offset-5">
                <img src="<?php print "imagenes/".LOGO_EMPRESA; ?>" class="img-responsive" alt=""/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-5">
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Acceso</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" action="index.php">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Usuario" name="txtUsuario" type="text" autocomplete="off" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Contraseña" name="txtPassword" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Recordar
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg btn-block">
                                    Iniciar sesión
                                </button>
                            </fieldset>
                        </form>
                    </div>
                    <?php
                    if( !empty($_SESSION['login_error']) ) {
                        ?>
                        <div class="panel-footer">
                            <div class="alert alert-danger text-center"><?php print isset($_SESSION['login_error']) ? $_SESSION['login_error'] : ''; ?></div>
                        </div>
                        <?php
                        unset($_SESSION['login_error']);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>