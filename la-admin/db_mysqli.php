<?php
function db_conectar($db_host, $db_username, $db_password, $db_dbname) {
    $objConexion = mysqli_connect($db_host,$db_username,$db_password,$db_dbname);
    if( mysqli_connect_errno() ) {
        printf("<pre>Falló la conexión: %s</pre>", mysqli_connect_error());
        exit();
    }
    return $objConexion;
}

function db_cerrar() {
    global $objConexion;
    mysqli_close($objConexion);
}

function db_consulta($strQuery) {
    global $objConexion;
    $qTMP = mysqli_query($objConexion,$strQuery);
    $strError = mysqli_error($objConexion);
    if( strlen($strError) > 0 ) { 
        print("<h3>{$strError}</h3><br><pre>");
        print_r(debug_backtrace());
        print("</pre><hr>");
        $qTMP = false;
    }
    return $qTMP; 
}

function db_fetch_assoc($rTMP) {
    return mysqli_fetch_assoc($rTMP);
}

function db_free_result($rTMP) {
    return mysqli_free_result($rTMP);
}

function db_insert_id() {
    global $objConexion;
    return mysqli_insert_id($objConexion);
}

function db_real_escape_string($strEscape) {
    global $objConexion;
    return mysqli_real_escape_string($objConexion,$strEscape);
}

function db_num_rows($rTMP) {
    return mysqli_num_rows($rTMP);
}

function db_affected_rows() {
    global $objConexion;
    return mysqli_affected_rows($objConexion);
}