<?php	
/*
Clase usuario
Rafael Romero
30/01/2014
*/
class Usuario{
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
	
	//Consulta de Usuario
	public function consultaUsuario($login, $pass){
			$sql = "select us.idusu 'Id',us.nombre_usu 'Nombre',us.apellidopa_usu 'Ap',us.apellidoma_usu 'Am',
					us.correo_usu 'Correo',us.tel_usu 'Telefono',us.estado_usu 'Estado',cu.nom_user 'Usuario',
					cu.rol_usu 'Rol'
					from cuentausuario cu,usuario us
					where nom_user = '$login'
					and contrasena = '$pass'
					and cu.idusu=us.idusu";
			 $datos = $this->solDatos($sql);
			return $datos;
	}
	
	public function verUsuarios(){
			$sql = "SELECT us.idusu 'Id', us.nombre_usu 'Nombre', us.apellidopa_usu 'Ap', us.apellidoma_usu 'Am', us.correo_usu 'Correo', us.tel_usu 'Telefono', us.estado_usu 'Estado', cu.nom_user 'Usuario', cu.rol_usu 'Rol' FROM cuentausuario cu, usuario us where cu.idusu = us.idusu";
			 $datos = $this->solDatos($sql);
			return $datos;
	}
	
	public function listaUsuarios(){
			$sql = "select us.idusu 'Id', us.nombre_usu 'Nombre', us.apellidopa_usu 'Ap', us.apellidoma_usu 'Am',
			us.correo_usu 'Correo', us.tel_usu 'Telefono', us.estado_usu 'Estado', cu.nom_user 'Usuario',
			cu.rol_usu 'Rol', us.nacimiento 'Nacimiento',ci.nombre 'imgperfil'
			From usuario us inner join cuentausuario cu on cu.idusu = us.idusu
			inner join cat_imagenes ci on ci.cve_imagen = us.img_perfil;";
			 $datos = $this->solDatos($sql);
			return $datos;
	}
	public function verUsuarioSel($id){
			$sql = "select us.idusu 'Id', us.nombre_usu 'Nombre', us.apellidopa_usu 'Ap', us.apellidoma_usu 'Am',
			us.correo_usu 'Correo', us.tel_usu 'Telefono', us.estado_usu 'Estado', cu.nom_user 'Usuario',
			cu.rol_usu 'Rol', us.nacimiento 'Nacimiento',ci.nombre 'imgperfil',ci.cve_imagen
			From usuario us inner join cuentausuario cu on cu.idusu = us.idusu
			inner join cat_imagenes ci on ci.cve_imagen = us.img_perfil where cu.idusu = ".$id." and us.idusu =".$id.";";
			 $datos = $this->solDatos($sql);
			return $datos;
	}
	
	//Funcion para validar  si el usuario esta disponible
	public function valUsuNuevo($login){
			$sql = "SELECT * FROM cuentausuario where nom_user like '$login'";
			 $datos = $this->solDatos($sql);
			return $datos;
	}
	
        //Funcion maestra para guardar datos
        public function guardaDatos($sql){
                $this->DBMS();
                $this->setBase();
                $datos = $this->ejecutaQuery($sql);
                $this->cerrarConexion();
                return $datos;
        }
        
        //Funcion para guardar los datos del usuario
        public function guardarUsuario($datosUsu){
            $sql = "insert into usuario(idusu,nombre_usu,apellidopa_usu,apellidoma_usu,nacimiento,correo_usu,tel_usu,estado_usu,img_perfil)
                    values (null,'$datosUsu[0]','$datosUsu[1]','$datosUsu[2]','$datosUsu[9]','$datosUsu[3]','$datosUsu[4]','$datosUsu[7]',$datosUsu[10])";
            $datos = $this->guardaDatos($sql);
            if($datos){
                $datos = $this->guadarLoggin($datosUsu[5],$datosUsu[6],$datosUsu[8]);
            } else {
                $datos = "Error";
            }
            return $datos;
        }
        
        //Funcion para guardar el loggin y contrasena en la tabla cuentaUsuario
        public function guadarLoggin($nom_user,$contrasena,$rol){
            $sql = "select max(idusu) 'idusu' from usuario";
            $rs = $this->solDatos($sql);
            $row = array();
            $row = mysql_fetch_array($rs);
            $numreg = mysql_num_rows($rs);
            //echo $row[0],' - '.$numreg.' - '.$nom_user.' - '.$contrasena.' - ';
            if($numreg>0){
                $sql = "insert into cuentausuario(nom_user,contrasena,rol_usu,idusu)
                    values ('$nom_user','$contrasena','$rol',$row[0])";
                $datos = $this->guardaDatos($sql);
            }else{
                $datos = "Error";
            }
            return $datos;
        }
		
		public function editarUsuario($datos){
			$sql1 = "update cuentausuario set contrasena ='" . $datos['con']."',
			rol_usu ='" . $datos['rol'] . "',
			nom_user ='" . $datos['usu'] .
			"' where idusu =" . $datos['id'];
			
			$sql2 = "update usuario set nombre_usu ='" . $datos['nombre'] ."',
			apellidopa_usu ='". $datos['ap']. "',
			apellidoma_usu ='" . $datos['am']. "',
			correo_usu ='" . $datos['correo']."',
			tel_usu ='". $datos['tel'] .
			"' where idusu =". $datos['id'];

			$this->DBMS();
                        $this->setBase();
                        
                        if($this->ejecutaQuery($sql1)){
				return $this->ejecutaQuery($sql2);
			}else{
				 $this->cerrarConexion();
				return false;
			}
            
		}
		
		function activarUsuario($idusur){
			$sql="update usuario set estado_usu = 'Activo' where idusu = ".$idusur.";";
			$this->DBMS();
            $this->setBase();
			if($this->ejecutaQuery($sql)){
				return true;
			}else{
				 $this->cerrarConexion();
				return false;
			}
		}

		function desactivarUsuario($idusur){
			$sql="update usuario set estado_usu = 'Inactivo' where idusu = ".$idusur.";";
			$this->DBMS();
            $this->setBase();
			if($this->ejecutaQuery($sql)){
				return true;
			}else{
				 $this->cerrarConexion();
				return false;
			}
		}
		
		function activarAdmin($idusur){
			$sql="update cuentausuario set rol_usu = 'admin' where idusu = ".$idusur.";";
			$this->DBMS();
            $this->setBase();
			if($this->ejecutaQuery($sql)){
				return true;
			}else{
				 $this->cerrarConexion();
				return false;
			}
		}


		function activarUser($idusur){
			$sql="update cuentausuario set rol_usu = 'user' where idusu = ".$idusur.";";
			$this->DBMS();
            $this->setBase();
			if($this->ejecutaQuery($sql)){
				return true;
			}else{
				 $this->cerrarConexion();
				return false;
			}
		}
		
		public function buscaUsuario($busca){
			$sql = "SELECT us.idusu 'Id', us.nombre_usu 'Nombre', us.apellidopa_usu 'Ap', us.apellidoma_usu 'Am', 
			us.correo_usu 'Correo', us.tel_usu 'Telefono', us.estado_usu 'Estado', cu.nom_user 'Usuario', 
			cu.rol_usu 'Rol' 
			FROM cuentausuario cu, usuario us 
			where cu.idusu = us.idusu 
			and (us.nombre_usu like '%".$busca."%' or us.apellidopa_usu like '%".$busca."%' or us.apellidoma_usu like '%".$busca."%');";
			 $datos = $this->solDatos($sql);
			return $datos;
	}
	public function eliminarUsuario($idusua){
			$sql1="DELETE FROM cuentausuario where idusu = ". $idusua;
			$sql2 = "DELETE FROM usuario where idusu = ". $idusua;

			$this->DBMS();
            $this->setBase();
                        
            if($this->ejecutaQuery($sql1)){
				return $this->ejecutaQuery($sql2);
			}else{
				$this->cerrarConexion();
				return false;
			}
	}
        
}
?>