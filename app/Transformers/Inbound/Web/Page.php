<?php

namespace App\Transformers\Inbound\Web;

use App\Transformers\Datum;
use App\Transformers\Inbound\AbstractTransformer;

class Page extends AbstractTransformer
{

    use HasBlocks { getExtraFields as getBlockFields; }

    protected function getExtraFields( Datum $datum )
    {

        return array_merge( $this->getBlockFields( $datum ), [
            'publish_start_date' => $datum->date('publish_start_date'),
            'publish_end_date' => $datum->date('publish_end_date'),
        ]);

    }

}
