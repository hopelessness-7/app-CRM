<?php

namespace App\Providers;

use App\Repositories\Search\ElasticsearchRepository;
use App\Repositories\Search\EloquentRepository;
use App\Repositories\Search\Interfaces\BaseSearch;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider
{
    private function bindSearchClient(): void
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts(['http://elastic:password@localhost:9201'])
                ->build();
        });
    }

    /**
     * Register services.
     *
     */

    public function register(): void
    {
        $this->app->bind(BaseSearch::class, function () {
            if (config('services.search.enabled')) {
                return new EloquentRepository();
            } else {
                return new ElasticsearchRepository(
                    $this->app->make(Client::class)
                );
            }
        });

        $this->bindSearchClient();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
