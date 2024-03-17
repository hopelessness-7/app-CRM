<?php

namespace App\Providers;

use App\Repositories\Search\ElasticsearchRepository;
use App\Repositories\Search\EloquentRepository;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Search\Interfaces\BaseSearch;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
