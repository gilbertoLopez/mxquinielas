<?php	
/*
Clase usuario
Rafael Romero
30/01/2014
*/

class Partido{
	
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
	
	
	
	/*Realiza la conexion a la base de datos.*/
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
	
	//Consulta de Partidos de una jornada
	public function consultaPartidosJornada($jornada){
			$sql = "select * from partido where Jornada_cve_jornada = '$jornada' order by fecha asc";
			 $datos = $this->solDatos($sql);
			return $datos;
	}
	
        //Consulta fecha y hora de inicio de la jornada
	public function consultaInicioJornada($jornada){
			$sql = "select min(fecha) fecha,hora from partido where jornada_cve_jornada = $jornada";
			 $datos = $this->solDatos($sql);
			return $datos;
	}

}
?>
