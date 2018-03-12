<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\Documentable;
use App\Models\ElasticSearchable;

/**
 * A base model for Web CMS resources
 */
class WebModel extends BaseModel
{

    use Documentable, ElasticSearchable;

    protected $casts = [
        'source_created_at' => 'date',
        'source_modified_at' => 'date',
        'published' => 'boolean',
    ];

    protected static $source = 'Web';

    protected function getMappingForDates()
    {

        if ($this->excludeDates)
        {
            return $ret;
        }

        $ret = parent::getMappingForDates();

        // We need to replace the `doc` and `value of an item already in the array
        // This is tricky since we don't key by the field name
        // We should consider doing so once this logic lives in outbound transformers
        foreach ($ret as &$field) {
            if($field['name'] == 'last_updated_source') {
                $field['doc'] = "Date and time the resource was updated on the website";
                $field['value'] = function() { return $this->source_modified_at ? $this->source_modified_at->toIso8601String() : NULL; };
            }
        }

        return $ret;

    }
}