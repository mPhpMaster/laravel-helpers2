<?php
/*
 * Copyright © 2023. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

if( !function_exists('toCollect') ) {
    /**
     * Returns $var as collection if it wasn't collection
     *
     * @param mixed $var
     * @param bool  $allow_arrayable when isArrayable($var) wrap it with array
     *
     * @return \Illuminate\Support\Collection
     */
    function toCollect($var, bool $allow_arrayable = false): \Illuminate\Support\Collection
    {
        $var = !$allow_arrayable && isArrayable($var) ? [ $var ] : $var;

        return is_collection($var) ? $var : collect($var);
    }
}

if( !function_exists('toCollectWithModel') ) {
    /**
     * Returns $var as collection, if the given var is model ? return collect([model])
     *
     * @param mixed $var
     * @param bool  $allow_arrayable when isArrayable($var) wrap it with array
     *
     * @return \Illuminate\Support\Collection
     */
    function toCollectWithModel($var, bool $allow_arrayable = true): \Illuminate\Support\Collection
    {
        $var = $var instanceof \Illuminate\Database\Eloquent\Model ? [ $var ] : $var;

        return toCollect($var, $allow_arrayable);
    }
}

if( !function_exists('toCollectOrModel') ) {
    /**
     * Returns $var as collection, if the given var is model ? return model
     *
     * @param $var
     *
     * @return \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Model
     */
    function toCollectOrModel($var)
    {
        return is_collection($var) || $var instanceof \Illuminate\Database\Eloquent\Model ? $var : collect($var);
    }
}

if( !function_exists('toObjectOrModel') ) {
    /**
     * Returns $var as Object, if the given var is model ? return model
     *
     * @param $var
     *
     * @return object|\Illuminate\Database\Eloquent\Model
     */
    function toObjectOrModel($var)
    {
        return isModel($var) ? $var : valueToObject($var);
    }
}

if( !function_exists('str_before_last_count') ) {
    /**
     * Get the portion of a string before the last occurrence of a given value for X times.
     *
     * @param string $subject
     * @param string $search
     * @param int    $times
     *
     * @return string
     */
    function str_before_last_count($subject, $search, int $times = 1): string
    {
        $times = $times > 0 ? $times : 0;
        $result = $subject;
        while( $times && $times-- ) {
            $result = \Illuminate\Support\Str::beforeLast($result, $search);
        }

        return $result;
    }
}

if( !function_exists('getTable') ) {
    /**
     * Returns Model table name.
     *
     * @param string $model Model class.
     *
     * @return null|string
     */
    function getTable(string $model): ?string
    {
        if( $model && class_exists($model) ) {
            $class = new $model;

            /** @var $class \Illuminate\Database\Eloquent\Model */
            return $class->getTable();
        }

        return null;
    }
}

if( !function_exists('getFillable') ) {
    /**
     * Returns Model Fillable.
     *
     * @param string $model Model class.
     *
     * @return null|array
     */
    function getFillable(string $model): ?array
    {
        if( $model && class_exists($model) ) {
            $class = new $model;

            /** @var $class \Illuminate\Database\Eloquent\Model */
            return $class->getFillable();
        }

        return null;
    }
}

if( !function_exists('getHidden') ) {
    /**
     * Returns Model hidden.
     *
     * @param string $model Model class.
     *
     * @return null|array
     */
    function getHidden(string $model): ?array
    {
        if( $model && class_exists($model) ) {
            $class = new $model;

            /** @var $class \Illuminate\Database\Eloquent\Model */
            return $class->getHidden();
        }

        return null;
    }
}

if( !function_exists('getModel') ) {
    /**
     * Returns model/class of query|model|string.
     *
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation|\Illuminate\Database\Eloquent\Model|string $model
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation|\Illuminate\Database\Eloquent\Model|string|null
     */
    function getModel($model)
    {
        try {
            if( is_object($model) && method_exists($model, 'getModel') ) {
                /** @var \Illuminate\Database\Eloquent\Builder */
                return $model->getModel();
            }
            throw new Exception($model);
        } catch(Exception $exception) {
            try {
                if( is_object($model) && method_exists($model, 'getQuery') ) {
                    /** @var \Illuminate\Database\Eloquent\Model */
                    return $model->getQuery()->getModel();
                }
                throw new Exception($model);
            } catch(Exception $exception2) {
                try {
                    return getModelClass($model);
                } catch(Exception $exception3) {

                }
            }
        }

        return null;
    }
}

if( !function_exists('getModelClass') ) {
    /**
     * Returns model class of query|model|string.
     *
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation|\Illuminate\Database\Eloquent\Model|string $model
     *
     * @return string|null
     */
    function getModelClass($model): string|null
    {
        try {
            $_model = !is_string($model) ? getClass($model) : $model;
            if( !class_exists($_model) ) {
                if( !class_exists($__model = "\\App\\Models\\{$_model}") ) {
                    try {
                        $__model = getClass(app($_model));
                    } catch(\Exception $exception2) {
                        try {
                            $__model = function_exists('getRealClassName') ? getRealClassName($_model) : $_model;
                        } catch(\Exception $exception3) {
                            $__model = null;
                        }
                    }
                }

                $_model = trim($__model && is_string($__model) ? $__model : getClass($__model));
            }
        } catch(Exception $exception1) {

        }

        if( $_model ) {
            $_model = isModel($_model) ? $_model : null;
        }

        $_model = is_bool($_model) ? null : $_model;

        return $_model ?? null;
    }
}

if( !function_exists('getClass') ) {
    /**
     * Returns the name of the class of an object
     *
     * @param object|Model|string|mixed $object |string [optional] <p> The tested object. This parameter may be omitted when inside a class. </p>
     *
     * @return string|false <p> The name of the class of which <i>`object`</i> is an instance.</p>
     * <p>
     *      Returns <i>`false`</i> if <i>`object`</i> is not an <i>`object`</i>.
     *      If <i>`object`</i> is omitted when inside a class, the name of that class is returned.
     * </p>
     */
    function getClass($object): string|false
    {
        if( is_object($object) ) {
            return get_class(valueToObject($object));
        }

        return $object && is_string($object) && class_exists($object) ? $object : false;
    }
}

if( !function_exists('getSql') ) {
    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return string
     */
    function getSql(Builder|Relation|\Illuminate\Contracts\Database\Query\Builder $builder, bool $parse = false): string
    {
        $sql = sprintf(str_ireplace('?', "'%s'", $builder->toSql()), ...$builder->getBindings());

        return !$parse ? $sql : replaceAll([
                                               " or " => "\n\t\tor ",
                                               " and " => "\n\t\tand ",
                                               " where " => "\n\twhere ",
                                           ], $sql);
    }
}

if( !function_exists('str_prefix') ) {
    /**
     * Add a prefix to string but only if string2 is not empty.
     *
     * @alias prefixText
     *
     * @param string      $string  string to prefix
     * @param string      $prefix  prefix
     * @param string|null $string2 string2 to prefix the return
     *
     * @return string|null
     */
    function str_prefix(string $string, string $prefix, string|null $string2 = null): ?string
    {
        $newString = rtrim(is_null($string2) ? '' : $string2, $prefix) .
            $prefix .
            ltrim($string, $prefix);

        return ltrim($newString, $prefix);
    }
}

if( !function_exists('str_suffix') ) {
    /**
     * Add a suffix to string but only if string2 is not empty.
     *
     * @param string      $string  string to suffix
     * @param string      $suffix  suffix
     * @param string|null $string2 string2 to suffix the return
     *
     * @return string|null
     */
    function str_suffix(string $string, string $suffix, string|null $string2 = null): ?string
    {
        $newString = ltrim($string, $suffix) . $suffix . rtrim(is_null($string2) ? '' : $string2, $suffix);

        return trim($newString, $suffix);
    }
}

if( !function_exists('str_words_limit') ) {
    /**
     * Limit string words.
     *
     * @param string      $string string to limit
     * @param int         $limit  word limit
     * @param string|null $suffix suffix the string
     *
     * @return string
     */
    function str_words_limit(string $string, int $limit, ?string $suffix = '...'): string
    {
        $start = 0;
        $stripped_string = strip_tags($string); // if there are HTML or PHP tags
        $string_array = explode(' ', $stripped_string);
        $truncated_array = array_splice($string_array, $start, $limit);

        $lastWord = end($truncated_array);
        $return = substr($string, 0, stripos($string, $lastWord) + strlen($lastWord)) . ' ' . $suffix;

        $m = [];
        if( preg_match_all('#<(\w+).+?#is', $return, $m) ) {
            $m = is_array($m) && is_array($m[ 1 ]) ? array_reverse($m[ 1 ]) : [];
            foreach( $m as $HTMLTAG ) {
                $return .= "</{$HTMLTAG}>";
            }
        }

        return $return;
    }
}

if( !function_exists('prefixNumber') ) {
    /**
     * like:
     * Number: 0001
     *
     * @param float  $value
     * @param string $prefix
     * @param int    $length
     *
     * @return string
     */
    function prefixNumber(float $value, string $prefix = '0', int $length = 4): string
    {
        $prefix = trim($prefix ?: '0');

        return sprintf("%{$prefix}{$length}d", $value);
    }
}

if( !function_exists('prefixText') ) {
    /**
     * like:
     * Text:
     * ***id:
     *
     * @alias str_prefix
     *
     * @param string $value
     * @param string $prefix
     * @param int    $length
     * @param int    $pad_type [optional] <p>
     *                         Optional argument pad_type can be
     *                         STR_PAD_RIGHT, STR_PAD_LEFT,
     *                         or STR_PAD_BOTH. If
     *                         pad_type is not specified it is assumed to be
     *                         STR_PAD_BOTH.
     *                         </p>
     *
     * @return string
     */
    function prefixText(string $value, string $prefix = ' ', int $length = 10, int $pad_type = STR_PAD_BOTH): string
    {
        return str_pad($value, $length, $prefix ?: ' ', $pad_type);
    }
}

if( !function_exists('countToken') ) {
    /**
     * Return count of the given token.
     *
     * @param string $token
     * @param string $subject
     *
     * @return int
     */
    function countToken(string $token, string $subject): int
    {
        if( empty(trim($token)) || empty(trim($subject)) ) {
            return 0;
        }

        return count(explode($token, $subject)) - 1;
    }
}

if( !function_exists('replaceTokens') ) {
    /**
     * Replace the tokens in string
     *
     * @param string $_subject
     * @param array  $values [ token => value ]
     * @param string $token_prefix
     * @param string $token_suffix
     *
     * @return string
     */
    function replaceTokens(string $_subject, array $values = [], string $token_prefix = "{", string $token_suffix = "}"): string
    {
        $subject = $_subject;
        foreach( $values as $token => $value ) {
            $_token = "{$token_prefix}{$token}{$token_suffix}";
            $subject = replaceAll([
                                      $_token => $value,
                                  ], $subject);
        }

        return $subject;
    }
}

if( !function_exists('getTrans') ) {
    /**
     * Translate the given message or return default.
     *
     * @param string|\Closure|null $key
     * @param string|\Closure|null $default
     * @param array                $replace
     * @param string|null          $locale
     *
     * @return string|array|null
     */
    function getTrans(
        string|\Closure|null $key = null,
        string|Closure|null $default = null,
        array $replace = [],
        string|null $locale = null
    ): array|string|null {
        $key = value($key);
        $return = __($key, $replace, $locale);

        return $return === $key ? value($default) : $return;
    }
}

if( !function_exists('getNumbers') ) {
    /**
     * Returns Numbers only from the given string
     *
     * @param string|int|float $string
     *
     * @return string
     */
    function getNumbers($string): string
    {
        return preg_filter("/[^0-9]*/", "", $string);
    }
}

if( !function_exists('getArrayableItems') ) {
    /**
     * Results array of items from Collection, Arrayable, Allable, Jsonable, JsonSerializable, Traversable or array.
     *
     * @param mixed $items
     *
     * @return array
     */
    function getArrayableItems($items): array
    {
        if( isArrayableItems($items) ) {
            if( is_array($items) ) {
                return $items;
            } elseif( $items instanceof Arrayable || $items instanceof \Illuminate\Contracts\Support\Arrayable || isArrayable($items) ) {
                return $items->toArray();
            } elseif( $items instanceof \Illuminate\Support\Enumerable || isAllable($items) ) {
                return $items->all();
            } elseif( $items instanceof Jsonable || $items instanceof \Illuminate\Contracts\Support\Jsonable || isJsonable($items) ) {
                return json_decode($items->toJson(), true);
            } elseif( $items instanceof JsonSerializable || isJsonSerializable($items) ) {
                return (array) $items->jsonSerialize();
            } elseif( $items instanceof Traversable ) {
                return iterator_to_array($items);
            }
        }

        return (array) $items;
    }
}

if( !function_exists('valueToDate') ) {
    /**
     * Returns value as date format
     *
     * @param string|mixed $value
     *
     * @return string|null
     */
    function valueToDate($value): ?string
    {
        return $value ? carbon()->parse($value)->toDateString() : null;
    }
}

if( !function_exists('valueToDateTime') ) {
    /**
     * Returns value as date and time format
     *
     * @param string|mixed $value
     *
     * @return string|null
     */
    function valueToDateTime($value): ?string
    {
        return $value ? carbon()->parse($value)->toDateTimeString() : null;
    }
}

if( !function_exists('valueToArray') ) {
    /**
     * Returns value as Array
     *
     * @param string|mixed $value
     * @param bool         $forceToArray
     *
     * @return null|array
     */
    function valueToArray($value, bool $forceToArray = false): ?array
    {
        if( $value instanceof Traversable ) {
            return iterator_to_array($value);
        }
        $collect = toCollect($value, true);

        return !$forceToArray && is_array($collectAll = $collect->all()) ? $collectAll : $collect->toArray();
    }
}

if( !function_exists('valueToUnDotArray') ) {
    /**
     * Returns value as Array. (Array undot)
     *
     * @param mixed $value
     *
     * @return null|array
     */
    function valueToUnDotArray($value): ?array
    {
        $array = [];

        collect($value)->mapWithKeys(function($value, $key) use (&$array) {
            return array_set($array, $key, $value);
        });

        return $array;
    }
}

if( !function_exists('valueToDotArray') ) {
    /**
     * Flatten a multi-dimensional associative array with dots.
     *
     * @param iterable $array
     * @param string   $prepend
     *
     * @return array
     */
    function valueToDotArray($array, string $prepend = ''): array
    {
        $results = [];

        foreach( (array) $array as $key => $value ) {
            if( !empty($value) && is_array($value) ) {
                $results[] = valueToDotArray($value, $prepend . $key . '.');
            } else {
                $results[] = [ $prepend . $key => $value ];
            }
        }

        return count($results) === 1 ? head($results) : array_merge(...$results);
    }
}

if( !function_exists('valueToObject') ) {
    /**
     * Cast value as Object
     *
     * @param mixed $value
     *
     * @return object
     */
    function valueToObject($value): object
    {
        return (object) $value;
    }
}

if( !function_exists('valueFromJson') ) {
    /**
     * @alias json_decode
     *
     * @param string|null $_data
     * @param null|mixed  $default
     *
     * @return array|mixed
     */
    function valueFromJson(?string $_data, $default = null): mixed
    {
        try {
            $data = json_decode($_data, true, 512, JSON_THROW_ON_ERROR);
        } catch(\Exception $exception) {
            $data = value($default ?? false);
        }

        return $data;
    }
}

if( !function_exists('valueToJson') ) {
    /**
     * @alias json_encode
     *
     * @param array|string|null $_data
     * @param mixed|null        $default
     * @param int               $options
     *
     * @return string|mixed
     */
    function valueToJson(array|string|null $_data = null, mixed $default = null, int $options = 0): mixed
    {
        $_data = is_string($_data) ? valueFromJson($_data, $_data) : $_data;
        try {
            $data = json_encode($_data, $options);
        } catch(\Exception $exception) {
            $data = value($default ?? false);
        }

        return $data;
    }
}

if( !function_exists('getValue') ) {
    /**
     * Return the default value of the given value.
     *
     * @param mixed $value
     * @param mixed ...$args
     *
     * @return mixed
     * @see \value()
     */
    function getValue($value, ...$args): mixed
    {
        return is_callable($value) && !is_string($value) ? $value(...$args) : value($value, ...$args);
    }
}

if( !function_exists('arrayToObject') ) {
    /**
     * Returns array as Object
     *
     * @param mixed $value
     *
     * @return object
     */
    function arrayToObject($value): object
    {
        if( is_object($value) || is_array($value) ) {
            return (object) json_decode(json_encode($value));
        }

        $object = (object) [];
        foreach( (array) $value as $key => $item ) {
            if( is_array($item) ) {
                $object->$key = arrayToObject($item);
            } else {
                $object->$key = $item;
            }
        }

        return $object;
    }
}

if( !function_exists('arrayToStdClass') ) {
    /**
     * Returns value as Object
     *
     * @param iterable|mixed $value
     *
     * @return \stdClass
     */
    function arrayToStdClass($value): stdClass
    {
        $stdClass = new \stdClass;
        $item = null;
        foreach( $value as $key => &$item ) {
            $stdClass->$key = is_array($item) ? arrayToStdClass($item) : $item;
        }
        unset($item);

        return $stdClass;
    }
}

if( !function_exists('getModelKey') ) {
    /**
     * Returns Model Key Only!
     *
     * @param Model|mixed $object
     *
     * @return mixed|object|int|null
     */
    function getModelKey($object): mixed
    {
        if( isModel($object) ) {
            $key = $object->getKeyName() ?: 'id';
            if( !($return = ($object->getKey() ?: $object->{$key})) ) {
                $return = object_get($object, $key) ?: array_get($object->toArray(), $key);
            }

            return $return;
        }

        return $object;
    }
}

if ( !function_exists('getConst') ) {
    /**
     * Returns const value if exists, otherwise returns $default.
     *
     * @param string|array $const   <p>
     *                              Const name to check
     *                              </p>
     * @param mixed|null   $default <p>
     *                              Value to return when const not found
     *                              </p>
     *
     * @return mixed
     */
    function getConst($const, $default = null)
    {
        return defined($const = is_array($const) ? implode("::", $const) : $const) ? constant($const) : $default;
    }
}
