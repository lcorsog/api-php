<?php

namespace App\Controller;

use App\Http\JWT;
use App\Http\Request;
use App\Http\Response;
use App\Services\UserService;
use App\Utils\Validator;

class UserController
{
    public function store(Request $request, Response $response)
    {
        try {
            $body = $request::body();

            if (empty($body)) {
                return $response::json([
                    'error' => true,
                    'success' => false,
                    'message' => 'No data provided'
                ], 400);
            }

            $userService = UserService::create($body);

            if (isset($userService['error'])) {
                return $response::json([
                    'error' => true,
                    'success' => false,
                    'message' => $userService['error']
                ], 401);
            }

            return $response::json([
                'error' => false,
                'success' => true,
                'message' => $userService
            ], 201);
        } catch (\Exception $e) {
            return $response::json([
                'error' => true,
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
    public function login(Request $request, Response $response)
    {
        $body = $request::body();

        $userService = UserService::auth($body);

        if (isset($userService['error'])) {
            return $response::json([
                'error' => true,
                'success' => false,
                'message' => $userService['error']
            ], 400);
        }

        $response::json([
            'error' => false,
            'success' => true,
            'jwt' => $userService
        ], 200);
    }
    public function fetch(Request $request, Response $response)
    {
        $authorization = $request::authorization();
        $userService = UserService::fetch($authorization);


        if (isset($userService['error'])) {
            return $response::json([
                'error' => true,
                'success' => false,
                'message' => $userService['error']
            ], 400);
        }

        $response::json([
            'error' => false,
            'success' => true,
            'jwt' => $userService
        ], 200);
    }
    public function update(Request $request, Response $response)
    {
        $autorization = $request::authorization();
        $body = $request::body();

        $userService = UserService::update($autorization, $body);

        if (isset($userService['error'])) {
            return $response::json([
                'error' => true,
                'success' => false,
                'message' => $userService['error']
            ], 400);
        }

        $response::json([
            'error' => false,
            'success' => true,
            'message' => $userService
        ], 200);
    }
    public function remove(Request $request, Response $response, array $id)
    {
        $authorization = $request::authorization();
        $userService = UserService::delete($authorization, $id[0]);


        if (isset($userService['error'])) {
            return $response::json([
                'error' => true,
                'success' => false,
                'message' => $userService['error']
            ], 400);
        }

        $response::json([
            'error' => false,
            'success' => true,
            'message' => $userService
        ], 200);
    }
}
