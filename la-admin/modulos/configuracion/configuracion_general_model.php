<?php
class configuracion_general_model {
    
    function __construct() {
        
    }
    
    public function getConfiguracionGeneral() {
        global $objConexion;
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
        global $objConexion;
        $strCodigo = db_real_escape_string($strCodigo);
        $strValor = db_real_escape_string($strValor);
        $strQuery = "UPDATE configuracion_general SET valor = '{$strValor}' WHERE codigo = '{$strCodigo}'";
        db_consulta($strQuery);
    }
    
}