<?php 

namespace App\Http;

class Route {

   private static array $routes = [
   ];

   public static function get(string $url, string $callback) {
    self::$routes[] = [
      'url' => $url,
      'callback' => $callback,
      'method' => 'GET'
    ];
   }
   public static function post(string $url, string $callback) {
    self::$routes[] = [
      'url' => $url,
      'callback' => $callback,
      'method' => 'POST'
    ];
   }
   public static function put(string $url, string $callback) {
    self::$routes[] = [
      'url' => $url,
      'callback' => $callback,
      'method' => 'PUT'
    ];
   }
   public static function delete(string $url, string $callback) {
    self::$routes[] = [
        'url' => $url,
        'callback' => $callback,
        'method' => 'DELETE'
    ];
   }

   public static function routes() {
     return self::$routes;
   }
  
   
}