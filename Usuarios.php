<?php

/**
 * Representa la estructura de los Usuarios
 * almacenadas en la base de datos
 */
require 'Database.php';

class Usuarios
{
    function __construct()
    {
    }

    /**
     * Retorna todos los usuarios
     */
    public static function getAll()
    {
        $consulta = "SELECT * FROM usuarios";
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
     * Obtiene los campos de un Usuario con un identificador
     * determinado
     *
     * @param $idUsuario Identificador del usuario
     * @return mixed
     */
    public static function getById($idUsuario)
    {
        // Consulta de la tabla Usuarios
        $consulta = "SELECT * FROM usuarios WHERE ID = ?";

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
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     *
     * @param $idUsuario      identificador
     * @param usuario nuevo nombre de usuario
     *
     */
    public static function updateUsername(
        $idUsuario,
        $usuario
    )
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE usuarios" . " SET usuario=? " . "WHERE ID=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($usuario, $idUsuario));

        return $cmd;
    }
	
	/**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     *
     * @param $idUsuario      identificador
     * @param $nombre      nuevo nombre
     
     */
    public static function updateNombre(
        $idUsuario,
        $nombre
    )
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE usuarios" . " SET nombre=? " . "WHERE ID=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($nombre, $idUsuario));

        return $cmd;
    }
	
	/**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     *
     * @param $idUsuario      identificador
     * @param $contrasena nueva contrasena
     
     */
    public static function updateContrasena(
        $idUsuario,
        $contrasena
    )
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE usuarios" . " SET contrasena=? " . "WHERE ID=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($contrasena, $idUsuario));

        return $cmd;
    }

    /**
     * Insertar un nuevo Usuario
     *
     * @param $usuario nombre de usuario del nuevo registro
     * @param $contraseña contraseña del nuevo registro
	 * @param $rutaimagen ruta de la imagen del nuevo registro
     * @return PDOStatement
     */
    public static function insert($usuario, $nombre, $contrasena)
    {
        // Sentencia INSERT
        $comando = "INSERT INTO usuarios " . "(usuario, nombre, contrasena)" . " VALUES(?,?,?)";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($usuario, $nombre, $contrasena));
    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idUsuario identificador de la tabla Usuarios
     * @return bool Respuesta de la eliminación
     */
    public static function delete($idUsuario)
    {
        // Sentencia DELETE
        $comando = "DELETE FROM usuarios WHERE ID=?";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($idUsuario));
    }
	
	/*
	*Validar el login retornando la contraseña del usuario que se le pase a esta función
	*
	*@param $usuario
	*@return PDOStatement
	*/
	public static function login($usuario){
		//Sentencia SELECT
		$consulta = "SELECT ID, nombre, contrasena AS contrasena FROM usuarios WHERE usuario=?";
		
		try{
			//Preparar la sentencia
			$comando = Database::getInstance()->getDb()->prepare($consulta);
			
			//Ejecutarla
			$comando->execute(array($usuario));
			
			//Capturar un resultado
			return $row = $comando->fetch(PDO::FETCH_ASSOC);
			
		}catch(PDOException $e){
			return -1;
		}
	}
	
	public static function existeUsuario($usuario){
		//Sentencia SELECT
		$consulta = "SELECT * FROM usuarios WHERE usuario=?";
		
		try{
			//Preparar la sentencia
			$comando = Database::getInstance()->getDb()->prepare($consulta);
			
			//Ejecutarla
			$comando->execute(array($usuario));
			
			//Capturar resultado
			return $row = $comando->fetch(PDO::FETCH_ASSOC);
		}catch(PDOException $e){
			return -1;
		}
	}

}

?>		