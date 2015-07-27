<?php
/*
 *  ELABORADO POR FRANCISCO GILBERTO LOPEZ VELAZCO
 *                  01/2014
 *                  
 */

class Conexion
{
    
    //variables de conexion ...
        
    private $conexion;
    private $servidor;
    private $usuario;
    private $clave;
    private $base;
    private $resultado;
    
    public function __construct($serv,$usua,$clav,$base) //constructor ..
    {
        // Se inicializan las variables ...
        $this->servidor  = $serv;
        $this->usuario   = $usua;
        $this->clave     = $clav;
        $this->base      = $base;
        $this->conexion  = NULL;
        $this->resultado = NULL;
        // se ejecuta la funcion ...
        $this->conexionBD();

    }
    
    //conexion a la base de datos ...
    private function conexionBD()
    { 
        $this->conexion = mysqli_connect($this->servidor,$this->usuario,$this->clave)  or  
        $this->msgErrores('... A ocurrido un error al intentar conectarse al Servidor de Base de Datos',
                           mysqli_connect_error($this->conexion)); 
        $this->setBase($this->base);
    }
    
    //seleccionar la base ...
    private function setBase($base)
    {
        //Se conecta a la base de datos ...
        $this->base = mysqli_select_db($this->conexion,$base)   or
        $this->msgErrores('... A ocurrido un error al intentar conectarse a la Base de Datos',
                          'Base de datos "'.$base.'" no encontrada');
        //Se guarda el nombre de la base de datos
        $this->nombreBase = $base;
    }
    
    
    public function query($sql,$regresa='')                                    //se ejecuta la consulta, y regresa varias cosillas ...
    {  
        $this->resultado = @mysqli_query($this->conexion,$sql) or 
        $this->msgErrores('... A ocurrido un error en la consulta',mysqli_error($this->conexion).' <br><br> <b>Consulta:</b><i> '.$sql.'</i>');
        switch($regresa)
        {
            case ''                  : return $this->resultado; break;
            case 'arregloNumerico'   : return $this->arregloNumerico(); break;
            case 'arregloAsociado'   : return $this->arregloAsociado(); break;
            case 'arregloUnicoNum'   : return $this->arregloUnico(); break;
            case 'arregloUnicoAsoc'  : return $this->arregloUnicoAsociado(); break;
            case 'numColums&Regs'    : return $this->numeroColumYReg(); break;
            case 'id'                : return mysqli_insert_id($this->conexion); break;
            case 'registro'          : return mysqli_fetch_assoc($this->resultado); break;
            case 'registroNumerico'  : return mysqli_fetch_row($this->resultado); break;
            case 'afecto?'           : return mysqli_affected_rows($this->conexion); break;
            case 'numeroColumnas'    : return mysqli_num_fields($this->resultado); break;
            case 'numeroRegistros'   : return mysqli_num_rows($this->resultado); break;
        }
    }
    
    public function numeroColumYReg($cual = 0)
    {
        $ar = null;
        $nR = mysqli_num_rows($this->resultado);
        $nC = mysqli_num_fields($this->resultado);
        if($cual == 0)
        {
            $ar['registros'] = $nR;
            $ar['columnas']  = $nC;
        }
        else if($cual == 1){
            $ar = $nR;
        }
        else if($cual == 2){
            $ar = $nC;
        }
        return $ar;
    }
    
    //devuelve el resultado en un arreglo numerico ...
    public function arregloNumerico()
    {
        $n = mysqli_num_fields($this->resultado);
        $x = 0;
        $arreglo = array();
        while($result = mysqli_fetch_array($this->resultado))
        {
            for($i = 0; $i < $n; $i++)
            {
                $arreglo[$x][$i] = $result[$i];
            }
            $x++;
        }
        $this->libera();
        return $arreglo;
    }
    
    //devuelve el resultado en un arreglo unico (util cuando se sepa que el resultado es un solo registro o es solo un campo)  ...
    public function arregloUnico()
    {
        $n = mysqli_num_fields($this->resultado);
        $arreglo = array();
        while($result = mysqli_fetch_array($this->resultado))
        {
            for($i = 0; $i < $n; $i++)
            {
                $arreglo[] = $result[$i];
            }
        }
        $this->libera();
        return $arreglo;
    }
    
    //devuelve el resultado en un arreglo unico asociado (util para un solo registro)...
    public function arregloUnicoAsociado()
    {
        $arreglo = array();
        while($result = mysqli_fetch_assoc($this->resultado))
        {
            foreach($result as $nombre => $valor)
            {
                $arreglo[$nombre] = $valor;
            }
        }
        $this->libera();
        return $arreglo;
    }
    
    //devuelve el resultado en un arreglo asociado...
    public function arregloAsociado()
    {
        $x = 0;
        $arreglo = array();
        while($result = mysqli_fetch_assoc($this->resultado))
        {
            foreach($result as $nombre => $valor)
            {
                $arreglo[$x][$nombre] = $valor;
            }
            $x++;
        }
        $this->libera();
        return $arreglo;
    }
    
    public function fetchRow()
    {
        return mysqli_fetch_row($this->resultado);
    }
    
    public function fetchArray()
    {
        return mysqli_fetch_array($this->resultado);
    }
    
    public function fetchAssoc()
    {
        return mysqli_fetch_assoc($this->resultado);
    }
    
    //libera la memoria asociada con la consulta ...
    public function libera()
    {
        @mysql_free_result($this->resultado);
    }
    
    // se muestra un mensaje con formato ...
    private function msgErrores($mensaje, $especificacionError = '')
    {
        $msgFormato1 = '<pre><br/><label style="color: red;">%s</label>';
        $msgFormato2 = ' <b>(</b>  %s <b>)</b>';
        $msg         = sprintf($msgFormato1,ucfirst( $mensaje ));
        $msg        .= (trim($especificacionError) != '')? sprintf($msgFormato2,$especificacionError) : '';
        $msg        .= '<br/></pre>';
        die($msg);
    }
    
    //cerrar la conexion ..
    public function cerrarConexion()
    {
        //se guarda los cambios ...
        //mysqli_commit($this->conexion);
        $this->libera();
        //se cierra la conexion ...
        @mysqli_close($this->conexion);
    }
    
    /*
     *  FUNCION DESTRUCT:
     *      * Se forza a cerrar la conexion una vez que php detecta que el objeto
     *      * de la clase ya no es utilizado, de tal manera si se olvida
     *      * cerrar la conexion manualmente, php lo hara ...
     */
    public function __destruct()
    {
        if($this->conexion)
        {
            $this->cerrarConexion(); 
        }
    }
}

?>