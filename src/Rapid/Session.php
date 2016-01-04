<?php

/**
 * @author Dmitry Merkushin <merkushin@gmail.com>
 */
namespace Rapid;

class Session
{
    public static function init($sessionName = null)
    {
        self::name($sessionName);
        self::start();
        self::regenerateId();
    }

    /**
     * @param string $name
     */
    public static function name($name = null)
    {
        session_name($name);
    }

    public static function start()
    {
        session_start();
    }

    public static function regenerateId()
    {
        session_regenerate_id();
    }

    /**
     * @return string
     */
    public static function sessionId()
    {
        return session_id();
    }
}
