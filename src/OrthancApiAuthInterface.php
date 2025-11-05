<?php

namespace Plokko\LaravelOrthancRestApi;

use Closure;

class OrthancApiAuthInterface
{
    protected static ?Closure $handleTokenGeneration = null;

    public static function setHandleTokenGeneration(Closure $handleTokenGeneration): void
    {
        self::$handleTokenGeneration = $handleTokenGeneration;
    }

    public static function getToken(?string $serverName): string
    {
        if (self::$handleTokenGeneration == null) {
            throw new \Exception('No token generation handler set');
        }

        $handler = self::$handleTokenGeneration;

        return $handler($serverName);
    }
}
