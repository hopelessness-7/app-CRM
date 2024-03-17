<?php

namespace App\Repositories\Search;

use App\Repositories\Search\Interfaces\BaseSearch;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Elastic\Elasticsearch\Client;
use Illuminate\Support\Arr;

class ElasticsearchRepository implements BaseSearch
{
    private $elasticsearch;

    public function search(Model $model, string $query = '', string $field = 'title', $exact = false, $perPage = null): mixed
    {
        $this->elasticsearch = app(Client::class);
        $items = $this->searchOnElasticsearch($model, $query, $field, $exact);
        return $this->buildCollection($items, $model, $perPage);
    }

    private function searchOnElasticsearch(Model $modelEloquent, string $query, $field, $exact): array
    {
        $model = new $modelEloquent;
        $query = str_replace('@', '\@', $query);

        if ($exact) {
            return $this->exact($model, $field, $query);
        } else {
            return $this->fullText($model, $field, $query);
        }

    }

    private function exact(Model $model, $field, $query): array
    {

        $items = $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            'match' => [
                                $field => $query
                            ]
                        ]
                    ],
                ],
            ],
        ]);

        return $items['hits']['hits'];
    }

    private function fullText(Model $model, $field, $query): array
    {
        $items = $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'query_string' => [
                                    'fields' => [$field],
                                    'query' => '*' . $query . '*',
                                ],
                            ]
                        ],
                    ],
                ],
            ],
        ]);

        return $items['hits']['hits'];
    }

    private function buildCollection(array $items, Model $modelEloquent, $perPage): mixed
    {
        $ids = Arr::pluck($items, '_id');

        $requestEloquent = $modelEloquent::whereIn('id', $ids);

        if ($perPage != null) {
            return $requestEloquent->paginate($perPage);
        } else {
            return $requestEloquent->get();
        }
    }
}
