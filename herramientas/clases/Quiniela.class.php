<?php	
/*
Clase Quiniela
Rafael Romero
30/01/2014
*/

class Quiniela{
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
	public function consultaUsuariYaLleno($id,$jor){
            $sql = "select * from quiniela where Usuario_idusu = ".$id." and Jornada_cve_jornada =".$jor.";";
            $datos = $this->solDatos($sql);
            return $datos;
	}
	
        public function insertarQuiniela($resultado,$jornada,$idu,$partido){
            $this->DBMS();
            $this->setBase();	
			
            $sql="insert into quiniela(cve_quiniela,resultado_quiniela,Jornada_cve_jornada,Usuario_idusu,Partido_cve_partido)
                                  values(null,'$resultado[0]',$jornada,$idu,$partido[0]),
                                        (null,'$resultado[1]',$jornada,$idu,$partido[1]),
                                        (null,'$resultado[2]',$jornada,$idu,$partido[2]),
                                        (null,'$resultado[3]',$jornada,$idu,$partido[3]),
                                        (null,'$resultado[4]',$jornada,$idu,$partido[4]),
                                        (null,'$resultado[5]',$jornada,$idu,$partido[5]),
                                        (null,'$resultado[6]',$jornada,$idu,$partido[6]);";
            echo '<p>'.$sql.'</p>';
            $res = $this->ejecutaQuery($sql);
            $this->cerrarConexion();
            return $res;
        }
        
        public function insertarComodin($comodin1,$comodin2,$idu,$jornada,$partido){
            $this->DBMS();
            $this->setBase();
            if($comodin1=='L'){
                $comodin1 = 'local';
            }else if($comodin1=='E'){
                $comodin1 = 'empate';
            }else if($comodin1=='V'){
                $comodin1 = 'visitante';
            }
            if($comodin2=='L'){
                $comodin2 = 'local';
            }else if($comodin2=='E'){
                $comodin2 = 'empate';
            }else if($comodin2=='V'){
                $comodin2 = 'visitante';
            }
            $sql="insert into comodin (resultado_comodin,usuario_idusu,jornada_cve_jornada,partido_cve_partido)
                               values ('$comodin1',$idu,$jornada,$partido),
                                      ('$comodin2',$idu,$jornada,$partido);";
            echo '<p>'.$sql.'</p>';
            $res = $this->ejecutaQuery($sql);
            $this->cerrarConexion();
            return $res;
        }

        //++++++++++++++++++++++++++++++++++++++++++++++++
        public function eliminarQuiniela1($cveq1){
            $sql = "delete from q1 where cveq1 = $cveq1";
            return $this->ejecutaQuery($sql,$this->conn);
        }

        //****************************************************

        public function consultaQuiniela1($cveq1){
            $sql = "select * from q1 where cveq1 = $cveq1";
            return $this->ejecutaQuery($sql,$this->conn);
        }

        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%5

        public function modificaQuiniela1($datos){
            $sql = "update q1 set idusu= '$datos[1]',
            p1j1 = '$datos[2]',
            p2j1= '$datos[3]',
            p3j1 = '$datos[4]',
            p4j1 = '$datos[5]',
            p5j1 = '$datos[6]',
            p6j1 = '$datos[7]',
            p7j1 = '$datos[8]',
            p8j1 = '$datos[9]',
            p9j1 = '$datos[10]',
            p10j1 = '$datos[11]',
            totalq1 = '$datos[12]'
            where cveq1= $datos[0]";
            return $this->ejecutaQuery($sql,$this->conn);
        }
        

}
?>
