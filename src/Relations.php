<?php

namespace Adideas\RelationFinder;

class Relations
{
    private $model = null;
    private $parser = null;

    public function __construct()
    {
        if (!app()->runningInConsole()) {
            $route = request()->route();
            $parameter = $route->parameterNames();
            if (count($parameter)) {
                $model = $route->parameter($parameter[0]);
                $this->model = get_class($model);
                $this->parser = new ParserModel($model);
            }
        }
    }

    public static function relations($obj) {
        try {
            if (is_string($obj) && class_exists($obj)) {
                return new ParserModel(new $obj());
            }
            return new ParserModel($obj);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function __callStatic($name, $arguments)
    {
        try {
            return (new static())->{$name}(...$arguments);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function __call($name, $arguments)
    {
        try {
            if (!method_exists($this, $name)) {
                if ($this->parser && method_exists($this->parser, $name)) {
                    return $this->parser->{$name}(...$arguments);
                } else {
                    throw new \Exception("No Model");
                }
            } else {
                return $this->{$name}(...$arguments);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
