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

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function search(Model $model, string $query = '', string $field = 'title', $exact = false, $perPage = null): Collection
    {
        $items = $this->searchOnElasticsearch($model, $query, $field, $exact);
        return $this->buildCollection($items, $model, $perPage);
    }

    private function searchOnElasticsearch(string $query, Model $modelEloquent, $field, $exact): array
    {
        $model = new $modelEloquent;

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
                                    'fields' => $field,
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

    private function buildCollection(array $items, Model $modelEloquent, $perPage): Collection
    {
        $ids = Arr::pluck($items, '_id');

        return $modelEloquent::whereIn('id', $ids)
            ->orderByRaw('FIELD(id, ' . implode(',', $ids) . ')')
            ->paginate($perPage);
    }
}
