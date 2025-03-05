<?php

namespace App\Services;

use App\Http\JWT;
use App\Models\User;
use App\Utils\Validator;
use PDOException;
use Exception;

class UserService
{
    public static function create(array $data)
    {

        try {
            $fields = Validator::validade([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password']
            ]);

            $fields['password'] = password_hash($fields['password'], PASSWORD_DEFAULT);

            $user = User::save($fields);

            if (!$user) return ['error' => "Desculpa mas não podemos criar seu usuário"];

            return "Usuário criado com sucesso";
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public static function auth(array $data)
    {
        try {
            $fields = Validator::validade([
                'email' => $data['email'],
                'password' => $data['password']
            ]);

            $user = User::authentication($fields);

            if (!$user) return ['error' => "Email ou senha inválidos"];

            return JWT::generate($user);

            return $user;
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public static function fetch(mixed $authorization)
    {
        try {
            if (isset($authorization["error"])) {
                return ["error" => $authorization["error"]];
            }
            $userFromJWT = JWT::verify($authorization);
            if (!$userFromJWT) return ["error" => "Please login to access this resource"];

            $user = User::find($userFromJWT["id"]);
            if (!$user) return ["error" => "User dot not exist in the db"];
            return $user;
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public static function update(mixed $authorization, array $data)
    {
        try {
            if (isset($authorization["error"])) return ["error" => $authorization["error"]];

            $userFromJWT = JWT::verify($authorization);
            if (!$userFromJWT) return ["error" => "Please login to access this resource"];

            $fields = Validator::validade([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);

            $userService = User::update($userFromJWT["id"], $fields);

            if (!$userService) return ['error' => "Desculpa mas não podemos atualizar seu usuário"];

            return "Usuário atualizado com sucesso";
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public static function delete(mixed $authorization, int | string $id)
    {
        try {
            if (isset($authorization["error"])) return ["error" => $authorization["error"]];

            $userFromJWT = JWT::verify($authorization);
            if (!$userFromJWT) return ["error" => "Please login to access this resource"];

            $user = User::find($userFromJWT["id"]);
            if (!$user) return ["error" => "User dot not exist in the db"];

            $userService = User::delete($id);

            if (!$userService) return ['error' => "Desculpa mas não podemos deletar seu usuário"];

            return "Usuário deletado com sucesso";
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
