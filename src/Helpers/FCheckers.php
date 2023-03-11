<?php
/*
 * Copyright © 2023. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

if( !function_exists('isArrayableItems') ) {
    /**
     * Check if the given $item if its type is one of `Collection`, `Arrayable`, `Allable`, `Jsonable`, `JsonSerializable`, `Traversable` or `array`.
     *
     * @param mixed $items
     *
     * @return bool
     */
    function isArrayableItems($items): bool
    {
        return
            is_array($items) ||
            ($items instanceof \Illuminate\Support\Enumerable || isAllable($items)) ||
            ($items instanceof Arrayable || $items instanceof \Illuminate\Contracts\Support\Arrayable || isArrayable($items)) ||
            ($items instanceof Jsonable || $items instanceof \Illuminate\Contracts\Support\Jsonable || isJsonable($items)) ||
            ($items instanceof JsonSerializable || isJsonSerializable($items)) ||
            ($items instanceof Traversable);
    }
}

if( !function_exists('array_keys_exists') ) {
    /**
     * Easily check if multiple array keys exist.
     *
     * @param array $keys
     * @param array $arr
     *
     * @return boolean
     */
    function array_keys_exists(array $keys, array $arr): bool
    {
        return !array_diff_key(array_flip($keys), $arr);
    }
}

if( !function_exists('isJsonable') ) {
    /**
     * Check if the given var is Jsonable (has ->toJson()).
     *
     * @param mixed $object
     *
     * @return bool
     */
    function isJsonable(mixed $object): bool
    {
        try {
            return
                (interface_exists(\Illuminate\Contracts\Support\Jsonable::class) && $object instanceof \Illuminate\Contracts\Support\Jsonable) ||
                (interface_exists(Jsonable::class) && $object instanceof Jsonable) ||
                method_exists($object, 'toJson');
        } catch(Exception $e) {
            return false;
        }
    }
}

if( !function_exists('isJsonSerializable') ) {
    /**
     * Check if the given var is JsonSerializable (has ->jsonSerialize()).
     *
     * @param mixed $object
     *
     * @return bool
     */
    function isJsonSerializable(mixed $object): bool
    {
        try {
            return
                (interface_exists(\JsonSerializable::class) && $object instanceof \JsonSerializable) ||
                method_exists($object, 'jsonSerialize');
        } catch(Exception $e) {
        }
    }
}

if( !function_exists('isArrayable') ) {
    /**
     * Check if the given var is Arrayable (has ->toArray()).
     *
     * @param mixed $array
     *
     * @return bool
     */
    function isArrayable(mixed $array): bool
    {
        return
            (interface_exists(\Illuminate\Contracts\Support\Arrayable::class) && $array instanceof \Illuminate\Contracts\Support\Arrayable) ||
            (interface_exists(Arrayable::class) && $array instanceof Arrayable) ||
            (is_object($array) && method_exists($array, 'toArray'));
    }
}

if( !function_exists('isClosure') ) {
    /**
     * Check if the given var is Closure.
     *
     * @param mixed|null $closure
     *
     * @return bool
     */
    function isClosure($closure): bool
    {
        return $closure instanceof Closure;
    }
}

if( !function_exists('isClass') ) {
    /**
     * Check if the given var is Class.
     *
     * @param mixed|null $object
     * @param bool       $check_if_class_exist
     *
     * @return bool
     */
    function isClass($object, bool $check_if_class_exist = false): bool
    {
        try {
            $class_name = is_object($object) ? get_class($object) : $object;

            return $check_if_class_exist ? class_exists($class_name) : !empty($class_name);
        } catch(Exception $exception) {
            return false;
        }
    }
}

if( !function_exists('isCallable') ) {
    /**
     * Check if the given var is callable && not string.
     *
     * @param mixed|null $callable
     * @param bool       $accept_callable_name
     *
     * @return bool
     */
    function isCallable($callable, bool $accept_callable_name = false): bool
    {
        return is_callable($callable) && ($accept_callable_name || !is_string($callable));
    }
}

if( !function_exists('isArrayableOrArray') ) {
    /**
     * Check if the given var is Array | is Arrayable (has ->toArray()).
     *
     * @param mixed|null $array
     *
     * @return bool
     */
    function isArrayableOrArray($array): bool
    {
        return is_array($array) || isArrayable($array);
    }
}

if( !function_exists('isAllable') ) {
    /**
     * Check if the given var is Allable (has ->all()).
     *
     * @param array|\Illuminate\Contracts\Support\Arrayable|\Illuminate\Support\Collection|mixed $array
     *
     * @return bool
     */
    function isAllable(mixed $array): bool
    {
        try {
            return method_exists($array, 'all');
        } catch(Exception $exception) {
            return false;
        }
    }
}

if( !function_exists('isInvocable') ) {
    /**
     * @param mixed $object
     *
     * @return bool
     */
    function isInvocable($object): bool
    {
        return
            method_exists($object, '__invoke') ||
            is_callable($object) ||
            (interface_exists(IInvocable::class) && $object instanceof IInvocable);
    }
}

if( !function_exists('isPaginator') ) {
    /**
     * Check if the given var is paginator instance.
     *
     * @param mixed $value
     *
     * @return bool
     */
    function isPaginator($value): bool
    {
        return (
            $value instanceof \Illuminate\Pagination\LengthAwarePaginator ||
            $value instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator ||
            $value instanceof \Illuminate\Pagination\Paginator ||
            $value instanceof \Illuminate\Contracts\Pagination\Paginator ||
            $value instanceof \Illuminate\Pagination\AbstractPaginator ||

            (class_exists($class = "League\Fractal\Pagination\PaginatorInterface") && $value instanceof $class) ||
            (class_exists($class = "League\Fractal\Pagination\PaginatorInterface") && $value instanceof $class) ||
            (class_exists($class = "League\Fractal\Pagination\IlluminatePaginatorAdapter") && $value instanceof $class) ||
            (class_exists($class = "League\Fractal\Pagination\PagerfantaPaginatorAdapter") && $value instanceof $class) ||
            (class_exists($class = "League\Fractal\Pagination\DoctrinePaginatorAdapter") && $value instanceof $class)
        );
    }
}

if( !function_exists('isPaginated') ) {
    /**
     * Check if the given var is paginate result.
     *
     * @param mixed $value
     *
     * @return bool
     */
    function isPaginated($value): ?bool
    {
        if( isPaginator($value) || method_exists($value, 'getCollection') ) {
            return true;
        }

        if( is_array($value) ) {
            if(
                Arr::has($value, [ 'current_page', 'per_page' ]) ||
                Arr::has($value, 'meta')
            ) {
                return true;
            }
        }

        return false;
    }
}

if( !function_exists('isConsole') ) {
    /**
     * ### Check if the application running in `Console (CLI)`.
     * *Return custom response by checking __App::runningInConsole()__ method.*
     *
     * ---
     * --|| **Basically the return is one of two variables.**
     *
     * -----| **$runningInConsole** By default its `true`, Returns this **ONLY** If App. is in **Console**.
     *
     * -----| **$notRunningInConsole** By default its `false`, Returns this **ONLY** If App. is **NOT** in **Console**.
     *
     * @param mixed $runningInConsole    | return value of ( $runningInConsole ) when App is running in console.
     * @param mixed $notRunningInConsole | return value of ( $notRunningInConsole ) when App is NOT running in console.
     *
     * @return mixed
     */
    function isConsole(mixed $runningInConsole = true, mixed $notRunningInConsole = false): mixed
    {
        return App::runningInConsole() ? $runningInConsole : $notRunningInConsole;
    }
}

if( !function_exists('isBuilder') ) {
    /**
     * ### Check if the given var is Query Builder | Eloquent Builder | Relation.
     *
     * @param \Illuminate\Database\Query\Builder|Builder|Relation|mixed $var
     *
     * @return bool $var === QueryBuilder
     */
    function isBuilder($var): bool
    {
        return $var instanceof \Illuminate\Database\Query\Builder ||
            $var instanceof Builder ||
            $var instanceof Relation;
    }
}

if( !function_exists('endsWithAny') ) {
    /**
     * Determine if a given string ends with a given substrings then return substring or False when fail.
     *
     * @param string       $haystack
     * @param array|string $needles
     *
     * @return string
     */
    function endsWithAny($haystack, array|string $needles): bool|string
    {
        foreach( (array) $needles as $needle ) {
            if( Str::endsWith($haystack, $needle) ) {
                return $needle;
            }
        }

        return false;
    }
}

if( !function_exists('isModel') ) {
    /**
     * Determine if a given object is inherit Model class.
     *
     * @param object $object
     *
     * @return bool
     */
    function isModel($object): bool
    {
        try {
            $results = ($object instanceof Model) ||
                is_a($object, Model::class) ||
                is_subclass_of($object, Model::class);

            $results = $results || (
                    ($object instanceof \Model) ||
                    is_a($object, \Model::class) ||
                    is_subclass_of($object, \Model::class)
                );
        } catch(Exception $exception) {
            $results = false;
        }

        return $results ?? false;
    }
}

if( !function_exists('isRelation') ) {
    /**
     * Determine if a given object is inherited \Illuminate\Database\Eloquent\Relations\Relation class.
     *
     * @param object $object
     *
     * @return bool
     */
    function isRelation($object): bool
    {
        try {
            if( !is_object($object) && !is_string($object) ) {
                return false;
            }

            return ($object instanceof \Illuminate\Database\Eloquent\Relations\Relation) ||
                is_a($object, \Illuminate\Database\Eloquent\Relations\Relation::class) ||
                is_subclass_of($object, \Illuminate\Database\Eloquent\Relations\Relation::class);
        } catch(Exception $exception) {

        }

        return false;
    }
}

if( !function_exists('isCarbon') ) {
    /**
     * @param object $object
     *
     * @return bool
     */
    function isCarbon($object): bool
    {
        try {
            return ($object instanceof \Carbon\Carbon) ||
                is_a($object, \Carbon\Carbon::class) ||
                is_subclass_of($object, \Carbon\Carbon::class);
        } catch(Exception $exception) {

        }

        return false;
    }
}

if( !function_exists('isDateTime') ) {
    /**
     * @param object $object
     *
     * @return bool
     */
    function isDateTime($object): bool
    {
        try {
            return ($object instanceof DateTime) ||
                is_a($object, DateTime::class) ||
                is_subclass_of($object, DateTime::class);
        } catch(Exception $exception) {

        }

        return false;
    }
}

if( !function_exists('isTraversable') ) {
    /**
     * @param object $object
     *
     * @return bool
     */
    function isTraversable($object): bool
    {
        try {
            return $object instanceof Traversable;
        } catch(Exception $exception) {

        }

        return false;
    }
}

if( !function_exists('hasArabicChars') ) {
    /**
     * @param string $string
     *
     * @return bool
     */
    function hasArabicChars(string $string): bool
    {
        return preg_match("/[\x{0600}-\x{06FF}\x]{1,32}/u", $string);
    }
}

if( !function_exists('is_collection') ) {
    /**
     * @param mixed $var
     *
     * @return bool
     */
    function is_collection($var): bool
    {
        return $var instanceof \Illuminate\Support\Collection;
    }
}

if( !function_exists('stringContainsAll') ) {
    /**
     * Determine if a given string contains all array values.
     *
     * @param string   $haystack
     * @param string[] $needles
     *
     * @return bool
     */
    function stringContainsAll(string $haystack, array $needles): bool
    {
        foreach( $needles as $needle ) {
            if( !stringContains($haystack, $needle) ) {
                return false;
            }
        }

        return true;
    }
}

if( !function_exists('stringContains') ) {
    /**
     * Determine if a given string contains a given substring.
     *
     * @param string          $haystack
     * @param string|string[] $needles
     * @param bool            $ignore_case
     *
     * @return bool
     */
    function stringContains(string $haystack, array|string $needles, bool $ignore_case = false): bool
    {
        foreach( (array) $needles as $needle ) {
            if( $ignore_case ) {
                $needle = snake_case($needle);
                $haystack = snake_case($haystack);
            }

            if( is_string($haystack) && is_string($needle) && $needle !== '' && mb_strpos($haystack, $needle) !== false ) {
                return true;
            }
        }

        return false;
    }
}

if( !function_exists('stringEnds') ) {
    /**
     * Determine if a given string ends with a given substring.
     *
     * @param string          $haystack
     * @param string|string[] $needles
     *
     * @return bool
     */
    function stringEnds(string $haystack, array|string $needles): bool
    {
        foreach( (array) $needles as $needle ) {
            if( $needle !== '' && substr($haystack, -strlen($needle)) === (string) $needle ) {
                return true;
            }
        }

        return false;
    }

}

if( !function_exists('stringStarts') ) {
    /**
     * Determine if a given string starts with a given substring.
     *
     * @param string          $haystack
     * @param string|string[] $needles
     *
     * @return bool
     */
    function stringStarts(string $haystack, array|string $needles): bool
    {
        foreach( (array) $needles as $needle ) {
            if( (string) $needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0 ) {
                return true;
            }
        }

        return false;
    }
}

if( !function_exists('isUrl') ) {
    /**
     * @param string|null $url
     *
     * @return bool
     */
    function isUrl(?string $url = null): bool
    {
        if( !$url ) {
            return false;
        }

        // Remove all illegal characters from a url
        $url = filter_var($url, FILTER_SANITIZE_URL);

        // Validate URI
        if( filter_var($url, FILTER_VALIDATE_URL) === FALSE
            // check only for http/https schemes.
            || !in_array(strtolower(parse_url($url, PHP_URL_SCHEME)), [ 'http', 'https' ], true)
        ) {
            return false;
        }

        return true;
    }
}

if ( !function_exists('hasScope') ) {
    /**
     * Check if given class has the given scope name.
     *
     * @param mixed  $class     <p>
     *                          Either a string containing the name of the class to
     *                          check, or an object.
     *                          </p>
     * @param string $scopeName <p>
     *                          Scope name to check
     *                          </p>
     *
     * @return bool
     */
    function hasScope($class, $scopeName)
    {
        try {
            $hasScopeRC = new ReflectionClass($class);
            $scopeName = strtolower(studly_case($scopeName));
            starts_with($scopeName, "scope") && ($scopeName = substr($scopeName, strlen("scope")));

            $hasScope = collect($hasScopeRC->getMethods())->map(function ($c) use ($scopeName) {
                    /**
                     * @var $c ReflectionMethod
                     */
                    $name = strtolower(studly_case($c->getName()));
                    $name = starts_with($name, "scope") ? substr($name, strlen("scope")) : false;

                    return $name == $scopeName;
                })->filter()->count() > 0;
        } catch (ReflectionException $exception) {
            $hasScope = false;
        } catch (Exception $exception) {
            $hasScope = false;
        }

        return !!$hasScope;
    }
}

if ( !function_exists('hasConst') ) {
    /**
     * Check if given class has the given const.
     *
     * @param mixed  $class     <p>
     *                          Either a string containing the name of the class to
     *                          check, or an object.
     *                          </p>
     * @param string $const     <p>
     *                          Const name to check
     *                          </p>
     *
     * @return bool
     */
    function hasConst($class, $const): bool
    {
        $hasConst = false;
        try {
            if ( is_object($class) || is_string($class) ) {
                $reflect = new ReflectionClass($class);
                $hasConst = array_key_exists($const, $reflect->getConstants());
            }
        } catch (ReflectionException $exception) {
            $hasConst = false;
        } catch (Exception $exception) {
            $hasConst = false;
        }

        return (bool)$hasConst;
    }
}

if ( !function_exists('hasTrait') ) {
    /**
     * Check if given class has trait.
     *
     * @param mixed  $class     <p>
     *                          Either a string containing the name of the class to
     *                          check, or an object.
     *                          </p>
     * @param string $traitName <p>
     *                          Trait name to check
     *                          </p>
     *
     * @return bool
     */
    function hasTrait($class, $traitName)
    {
        try {
            $traitName = str_contains($traitName, "\\") ? class_basename($traitName) : $traitName;

            $hasTraitRC = new ReflectionClass($class);
            $hasTrait = collect($hasTraitRC->getTraitNames())->map(function ($name) use ($traitName) {
                    $name = str_contains($name, "\\") ? class_basename($name) : $name;

                    return $name == $traitName;
                })->filter()->count() > 0;
        } catch (ReflectionException $exception) {
            $hasTrait = false;
        } catch (Exception $exception) {
            d($exception->getMessage());
            $hasTrait = false;
        }

        return $hasTrait;
    }
}

if (!function_exists('isLocaleAllowed')) {
    /**
     * @param string|\Closure $locale
     *
     * @return bool
     */
    function isLocaleAllowed($locale): bool
    {
        return array_key_exists($locale, array_flip(getLocales(true)));
    }
}