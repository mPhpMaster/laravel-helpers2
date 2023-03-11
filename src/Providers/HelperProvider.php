<?php /** @noinspection PhpIllegalPsrClassPathInspection */
/*
 * Copyright © 2023. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

namespace MPhpMaster\LaravelHelpers2\Providers;

use Illuminate\Database\Schema\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
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

        /**
         * Paginate a standard Laravel Collection.
         *
         * @mixins Collection
         *
         * @param int|null $perPage
         * @param array    $only
         * @param string   $pageName
         * @param int|null $page
         * @param int|null $total
         * @param string   $pageName
         *
         * @return \Illuminate\Pagination\LengthAwarePaginator
         */
        Collection::macro('paginate', function($perPage = null, array $only = [ '*' ], $pageName = 'page', $page = null, ?int $total = null): LengthAwarePaginator {
            /** @type Collection $this */
            $only = Collection::make($only)->filter(fn($i) => $i && $i !== '*')->toArray();
            $self = count($only) ? $this->only($only) : $this;
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $self->forPage($page, $perPage),
                $total ?: $self->count(),
                $perPage ?: 15,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

        Collection::macro('mergeIfMissing', function(string|\Closure|array $key, mixed $value = null): Collection {
            /** @type Collection $this */
            $key = value($key);
            throw_if(is_array($key) && !is_null($value), "\$key can not be array!");

            $data = is_array($key) ? $key : [ $key => $value ];
            foreach( $data as $key => $value ) {
                $this->getOrPut($key, $value);
            }

            return $this;
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
