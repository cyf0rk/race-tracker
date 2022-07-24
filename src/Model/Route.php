<?php

namespace RaceTracker\Model;

class Route
{
    public static array $validRoutes;

    public static function set(string $route, $function)
    {
        self::$validRoutes[] = $route;
        if ($_GET['url'] == $route) {
            $function->__invoke();
        }
    }
}