<?php


require 'Database.php';

class Usuarios_Encuentros
{
    function __construct()
    {
    }

    /**
     * Retorna en la fila especificada de la tabla 'Usuarios_Encuentros'
     *
     * @param $idUsuario Identificador del registro
     * @return array Datos del registro
     */
    public static function getAll()
    {
        $consulta = "SELECT * FROM usuarios_encuentros";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();

            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     *
     * @param $idEncuentro      identificador
     * @param $descripcion       nueva descripcion
     * @param $deporte_id      deporte realacionado
     * @param $apuntados      personas que van al encuentro
     * @param $capacidad      capacidad del encuentro
     * @param $fecha          fecha del encuentro
     * @param $lat           latitud
     * @param $lon         longitud encuentro
     */
    public static function update(
        $idDeporte,
        $descripcion,
		$deporte_id,
		$apuntados,
		$capacidad,
		$fecha,
		$lat,
		$lon
    )
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE encuentros" . " SET descripcion=?, deporte_id=?, apuntados=?, capacidad=?, fecha=?, lat=?, lon=? " . "WHERE ID=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($descripcion, $deporte_id, $apuntados, $capacidad, $fecha, $lat, $lon, $idEncuentro));

        return $cmd;
    }

    /**
     * Insertar un nuevo Deporte
     *
     * @param $idEncuentro       identificador
     * @param $descripcion       nueva descripcion
     * @param $deporte_id        deporte realacionado
     * @param $apuntados         personas que van al encuentro
     * @param $capacidad         capacidad del encuentro
     * @param $fecha             fecha del encuentro
     * @param $hora              hora del encuentro
     * @param $lat               latitud
     * @param $lon               longitud encuentro
     * @return PDOStatement
     */
    public static function insert($usuario_id, $encuentro_id)
    {
		// Sentencia INSERT
		$comando = "INSERT INTO usuarios_encuentros " . "(usuario_id, encuentro_id)" . " VALUES(?,?)";

		// Preparar la sentencia
		$sentencia = Database::getInstance()->getDb()->prepare($comando);

		return $sentencia->execute(array($usuario_id, $encuentro_id));
    }
	
	public static function asiste($usuario_id, $encuentro_id){
		//Comprobar primero si el usuario ya asiste a ese encuentro
		$consulta = "SELECT * FROM usuarios_encuentros WHERE usuario_id=? AND encuentro_id=?";
		
		try{
			// Preparar la sentencia
			$sentencia = Database::getInstance()->getDb()->prepare($consulta);
			//Ejecutarla
			$sentencia->execute(array($usuario_id, $encuentro_id));
			
			//Capturar resultado
			return $row = $sentencia->fetch(PDO::FETCH_ASSOC);
		}catch(PDOException $e){
			return -1;
		}
	}

    /**
     * Eliminar el registro con el identificador especificado
     * @param $idUsuario 
     * @param $idEncuentro 
     * @return bool Respuesta de la eliminación
     */
    public static function delete($idUsuario, $idEncuentro)
    {
        // Sentencia DELETE
        $comando = "DELETE FROM usuarios_encuentros WHERE usuario_id=? AND encuentro_id=?";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($idUsuario, $idEncuentro));
    }
	
	
	
	/**
	* Consultar los encuentros de un usuario con su id
	*/
	public static function getEncuentrosByUserID($idUsuario){
		//Sentencia SELECT
		$consulta = "SELECT * FROM `encuentros` WHERE ID IN (SELECT encuentro_id FROM usuarios_encuentros WHERE usuario_id=?)";
		
		try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idUsuario));
			
			//Captura los alumnos
			return $comando->fetchAll(PDO::FETCH_ASSOC);
			//$row = $comando->fetch(PDO::FETCH_ASSOC);
            //return $row;
 

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return -1;
        }
	}

}

?>