<?php

namespace App\Transformers\Inbound\Web;

use App\Transformers\Datum;
use App\Transformers\Inbound\WebTransformer;

class Exhibition extends WebTransformer
{

    protected function getTitle( Datum $datum )
    {

        return [
            'title' => $datum->datahub_id,
            'is_published' => $datum->published,
        ];

    }

}
