<?php
require('main.php'); 

if( !empty($_POST['txtUsuario']) && !empty($_POST['txtPassword']) ) {
    $_SESSION['login_error'] = "Usuario y/o contraseña invalida.";
    $strUsuario = db_real_escape_string(trim($_POST['txtUsuario']));
    $strPassword = db_real_escape_string(trim($_POST['txtPassword']));
    $strQuery = "SELECT usuario,
                        nombre,
                        cuenta,
                        email,
                        tipo_usuario
                 FROM   usuario
                 WHERE  cuenta = '{$strUsuario}'
                 AND    password = MD5('{$strPassword}')";
    $qTMP = db_consulta($strQuery);
    while( $rTMP = db_fetch_assoc($qTMP) ) {
        $_SESSION['login'] = true;
        $_SESSION['usuario'] = $rTMP['usuario'];
        $_SESSION['nombre'] = $rTMP['nombre'];
        $_SESSION['cuenta'] = $rTMP['cuenta'];
        $_SESSION['email'] = $rTMP['email'];
        $_SESSION['tipo_usuario'] = $rTMP['tipo_usuario'];
        unset($_SESSION['login_error']);
    }
    db_free_result($qTMP);
    
}
elseif( ( !empty($_POST['txtUsuario']) && empty($_POST['txtPassword']) ) || ( empty($_POST['txtUsuario']) && !empty($_POST['txtPassword']) ) ) {
    $_SESSION['login_error'] = "Usuario y/o contraseña invalida.";
}

if( !boolThereLogin() )
    header('location:login.php');

$strAction = basename(__FILE__);
drawHeader("Administrador 2.0");

    ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dashboard</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
            </div>
            <div class="col-lg-4">
            </div>
        </div>
    </div>
    <?php
drawFooter();
?>