<?php /** @noinspection PhpIllegalPsrClassPathInspection */
/*
 * Copyright © 2023. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

namespace MPhpMaster\LaravelHelpers2\Providers;

use Illuminate\Database\Schema\Builder;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

/**
 * Class HelperProvider
 *
 * @package MPhpMaster\LaravelHelpers2\Providers
 */
class HelperProvider extends ServiceProvider
{
    public function register()
    {
        // $this->registerMacros();
    }

    /**
     * Bootstrap services.
     *
     * @param Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        // Builder::defaultStringLength(191);
        // Schema::defaultStringLength(191);

        /**
         * Helpers
         */
        require_once __DIR__ . '/../Helpers/FCheckers.php';
        require_once __DIR__ . '/../Helpers/FGetters.php';
        require_once __DIR__ . '/../Helpers/FHelpers.php';

        \Illuminate\Database\Eloquent\Builder::macro('getSql', function(bool $parse = false) {
            return getSql(
                $this->getModel()->exists ? modelToQuery($this->getModel()) : $this,
                $parse
            );
        });
    }

    /**
     *
     */
    public function registerMacros()
    {
        
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
