<?php

namespace App\Models;

use App\Models\DataBase;
use PDO;

class User extends DataBase
{
    public static function save(array $data)
    {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Usuário criado com sucesso";
            return true;
        }
        echo "Desculpa mas não podemos criar seu usuário";
        return false;
    }

    public static function authentication(array $data)
    { {
            $pdo = self::getConnection();

            $stmt = $pdo->prepare("
                SELECT 
                    *
                FROM 
                    users
                WHERE 
                    email = ?
            ");

            $stmt->execute([$data['email']]);

            if ($stmt->rowCount() < 1) return false;

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!password_verify($data['password'], $user['password'])) return false;

            return [
                'id'   => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
            ];
        }
    }

    public static function find(int | string $id)
    {
        $pdo = self::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public static function update(int | string $id, array $data)
    {
        $pdo = self::getConnection();
        $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->rowCount() > 0 ? true : false;
    }

    public static function delete(int | string $id)
    {
        $pdo = self::getConnection();
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->rowCount() > 0 ? true : false;
    }
}
