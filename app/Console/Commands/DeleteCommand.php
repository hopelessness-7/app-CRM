<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Elastic\Elasticsearch\Client;

class DeleteCommand extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:delete-index {model : The model class to delete index}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes the Elasticsearch index of a model';

    private Client $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        parent::__construct();
        $this->elasticsearch = $elasticsearch;
    }

    public function handle()
    {
        $modelClass = $this->argument('model');

        if (!class_exists($modelClass) || !is_subclass_of($modelClass, Model::class)) {
            $this->error('Invalid model class: ' . $modelClass);
        }

        $this->info('Deleting index for ' . $modelClass . ' records...');

        $model = new $modelClass;

        if ($this->elasticsearch->indices()->exists(['index' => $model->getSearchIndex()])) {
            $this->elasticsearch->indices()->delete(['index' => $model->getSearchIndex()]);
            $this->info('Index deleted for ' . $modelClass);
        } else {
            $this->info('Index does not exist for ' . $modelClass);
        }
    }
}
