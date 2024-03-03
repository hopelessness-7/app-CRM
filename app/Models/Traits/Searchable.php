<?php

namespace App\Models\Traits;

use App\Observers\ElasticsearchObserver;

trait Searchable
{
    public static function bootSearchable(): void
    {
        // Это облегчает переключение флага поиска.
        if (config('services.search.enabled')) {
            static::observe(ElasticsearchObserver::class);
        }
    }

    public function getSearchIndex()
    {
        return $this->getTable();
    }

    public function getSearchType()
    {
        if (property_exists($this, 'useSearchType')) {
            return $this->useSearchType;
        }
        return $this->getTable();
    }

    public function toSearchArray()
    {
        return $this->toArray();
    }
}
