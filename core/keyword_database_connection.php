<?php

// Définition de constantes globales
define('DB_HOST_MK', 'data-positionnement.cf:9622');
define('DB_NAME_MK', 'market_ranking');
define('DB_USER_MK', 'kernighan');
define('DB_PASS_MK', 'q]?u5ox.%M');


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
                "mysql:host=".DB_HOST_MK.";dbname=".DB_NAME_MK.";charset=utf8mb4",
                DB_USER_MK, DB_PASS_MK,
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
