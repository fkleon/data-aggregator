<?php

namespace App\Console\Commands\Search;

use Carbon\Carbon;
use Elasticsearch;

use Aic\Hub\Foundation\AbstractCommand as BaseCommand;

class SearchAudit extends BaseCommand
{

    protected $signature = 'search:audit';

    protected $description = 'Compare the counts of database records with those in the search index';


    public function handle()
    {

        $models = app('Search')->getSearchableModels();

        foreach ($models as $model)
        {

            $this->compareTotals( $model );
            $this->compareLatest( $model );

        }

    }


    public function compareTotals( $model )
    {

        $response = Elasticsearch::search([
            'index' => app('Search')->getIndexForModel( $model ),
            'type' => app('Search')->getTypeForModel( $model ),
            'size' => 0
        ]);

        $es_count = $response['hits']['total'];
        $db_count = $model::count();

        if ($es_count != $db_count) {
            $endpoint = app('Resources')->getEndpointForModel( $model );

            $method = ( abs($es_count - $db_count) > 10 ) ? 'warn' : 'info';
            $this->info( "{$endpoint} = {$db_count} in database, {$es_count} in search index");
        }
    }

    public function compareLatest( $model )
    {

        if ($model::count() == 0) {
            return;
        }

        $response = Elasticsearch::search([
            'index' => app('Search')->getIndexForModel( $model ),
            'type' => app('Search')->getTypeForModel( $model ),
            'size' => 1,
            'body' => [
                'sort' => 'timestamp',
            ],
        ]);

        // Nothing to compare to. Jump out and let compareTotal report the quantity discrepancy.
        if (count($response['hits']['hits']) == 0) {
            return;
        }

        $es_latest = new Carbon($response['hits']['hits'][0]['_source']['last_updated']);
        $db_latest = $model::first()->updated_at;

        // Only report if the database is more than a day ahead of the search index
        if ($db_latest->subDay()->gte($es_latest)) {
            $endpoint = app('Resources')->getEndpointForModel( $model );

            $this->info( "{$endpoint} = {$db_latest} in database, {$es_latest} in search index");
        }
    }
}
