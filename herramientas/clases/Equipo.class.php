<?php	
/*
Clase Quiniela
Rafael Romero
30/01/2014
*/

class Equipo{
	public $servidor;
	public $usuario;
	public $password;
	public $db;
	public $conectar;
	
	function __construct($servidor, $usuario, $password, $db){
		$this->servidor = $servidor;
		$this->usuario = $usuario;
		$this->password = $password;
		$this->db = $db;
		$this->conectar = "";
	}
	
	
	
	/*Realiza la conexi�n a la base de datos.*/
	public function DBMS() {
            $this->conectar = mysql_pconnect($this->servidor,$this->usuario,$this->password);
        }
        
        //seleccionar la base
        public function setBase(){
            mysql_select_db($this->db,$this->conectar);
        }
		
        //ejecutar query
        public function ejecutaQuery($sql){
            return mysql_query($sql,$this->conectar);
        }
		
        //cerrar la conexion
        public function cerrarConexion(){
            mysql_close($this->conectar);
        }
		
        //funcion maestra para solicitar datos
        public function solDatos($sql){
                $datos=array();
                $this->DBMS();
                $this->setBase();
                $datos = $this->ejecutaQuery($sql);
                $this->cerrarConexion();
                return $datos;
        }
	
	//Consulta si el usuario ya lleno quiniela de esajornada
	public function mostrarNomEquipo($id){
			$sql = "select nom_equipo from equipo where cve_equipo = $id";
			 $datos = $this->solDatos($sql);
			return $datos;
	}
        
        // Consulta la tabla de posiciones
        public function mostrarTablaPosiciones(){
            $sql = "select nom_equipo,jue_jug,jue_gan,jue_per,jue_emp,gol_fa,gol_con,diferencia_gol,tot_puntos
                    from equipo
					where liga_participa = 1
                    order by tot_puntos desc,diferencia_gol desc,jue_jug asc";
            $datos = $this->solDatos($sql);
            return $datos;
        }
		
	 public function mostrarTablaEquipos(){
            $sql = "select *
                    from equipo
                    order by tot_puntos desc,diferencia_gol desc,jue_jug asc";
            $datos = $this->solDatos($sql);
            return $datos;
    }
	

}
?>
