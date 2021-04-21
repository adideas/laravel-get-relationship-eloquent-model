<?php

namespace Adideas\RelationFinder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use ReflectionClass;
use ReflectionMethod;
use Illuminate\Support\Collection;

class ParserModel extends Collection
{
    public function __construct($class)
    {
        if (is_array($class)) {
            parent::__construct($class);
        } else {
            $namespace = null;
            if ($class instanceof Model) {
                $namespace = get_class($class);
            } else {
                if (class_exists($class)) {
                    $namespace = $class;
                }
            }

            if ($namespace) {
                $reflectionClass = new ReflectionClass($namespace);
                $constants       = $reflectionClass->getConstants();
                try {
                    $prop = $reflectionClass->getProperty('withVendorRelation');
                } catch (\Exception $ignore) {
                    $prop = null;
                }

                $with_vendor_relation = false;

                if (isset($constants['WITH_VENDOR_RELATION']) && $constants['WITH_VENDOR_RELATION']) {
                    $with_vendor_relation = true;
                }

                $instance = new $namespace();

                if ($prop && isset($instance->{'withVendorRelation'}) && $instance->{'withVendorRelation'}) {
                    $with_vendor_relation = true;
                }

                foreach ($reflectionClass->getMethods(
                    ReflectionMethod::IS_PUBLIC
                ) as $_ => $reflectionMethod) {
                    try {
                        if ($reflectionMethod->class === $reflectionClass->getName()) {
                            if (!count($reflectionMethod->getParameters())) {
                                if (!$reflectionMethod->isStatic()) {
                                    $methodReturn = $instance->{$reflectionMethod->getName()}();
                                    if ($methodReturn instanceof Relation) {
                                        $model = get_class($methodReturn->getRelated());
                                        if ($with_vendor_relation) {
                                            $this->push(
                                                [
                                                    'name'       => $reflectionMethod->getShortName(),
                                                    'relation'   => get_class($methodReturn),
                                                    'model'      => $model,
                                                    'from_model' => $namespace,
                                                    'is_vendor'  => !strpos('-' . $model, 'App\\'),
                                                ]
                                            );
                                        } else {
                                            if (!!strpos('-' . $model, 'App\\')) {
                                                $this->push(
                                                    [
                                                        'name'       => $reflectionMethod->getShortName(),
                                                        'relation'   => get_class($methodReturn),
                                                        'model'      => $model,
                                                        'from_model' => $namespace,
                                                    ]
                                                );
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    } catch (\Exception $ignore) {
                    }
                }
            }
        }
    }
}


/*

$std = new \stdClass();
$std->name = $reflectionMethod->getShortName();
$std->relation = get_class($methodReturn);
$std->model = $model;
$std->path = str_replace(str_replace('app', '', app_path()),'',$reflectionMethod->getFileName());
$std->is_vendor = !strpos('-'.$model, 'App\\');

$this->push($std);

 */
