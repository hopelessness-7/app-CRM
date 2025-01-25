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
    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts([config('services.search.host')])
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
            // This is useful in case we want to turn-off our
            // search cluster or when deploying the search
            // to a live, running application at first.
            if (! config('services.search.enabled')) {
                return new EloquentRepository();
            }

            return new ElasticsearchRepository(
                $app->make(Client::class)
            );
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
