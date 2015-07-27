<?php
include "Conexion.class.php";
class q extends Conexion {
public function __construct($Host,$User,$Pass,$db){
parent:: __construct($Host,$User,$Pass,$db);
}
//++++++++++++++++++++++++++++++++++++++++++++++++++

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
                                (null,'$resultado[6]',$jornada,$idu,$partido[6]),
                                (null,'$resultado[7]',$jornada,$idu,$partido[7]),
                                (null,'$resultado[8]',$jornada,$idu,$partido[8]);";
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

//----------------------------------------------------------------

public function consultasQuiniela1($cveq1, $idusu){
			$sql = "select * from q1 where cveq1 = '$cveq1'
			and idusu = '$idusu'";
			return $this->ejecutaQuery($sql,$this->conn);
		}

}






?>