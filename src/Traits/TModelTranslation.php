<?php
/*
 * Copyright © 2023. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

namespace MPhpMaster\LaravelNovaHelpers\Traits;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait TModelTranslation
{
    /**
     * Returns translations file name.
     *
     * @return string|null
     */
    public static function getTranslationKey(): ?string
    {
        return static::make()->getTable();
    }

    /**
     * Encode the given value as JSON.
     *
     * @param  mixed  $value
     * @return string
     */
    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    /**
     * alias for __("models/model_name") and __("models/model_name.fields.field_name")
     *
     * @param string|null          $key
     * @param array|\Closure|mixed $replace
     * @param string|null          $locale
     * @param string|\Closure|null $default
     *
     * @return array|string|null
     */
    public static function trans(string $key = null, $replace = [], ?string $locale = null, $default = null): array|string|null
    {
        $transKey = static::getTranslationKey() ?? static::make()->getTable();
        $models = [
            str_plural(snake_case($transKey)),
            str_singular(snake_case($transKey)),

            str_plural(snake_case(class_basename(static::class))),
            str_singular(snake_case(class_basename(static::class))),
        ];

        $replace = !is_array($replace = value($replace)) ? array_wrap($replace) : $replace;
        $default = is_null($default = value($default)) ? $key : $default;

        $result = null;
        foreach( $models as $model ) {
            if( $result = getTrans(
                "models/{$model}.{$key}",
                getTrans(
                    "models/{$model}.fields.{$key}",
                    null,

                    $replace,
                    $locale
                ),
                $replace,
                $locale
            ) ) {
                break;
            }
        }
        $result ??= value($default);

        return $result;
    }
}
