<?php

namespace Themosis\Facades;

abstract class Facade
{
    /**
     * The Application instance.
     *
     * @var \Themosis\Core\Application
     */
    protected static $app;

    /**
     * Each facade must define their igniter service
     * class key name.
     *
     * @throws \RuntimeException
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        throw new \RuntimeException('Facade does not implement getFacadeAccessor method.');
    }

    /**
     * Retrieve the instance called by the igniter service.
     *
     * @return mixed
     */
    public static function getFacadeRoot()
    {
        /*
         * Grab the igniter service class and get the instance
         * called by the service.
         */
        return static::resolveFacadeInstance(static::getFacadeAccessor());
    }

    /**
     * Return a facade instance if one already exists. If not, keep a copy
     * of all instances and return the current called one.
     *
     * @param string $name
     *
     * @return mixed
     */
    private static function resolveFacadeInstance($name)
    {
        if (is_object($name)) {
            return $name;
        }

        $app = static::$app;

        return $app->{$name};
    }

    /**
     * Store the application instance.
     *
     * @param \Themosis\Foundation\Application $app
     */
    public static function setFacadeApplication($app)
    {
        static::$app = $app;
    }

    /**
     * Magic method. Use to dynamically call the registered
     * instance method.
     *
     * @param string $method The class method used.
     * @param array  $args   The method arguments.
     *
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeRoot();

        /*
         * Call the instance and its method.
         */
        return call_user_func_array([$instance, $method], $args);
    }
}
