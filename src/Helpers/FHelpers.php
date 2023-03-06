<?php
/*
 * Copyright © 2023. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

if( !defined('OPTION_NO_CHANGE') ) {
    define('OPTION_NO_CHANGE', "no-change");
}

if( !function_exists( 'trimDirectorySeparator') ) {
    /**
     * @param string $path
     *
     * @return string
     */
    function trimDirectorySeparator(string $path): string
    {
        return trim($path, DIRECTORY_SEPARATOR);
    }
}

if( !function_exists( 'convert_to_en_numbers') ) {
    /**
     * @param string $string
     *
     * @return array|string
     */
    function convert_to_en_numbers(string $string): array|string
    {
        $persian = [ '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' ];
        // $arabic = [ '٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠' ];
        $arabic = [ '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩' ];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }
}

if( !function_exists('array_only_except') ) {
    /**
     * Get two arrays, one has the second argument, and another one without it
     *
     * @param array        $array
     * @param array|string $keys
     *
     * @return array
     */
    function array_only_except($array, $keys): array
    {
        return [
            array_only($array, $keys),
            array_except($array, $keys),
        ];
    }
}

if( !function_exists('array_except_only') ) {
    /**
     * Get two arrays, one without the second argument, and another one only the second argument
     *
     * @param array        $array
     * @param array|string $keys
     *
     * @return array
     */
    function array_except_only($array, $keys): array
    {
        return [
            array_except($array, $keys),
            array_only($array, $keys),
        ];
    }
}

if( !function_exists('replaceAll') ) {
    /**
     * Replace a given data in string.
     *
     * @param iterable|\Closure $searchAndReplace [ searchFor => replaceWith ]
     * @param string|\Closure   $subject
     *
     * @return string
     */
    function replaceAll(iterable|Closure $searchAndReplace, Closure|string $subject): string
    {
        $subject = (string) value($subject);
        $searchAndReplace = value($searchAndReplace);

        foreach( $searchAndReplace as $search => $replace ) {
            $subject = str_ireplace($search, $replace, $subject);
        }

        return $subject;
    }
}

if( !function_exists('carbon') ) {
    /**
     * @return \Carbon\Carbon|\Illuminate\Foundation\Application|mixed
     */
    function carbon(): mixed
    {
        return app(\Carbon\Carbon::class);
    }
}

if( !function_exists('firstSet') ) {
    /**
     * @param mixed ...$var
     *
     * @return mixed|null
     */
    function firstSet(...$var): mixed
    {
        foreach( $var as $_var ) {
            if( isset($_var) ) {
                return $_var;
            }
        }

        return null;
    }
}

if( !function_exists('getAny') ) {
    /**
     * @param mixed ...$vars
     *
     * @return mixed|null
     */
    function getAny(...$vars): mixed
    {
        foreach( $vars as $_var ) {
            if( $_var ) {
                return $_var;
            }
        }

        return null;
    }
}

if( !function_exists('test') ) {
    /**
     * Apply `value` function to each argument. when value returns something true ? return it.
     *
     * @param mixed ...$vars
     *
     * @return mixed|null
     */
    function test(...$vars): mixed
    {
        foreach( $vars as $_var ) {
            if( $_var = value($_var) ) {
                return $_var;
            }
        }

        return null;
    }
}

if( !function_exists('iif') ) {
    /**
     * Test Condition and return one of two parameters
     *
     * @param mixed|\Closure $var   Condition
     * @param mixed|\Closure $true  Return this if Condition == true
     * @param mixed|\Closure $false Return this when Condition fail
     *
     * @return mixed
     */
    function iif($var, $true = null, $false = null): mixed
    {
        return value(value($var) ? $true : $false);
    }
}

if ( !function_exists('modelToQuery') ) {
    /**
     * @param \Model $model
     *
     * @return \Model|\Illuminate\Database\Eloquent\Builder
     */
    function modelToQuery($model): \Illuminate\Database\Eloquent\Builder
    {
        $_model = $model->newQuery();
        /** @var $_model \Model */
        return $_model->whereKey($model->getKey());
    }
}

if( !function_exists('trimLower') ) {
    /**
     * @param string|null $string $string
     *
     * @return string
     */
    function trimLower(?string $string): string
    {
        return strtolower(trim($string));
    }
}

if( !function_exists('trimUpper') ) {
    /**
     * @param string|null $string $string
     *
     * @return string
     */
    function trimUpper(?string $string): string
    {
        return strtoupper(trim($string));
    }
}

if( !function_exists('withKey') ) {
    /**
     * If the given data is not an array, wrap it in one.
     * If the given data is array and doesn't has $key ? add $key with $key_default_value.
     *
     * @param array|mixed $value
     * @param string      $key
     * @param mixed       $key_default_value
     *
     * @return array|array[]
     */
    function withKey($value, string $key, $key_default_value = []): array
    {
        $value = is_array($value) ? $value : [ $value ];
        if( isset($value[ $key ]) ) {
            return $value;
        }
        $value[ $key ] = $key_default_value;

        return $value;
    }
}

if( !function_exists('wrapWith') ) {
    /**
     * If the given value is not an array, wrap it in one. and assign it to the given key.
     *
     * @param array|mixed $value
     * @param string|null $key
     *
     * @return array|array[]
     */
    function wrapWith($value, ?string $key = null): array
    {
        if( is_array($value) ) {
            if( is_null($key) ) {
                return array_wrap($value);
            }
            
            if( isset($value[ $key ]) ) {
                return $value;
            }
        }

        return !is_null($key) ? array_add([], $key, $value) : array_wrap($value);
    }
}

if( !function_exists('wrapWithData') ) {
    /**
     * Wrap the given value with 'data' key or return it if already wrapped.
     *
     * @param array|mixed $value
     *
     * @return array|array[]
     */
    function wrapWithData($value): array
    {
        $key = 'data';
        if( is_array($value) ) {
            if( isset($value[ $key ]) ) {
                return $value;
            }
        }

        return array_add([], $key, $value);
    }
}

if( !function_exists('unwrapWith') ) {
    /**+
     * like data_get
     *
     * @param array|mixed                 $data
     * @param string|null                 $key
     * @param mixed|null|OPTION_NO_CHANGE $default
     *
     * @return array|null|mixed
     */
    function unwrapWith($data, string $key = null, $default = null): mixed
    {
        $default = $default === OPTION_NO_CHANGE ? $data : $default;
        $data = ($_data = getArrayableItems($data)) == [ $data ] ? $data : $_data;
        if( is_array($data) ) {
            if( is_null($key) ) {
                return array_is_list($data) ? $default : head($data);
            }

            return data_get($data, $key, $default);
        }

        return $default;
    }
}

if( !function_exists('when') ) {
    /**
     * if $condition then call $whenTrue|null else call $whenFalse|null
     *
     * @param bool|mixed    $condition
     * @param callable|null $whenTrue
     * @param callable|null $whenFalse
     * @param mixed|null    $with
     *
     * @return mixed|null
     */
    function when($condition, ?callable $whenTrue = null, ?callable $whenFalse = null, $with = null): mixed
    {
        if( value($condition) ) {
            return is_callable($whenTrue) ? $whenTrue($condition, $with) : $whenTrue;
        } else {
            return is_callable($whenFalse) ? $whenFalse($condition, $with) : $whenFalse;
        }
    }
}

if( !function_exists('whenInConsole') ) {
    /**
     * Check if the application running in `Console (CLI)`.
     *
     * @param bool|\Closure|mixed $true
     * @param bool|\Closure|mixed $false
     *
     * @return mixed
     */
    function whenInConsole($true = true, $false = false): mixed
    {
        return value(isConsole($true, $false));
    }
}

if( !function_exists('undot') ) {
    /**
     * Expands a dot notation array into a full multi-dimensional array.
     *
     * @param array $array
     *
     * @return array
     */
    function undot(array $array): array
    {
        $result = [];
        foreach( $array as $key => $value ) {
            array_set($result, $key, $value);
        }
    
        return $result;
    }
}