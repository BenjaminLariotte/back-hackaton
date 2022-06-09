<?php

// Définition de constantes globales
define('DB_HOST', 'data-positionnement.cf');
define('DB_NAME', 'market-ranking');
define('DB_USER', 'kernighan');
define('DB_PASS', '9]u5ox.%M');


class KwdDataBase
{
    private static $database;

    // Méthode pour créer une connection à la BDD
    public static function databaseConnect()
    {
        if(empty(self::$database))
        {
            self::$database = new PDO
            (
                "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4",
                DB_USER, DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        }
        return self::$database;
    }

    // Méthode pour exécuter une requête SQL
    public static function databaseRequest($sql, $parameters=null)
    {
        $result = false;
        try
        {
            $statement = self::databaseConnect()->prepare($sql);
            $statement->execute($parameters);
            $count = $statement->rowCount();
            $result = $statement->fetchAll();
        }
        catch (Exception $exception)
        {
            die($exception->getMessage());
        }
        $statement = null;
        return $result;
    }

    // Méthode pour récupérer le dernier ID crée dans la BDD
    public static function databaseLastId()
    {
        return self::databaseConnect()->lastInsertId();
    }
}
