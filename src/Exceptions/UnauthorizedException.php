<?php

namespace Foushua\Authorization\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UnauthorizedException extends HttpException
{
    /**
     * @return static
     */
    public static function forRoles(): self
    {
        return new static(403, __('Your role doesn\'t allow you to see that!'), null, []);
    }

    /**
     * @return static
     */
    public static function forLevel(): self
    {
        return new static(403, __('You role don\'t have the required level to do that!'), null, []);
    }

    /**
     * @return self
     */
    public static function notLoggedIn(): self
    {
        return new static(403, __('User is not logged in.'), null, []);
    }
}
