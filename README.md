# Laravel Helpers2
###### Part of mphpmaster/laravel-helpers:^3
<small>v1.1.0</small>

## Dependencies:
* php >=8.1 **REQUIRED IN YOUR PROJECT**
* laravel >=9 **REQUIRED IN YOUR PROJECT**
* illuminate/support >=9 _composer will install it automaticly_
* laravel/helpers ^1.5 _composer will install it automaticly_

## Installation:
  ```shell
  composer require mphpmaster/laravel-helpers2
  ```

## Content
- Providers:
    - `MPhpMaster\LaravelNovaHelpers\Providers\HelperProvider`

- Traits:
  - `MPhpMaster\LaravelNovaHelpers\Traits\TModelTranslation`
  - `MPhpMaster\LaravelNovaHelpers\Traits\TMacroable`

- Macros:
  - Add `getSql` metod to `Query Builder` and `Model`

- Functions:
  - `isArrayableItems`
  - `array_keys_exists`
  - `isJsonable`
  - `isJsonSerializable`
  - `isArrayable`
  - `isClosure`
  - `isClass`
  - `isCallable`
  - `isArrayableOrArray`
  - `isAllable`
  - `isInvocable`
  - `isPaginator`
  - `isPaginated`
  - `isConsole`
  - `isBuilder`
  - `endsWithAny`
  - `isModel`
  - `isRelation`
  - `isCarbon`
  - `isDateTime`
  - `isTraversable`
  - `hasArabicChars`
  - `is_collection`
  - `stringContainsAll`
  - `stringContains`
  - `stringEnds`
  - `stringStarts`
  - `isUrl`
  - `toCollect`
  - `toCollectWithModel`
  - `toCollectOrModel`
  - `toObjectOrModel`
  - `str_before_last_count`
  - `getTable`
  - `getFillable`
  - `getHidden`
  - `getModel`
  - `getModelClass`
  - `getClass`
  - `hasTrait`
  - `hasScope`
  - `hasConst`
  - `getConst`
  - `getSql`
  - `str_prefix`
  - `str_suffix`
  - `str_words_limit`
  - `prefixNumber`
  - `prefixText`
  - `countToken`
  - `replaceTokens`
  - `getTrans`
  - `getNumbers`
  - `getArrayableItems`
  - `valueToDate`
  - `valueToDateTime`
  - `valueToArray`
  - `valueToUnDotArray`
  - `valueToDotArray`
  - `valueToObject`
  - `valueFromJson`
  - `valueToJson`
  - `getValue`
  - `arrayToObject`
  - `arrayToStdClass`
  - `getModelKey`
  - `trimDirectorySeparator`
  - `convert_to_en_numbers`
  - `array_only_except`
  - `array_except_only`
  - `replaceAll`
  - `carbon`
  - `firstSet`
  - `getAny`
  - `test`
  - `iif`
  - `modelToQuery`
  - `trimLower`
  - `trimUpper`
  - `withKey`
  - `wrapWith`
  - `wrapWithData`
  - `unwrapWith`
  - `when`
  - `whenInConsole`
  - `undot`

> *Inspired by laravel/helpers.*

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

The Laravel Helpers: App is open-sourced software licensed under the [MIT license](https://github.com/mPhpMaster/laravel-app-helpers/blob/master/LICENSE).
