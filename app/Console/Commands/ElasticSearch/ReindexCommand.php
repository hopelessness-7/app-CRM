<?php

namespace App\Console\Commands\ElasticSearch;

use Elastic\Elasticsearch\Client;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class ReindexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex {model : The model class to reindex}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all records of a model to Elasticsearch';

    private Client $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        parent::__construct();
        $this->elasticsearch = $elasticsearch;
    }

    public function handle(): void
    {
        $modelClass = $this->argument('model');

        if (!class_exists($modelClass) || !is_subclass_of($modelClass, Model::class)) {
            $this->error('Invalid model class: ' . $modelClass);
            return;
        }

        $this->info('Indexing all ' . $modelClass . ' records. This might take a while...');

        $model = new $modelClass;

        // Создание анализатора перед началом индексации
        $this->elasticsearch->indices()->create([
            'index' => $model->getSearchIndex(),
            'body' => [
                'settings' => [
                    'analysis' => [
                        'analyzer' => [
                            'prefix_analyzer' => [
                                'type' => 'custom',
                                'tokenizer' => 'standard',
                                'filter' => ['lowercase']
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        foreach ($model->cursor() as $record) {
            // Установка настроек анализатора для поля 'title'
            $this->elasticsearch->indices()->putMapping([
                'index' => $record->getSearchIndex(),
                'type' => $record->getSearchType(),
                'body' => [
                    'properties' => [
                        'title' => [
                            'type' => 'text',
                            'analyzer' => 'prefix_analyzer'
                        ]
                    ]
                ]
            ]);

            // Индексация данных
            $this->elasticsearch->index([
                'index' => $record->getSearchIndex(),
                'type' => $record->getSearchType(),
                'id' => $record->getKey(),
                'body' => $record->toSearchArray(),
            ]);

            $this->output->write('.');
        }

        $this->info('\nDone!');
    }
}
