<?php

/**
 * Representa la estructura de los Deportes
 * almacenadas en la base de datos
 */
require 'Database.php';

class Deportes
{
    function __construct()
    {
    }

    /**
     * Retorna todos los deportes
     */
    public static function getAll()
    {
        $consulta = "SELECT * FROM deportes";
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
     * Obtiene los campos de un Deporte con un identificador
     * determinado
     *
     * @param $idDeporte Identificador del deporte
     * @return mixed
     */
    public static function getById($idDeporte)
    {
        // Consulta de la tabla Usuarios
        $consulta = "SELECT * FROM deportes WHERE ID = ?";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idDeporte));
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
     * @param $idDeporte      identificador
     * @param $nombre      nuevo nombre
     * @param $icono      nuevo icono
     *
     */
    public static function update(
        $idDeporte,
        $nombre,
		$icono
    )
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE deportes" . " SET nombre=?, icono=? " . "WHERE ID=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($nombre, $icono, $idDeporte));

        return $cmd;
    }

    /**
     * Insertar un nuevo Deporte
     *
     * @param $nombre nombre de deporte del nuevo registro
     * @param $icono ruta del icono 
     * @return PDOStatement
     */
    public static function insert($nombre, $icono)
    {
        // Sentencia INSERT
        $comando = "INSERT INTO deportes " . "(nombre, icono)" . " VALUES(?,?)";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($nombre, $icono));
    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idDeporte identificador de la tabla Deportes
     * @return bool Respuesta de la eliminación
     */
    public static function delete($idDeporte)
    {
        // Sentencia DELETE
        $comando = "DELETE FROM deportes WHERE ID=?";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($idDeporte));
    }
}

?>