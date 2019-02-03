<?php

namespace App\Transformers\Outbound\Collections\Traits;

trait HasLakeFields
{

    protected function getIds()
    {
        return array_merge(parent::getIds(), [
            'lake_guid' => [
                'doc' => 'Unique UUID of this resource in LAKE, our DAMS.',
                'type' => 'uuid',
                'elasticsearch' => 'keyword',
            ],
        ]);
    }

    protected function getDates()
    {
        $dates = parent::getDates();

        $dates['last_updated_source']['value'] = $this->getDateValue('source_indexed_at');

        return $dates;
    }

}
