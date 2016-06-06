<?php

/**
 * Representa la estructura de los Encuentros
 * almacenadas en la base de datos
 */
require 'Database.php';

class Encuentros
{
    function __construct()
    {
    }

    /**
     * Retorna en la fila especificada de la tabla 'Encuentros'
     *
     * @param $idEncuentro Identificador del registro
     * @return array Datos del registro
     */
    public static function getAll()
    {
        $consulta = "SELECT * FROM encuentros";
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
     * Obtiene los campos de un Encuentro con un identificador
     * determinado
     *
     * @param $idEncuentro Identificador del usuario
     * @return mixed
     */
    public static function getById($idEncuentro)
    {
        // Consulta de la tabla Usuarios
        $consulta = "SELECT * FROM encuentros WHERE ID = ?";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idUsuario));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return -1;
        }
    }
	
	/**
     * Incrementar el numero de apuntados a un encuentro
     * @param $ID identificador
     * @param $numApuntados personas que van al encuentro
     **/
    public static function incrementarApuntados(
        $ID,
		$numApuntados
    )
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE encuentros" . " SET apuntados=apuntados+? " . "WHERE ID=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($numApuntados, $ID));

        return $cmd;
    }
	
	public static function reducirApuntados(
        $ID,
		$numApuntados
    )
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE encuentros" . " SET apuntados=apuntados-? " . "WHERE ID=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($numApuntados, $ID));

        return $cmd;
    }

    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     *
     * @param $ID      identificador
     * @param $descripcion       nueva descripcion
     * @param $deporte_id      deporte realacionado
     * @param $apuntados      personas que van al encuentro
     * @param $capacidad      capacidad del encuentro
     * @param $fecha          fecha del encuentro
     * @param $hora          hora del encuentro
     * @param $lat           latitud
     * @param $lon         longitud encuentro
     */
    public static function update(
        $ID,
        $descripcion,
		$deporte_id,
		$apuntados,
		$capacidad,
		$fecha,
		$hora,
		$lat,
		$lon
    )
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE encuentros" . " SET descripcion=?, deporte_id=?, apuntados=?, capacidad=?, fecha=?, hora=?, lat=?, lon=? " . "WHERE ID=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($descripcion, $deporte_id, $apuntados, $capacidad, $fecha, $hora, $lat, $lon, $ID));

        return $cmd;
    }

    /**
     * Insertar un nuevo Encuentro
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
    public static function insert($descripcion, $deporte_id, $apuntados, $capacidad, $fecha, $hora, $lat, $lon)
    {
        // Sentencia INSERT
        $comando = "INSERT INTO encuentros " . "(descripcion, deporte_id, apuntados, capacidad, fecha, hora, lat, lon)" . " VALUES(?,?,?,?,?,?,?,?)";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        $sentencia->execute(array($descripcion, $deporte_id, $apuntados, $capacidad, $fecha, $hora, $lat, $lon));
		
		if($sentencia){
		
			//OBTENER EL ID DEL ÚLTIMO PARTIDO QUE SE HA INSERTADO(ÉSTE)
			$comando = "SELECT MAX(ID) AS 'ID' FROM encuentros";

			try {
				// Preparar sentencia
				$comando = Database::getInstance()->getDb()->prepare($comando);
				// Ejecutar sentencia preparada
				$comando->execute();
				// Capturar primera fila del resultado
				$row = $comando->fetch(PDO::FETCH_ASSOC);
				return $row;

			} catch (PDOException $e) {
				// Aquí puedes clasificar el error dependiendo de la excepción
				// para presentarlo en la respuesta Json
				return -1;
			}
		}else{
			return -2;
		}
    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idEncuentro identificador de la tabla Deportes
     * @return bool Respuesta de la eliminación
     */
    public static function delete($idEncuentro)
    {
        // Sentencia DELETE
        $comando = "DELETE FROM encuentros WHERE ID=?";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($idEncuentro));
    }

}

?>