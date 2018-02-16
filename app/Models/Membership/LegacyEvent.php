<?php

namespace App\Models\Membership;

use App\Models\MembershipModel;
use App\Models\ElasticSearchable;
use App\Models\Documentable;

use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

/**
 * An occurrence of a program at the museum.
 */
class LegacyEvent extends MembershipModel
{

    use ElasticSearchable;
    use Documentable;

    protected $dates = [
        'start_at',
        'end_at',
        'source_created_at',
        'source_modified_at',
    ];

    public function exhibitions()
    {

        return $this->belongsToMany('App\Models\Collections\Exhibition', 'legacy_event_exhibition', 'legacy_event_membership_id', 'exhibition_citi_id');

    }

    protected function getExtraFillFieldsFrom($source)
    {

        //// Available fields we haven't done anything with yet:
        // +"url": "http://www.artic.edu/event/gallery-talk-modern-wing-highlights"

        $ret = [
            'description' => $source->body,
            'short_description' => $source->summary,
            'image_url' => $source->image,
            'start_at' => new Carbon($source->dates ." " .$source->start_time),
            'end_at' => new Carbon($source->dates ." " .$source->end_time),
            'resource_title' => $source->location,
            'web_url' => $source->url,
        ];

        // Set flag is_admission_required
        $ret['is_admission_required'] = FALSE;
        if ($source->fee == "Free with museum admission"
            || $source->fee == "Free with museum admission*"
            || $source->fee == "Free with museum admission, no registration required"
            || $source->fee == "Free with museum admission; registration required"
            || $source->fee == "Free with museum admission, registration required"
            || $source->fee == "Free with museum admission; registration required*"
            || $source->fee == "Free to Illinois residents or with museum admission; registration required*") {

            $ret['is_admission_required'] = TRUE;

        }

        if ($source->button_link)
        {
            $dom = new \DOMDocument();
            @$dom->loadHTML($source->button_link);
            foreach ($dom->getElementsByTagName('a') as $a)
            {

                $ret['button_text'] = $a->textContent;
                $ret['button_url'] = $a->getAttribute('href');

            }
        }
        return $ret;

    }

    public function attachFrom($source)
    {

        if ($source->exhibition_id)
        {

            $ids = explode(', ', $source->exhibition_id);
            $syncIds = [];
            foreach ($ids as $id)
            {
                if ($this->exhibitionIdFromDrupal($id)) {
                    $syncIds[] = $this->exhibitionIdFromDrupal($id);
                }
            }
            $this->exhibitions()->sync($syncIds, false);

        }

        return $this;

    }

    /**
     * Specific field definitions for a given class. See `transformMapping()` for more info.
     */
    protected function transformMappingInternal()
    {

        return [

            [
                "name" => 'description',
                "doc" => "Long description of the event",
                "type" => "string",
                "elasticsearch" => [
                    "default" => true,
                    "type" => 'text',
                ],
                "value" => function() { return $this->description; },
            ],
            [
                "name" => 'short_description',
                "doc" => "Short description of the event",
                "type" => "string",
                'elasticsearch_type' => 'text',
                "value" => function() { return trim($this->short_description); },
            ],
            [
                "name" => 'image',
                "doc" => "URL to an image representing this event",
                "type" => "url",
                'elasticsearch_type' => 'keyword',
                "value" => function() { return $this->image_url; },
            ],
            [
                "name" => 'type',
                "doc" => "The name of the type of event",
                "type" => "string",
                'elasticsearch_type' => 'keyword',
                "value" => function() { return $this->type; },
            ],
            [
                "name" => 'start_at',
                "doc" => "Date and time the event begins",
                "type" => "ISO 8601 date and time",
                'elasticsearch_type' => 'date',
                "value" => function() { return $this->start_at ? $this->start_at->toIso8601String() : NULL; },
            ],
            [
                "name" => 'end_at',
                "doc" => "Date and time the event ends",
                "type" => "ISO 8601 date and time",
                'elasticsearch_type' => 'date',
                "value" => function() { return $this->end_at ? $this->end_at->toIso8601String() : NULL; },
            ],
            [
                "name" => 'resource_title',
                "doc" => "The name of the resource associated with this event, often the venue in which it takes place",
                "type" => "string",
                'elasticsearch_type' => 'keyword',
                "value" => function() { return $this->resource_title; },
            ],
            [
                "name" => 'exhibition_ids',
                "doc" => "Unique identifiers of the exhibitions associated with this work",
                "type" => "array",
                'elasticsearch_type' => 'integer',
                "value" => function() { return $this->exhibitions->pluck('citi_id')->all(); },
            ],
            [
                "name" => 'button_text',
                "doc" => "Name of text on the CTA to buy tickets/register",
                "type" => "string",
                'elasticsearch_type' => 'keyword',
                "value" => function() { return $this->button_text; },
            ],
            [
                "name" => 'button_url',
                "doc" => "URL of the CTA to buy tickets/register",
                "type" => "url",
                'elasticsearch_type' => 'keyword',
                "value" => function() { return $this->button_url; },
            ],

        ];

    }


    /**
     * Get an example ID for documentation generation
     *
     * @return string
     */
    public function exampleId()
    {

        return "28990343";

    }

    public function drupalFeeValues()
    {

        return [
            "Free",
            "Free with museum admission",
            "Free with museum admission*",
            "Free with museum admission, no registration required",
            "Free with museum admission; registration required",
            "Free with museum admission, registration required",
            "Free with museum admission; registration required*",
            "Free; No registration required",
            "Free, no registration required",
            "Free for members; no registration required",
            "Free ticket required",
            "Free; registration required",
            "Free to Illinois residents or with museum admission; registration required*",
            "Registration required",
        ];

    }

    public function drupalTypeValues()
    {

        return [
            "Family Program",
            "Talks",
            "Member Exclusive",
            "Classes and Workshops",
            "Live Arts",
            "Screenings",
            "Special Events",
        ];

    }

    public function printUnknown($knownValues, $val)
    {

        if ($val && !in_array(trim($val), $knownValues))
        {
            Log::warning($val);
        }

    }

    public function exhibitionIdFromDrupal($title)
    {

        switch ($title) {
        case 'Rodin: Sculptor and Storyteller':
        case 7590:
            return 2756;
            break;
        case 'Making Memories: Quilts as Souvenirs':
        case 7435:
            return 2954;
            break;
        case 'Dress Codes: Portrait Photographs from the Collection':
        case 7593:
            return 2959;
            break;
        case 'Andrew Lord: Unslumbrous Night':
        case 7437:
            return 2956;
            break;
        case 'Shockingly Mad: Henry Fuseli and the Art of Drawing':
        case 7592:
            return 2945;
            break;
        case 'Revoliutsiia! Demonstratsiia! Soviet Art Put to the Test':
        case 7436:
            return 2514;
            break;
        case 'Tarsila do Amaral: Inventing Modern Art in Brazil':
        case 7434:
            return 2345;
            break;
        case 'Doctrine and Devotion: Art of the Religious Orders in the Spanish Andes':
        case 6174:
            return 2493;
            break;
        case 'India Modern: The Paintings of M. F. Husain':
        case 7320:
            return 2772;
            break;
        case 'Past Forward: Architecture and Design at the Art Institute':
        case 7438:
            return 5393;
            break;
        case 'Leigh Ledare: The Plot—Ruttenberg Contemporary Photography Series':
        case 7420:
            return 2951;
            break;
        case 'City and Country: Views of Urban and Rural Japan by Modern Japanese Artists':
        case 1425:
            return 8878;
            break;
        case 'Neapolitan Crèche':
        case 6670:
            return 3110;
            break;
        case 'Elizabeth Price':
        case 7623:
            return 2955;
            break;
        }

        return 0;
    }

}