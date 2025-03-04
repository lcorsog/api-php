<?php
// filepath: /C:/laragon/www/Projetos-de-estudo/api-php/src/Models/Database.php

namespace App\Models;

use PDO;
use Exception;
use PDOException;

class DataBase
{
    public static function getConnection()
    {
        try {
            $pdo = new PDO(
                "mysql:host=localhost;dbname=api_php",
                "root",
                ""
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }
}
