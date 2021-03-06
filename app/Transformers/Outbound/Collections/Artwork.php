<?php

namespace App\Transformers\Outbound\Collections;

use App\Transformers\Outbound\Collections\ArtworkArtistPivot as ArtworkArtistPivotTransformer;
use App\Transformers\Outbound\Collections\ArtworkCatalogue as ArtworkCatalogueTransformer;
use App\Transformers\Outbound\Collections\ArtworkDate as ArtworkDateTransformer;
use App\Transformers\Outbound\Collections\ArtworkPlacePivot as ArtworkPlacePivotTransformer;
use App\Transformers\Outbound\StaticArchive\Site as SiteTransformer;

use App\Transformers\Outbound\Collections\Traits\HasBoosted;
use App\Transformers\Outbound\HasSuggestFields;

use App\Transformers\Outbound\CollectionsTransformer as BaseTransformer;

class Artwork extends BaseTransformer
{

    use HasBoosted;
    use HasSuggestFields {
        getSuggestFields as traitGetSuggestFields;
    }

    protected $availableIncludes = [
        'artist_pivots',
        'catalogue_pivots',
        'dates',
        'place_pivots',
        'sites',
    ];

    public function includeArtistPivots($artwork)
    {
        return $this->collection($artwork->artistPivots, new ArtworkArtistPivotTransformer, false);
    }

    public function includeCataloguePivots($artwork)
    {
        return $this->collection($artwork->artworkCatalogues, new ArtworkCatalogueTransformer, false);
    }

    public function includeDates($artwork)
    {
        return $this->collection($artwork->dates, new ArtworkDateTransformer, false);
    }

    public function includePlacePivots($artwork)
    {
        return $this->collection($artwork->placePivots, new ArtworkPlacePivotTransformer, false);
    }

    public function includeSites($artwork)
    {
        return $this->collection($artwork->sites, new SiteTransformer, false);
    }

    protected function getTitles()
    {
        return array_merge(parent::getTitles(), [
            'alt_titles' => [
                'doc' => 'Altername names for this work',
                'type' => 'array',
                'elasticsearch' => [
                    'default' => true,
                    'type' => 'text',
                ],
            ],
        ]);
    }

    protected function getFields()
    {
        return [
            /**
             * TODO: Abstract thumbnail to trait?
             */
            'thumbnail' => [
                'doc' => 'Thumbnail for showing this entity in search results. Currently, all thumbnails are IIIF images, but this may change in the future, so check `type` before proceeding.',
                'type' => 'array',
                'elasticsearch' => [
                    'mapping' => [
                        'type' => 'object',
                        'properties' => [
                            'url' => [ 'type' => 'keyword' ],
                            'type' => [ 'type' => 'keyword' ],
                            'lqip' => [ 'enabled' => false ],
                            'width' => [ 'type' => 'integer' ],
                            'height' => [ 'type' => 'integer' ],
                            'alt_text' => [ 'type' => 'text' ],
                        ]
                    ]
                ],
                'value' => function ($item) {
                    return !$item->thumbnail ? null : [
                        'url' => $item->thumbnail->iiif_url ?? null,
                        'type' => 'iiif',
                        'lqip' => $item->thumbnail->metadata->lqip ?? null,
                        'width' => $item->thumbnail->metadata->width ?? null,
                        'height' => $item->thumbnail->metadata->height ?? null,
                        'alt_text' => $item->thumbnail->alt_text ?? ($item->alt_text ?? null),
                    ];
                },
            ],

            /**
             * Finding aids:
             */
            'main_reference_number' => [
                'doc' => 'Unique identifier assigned to the artwork upon acquisition',
                'type' => 'string',
                'elasticsearch' => [
                    'default' => true,
                    'boost' => 3,
                    'type' => 'keyword',
                ],
                'value' => function ($item) {
                    return $item->main_id;
                },
            ],
            'pageviews' => [
                'doc' => 'Approx. number of times this artwork was viewed on our website since Jan 1st, 2010',
                'type' => 'number',
                'elasticsearch' => [
                    'type' => 'integer',
                ],
            ],
            'boost_rank' => [
                'doc' => 'Manual indication of what rank this artwork should take in search results. Noncontiguous.',
                'type' => 'number',
                'elasticsearch' => [
                    'type' => 'integer',
                ],
                'value' => function ($item) {
                    return $item->getBoostRank();
                },
            ],

            /**
             * Primary collection fields:
             */
            'date_start' => [
                'doc' => 'The year of the period of time associated with the creation of this work',
                'type' => 'number',
                'elasticsearch' => 'integer',
            ],
            'date_end' => [
                'doc' => 'The year of the period of time associated with the creation of this work',
                'type' => 'number',
                'elasticsearch' => 'integer',
            ],
            'date_display' => [
                'doc' => 'Readable, free-text description of the period of time associated with the creation of this work. This might include date terms like Dynasty, Era etc. Written by curators and editors in house style, and is the preferred field for display on websites and apps. ',
                'type' => 'string',
                'elasticsearch' => [
                    'default' => true,
                    'type' => 'text',
                ],
            ],
            'artist_display' => [
                'doc' => 'Readable description of the creator of this work. Includes artist names, nationality and lifespan dates',
                'type' => 'string',
                'elasticsearch' => [
                    'default' => true,
                    'type' => 'text',
                ],
            ],
            'place_of_origin' => [
                'doc' => 'The location where the creation, design, or production of the work took place, or the original location of the work',
                'type' => 'string',
                'elasticsearch' => [
                    'default' => true,
                ],
            ],
            'description' => [
                'doc' => 'Longer explanation describing the work',
                'type' => 'string',
                'elasticsearch' => 'text',
            ],
            'dimensions' => [
                'doc' => 'The size, shape, scale, and dimensions of the work. May include multiple dimension like overall, frame, or dimension for each section of a work. Free-form text formatted in a house style.',
                'type' => 'string',
                'elasticsearch' => 'keyword',
            ],
            'medium_display' => [
                'doc' => 'The substances or materials used in the creation of a work',
                'type' => 'string',
                'elasticsearch' => [
                    'default' => true,
                    'type' => 'text',
                ],
            ],
            'inscriptions' => [
                'doc' => 'A description of distinguishing or identifying physical markings that are on the work',
                'type' => 'string',
                'elasticsearch' => 'text',
            ],
            'credit_line' => [
                'doc' => 'Brief statement indicating how the work came into the collection',
                'type' => 'string',
                'elasticsearch' => [
                    'default' => true,
                    'type' => 'text',
                ],
            ],
            'publication_history' => [
                'doc' => 'Bibliographic list of all the places this work has been published',
                'type' => 'string',
                'elasticsearch' => 'text',
            ],
            'exhibition_history' => [
                'doc' => 'List of all the places this work has been exhibited',
                'type' => 'string',
                'elasticsearch' => 'text',
            ],
            'provenance_text' => [
                'doc' => 'Ownership/collecting history of the work. May include names of owners, dates, and possibly methods of transfer of ownership. Free-form text formatted in a house style.',
                'type' => 'string',
                'elasticsearch' => 'text',
                'value' => function ($item) {
                    return $item->provenance;
                },
            ],

            /**
             * Publishing fields:
             */
            'publishing_verification_level' => [
                'doc' => 'Indicator of how much metadata on the work in published. Web Basic is the least amount, Web Everything is the greatest.',
                'type' => 'string',
                'elasticsearch' => 'keyword',
            ],
            'collection_status' => [
                'doc' => 'The works status of belonging to our collection. Values include "Permanent Collection", "Ryerson Collection", and "Long-term Loan".',
                'type' => 'string',
                'elasticsearch' => 'text',
            ],
            'fiscal_year' => [
                'doc' => 'The fiscal year in which the work was acquired.',
                'type' => 'number',
                'elasticsearch' => 'integer',
            ],

            /**
             * Copyright fields:
             */
            'is_public_domain' => [
                'doc' => 'Whether the work is in the public domain, meaning it was created before copyrights existed or has left the copyright term',
                'type' => 'boolean',
                'elasticsearch' => 'boolean',
            ],
            'is_zoomable' => [
                'doc' => 'Whether images of the work are allowed to be displayed in a zoomable interface.',
                'type' => 'boolean',
                'elasticsearch' => 'boolean',
            ],
            'max_zoom_window_size' => [
                'doc' => 'The maximum size of the window the image is allowed to be viewed in, in pixels.',
                'type' => 'number',
                'elasticsearch' => 'integer',
            ],
            'copyright_notice' => [
                'doc' => 'Statement notifying how the work is protected by copyright. Applies to the work itself, not image or other related assets.',
                'type' => 'string',
                'elasticsearch' => 'text',
            ],


            /**
             * Asset fields for website:
             */
            'has_multimedia_resources' => [
                'doc' => 'Whether this artwork has any associated microsites, digital publications, or documents tagged as multimedia',
                'type' => 'boolean',
                'elasticsearch' => 'boolean',
                'value' => function ($item) {
                    return (
                        $item->documents->where('is_multimedia_resource', true)->count() > 0
                    ) || (
                        $item->sections->count() > 0
                    ) || (
                        $item->sites->count() > 0
                    );
                },
            ],
            'has_educational_resources' => [
                'doc' => 'Whether this artwork has any documents tagged as educational',
                'type' => 'boolean',
                'elasticsearch' => 'boolean',
                'value' => function ($item) {
                    return $item->documents->where('is_educational_resource', true)->count() > 0;
                },
            ],

            /**
             * Enhanced image metadata:
             */
            'colorfulness' => [
                'doc' => 'Unbounded positive float representing an abstract measure of colorfulness.',
                'type' => 'float',
                'elasticsearch' => [
                    'mapping' => [
                        'type' => 'scaled_float',
                        'scaling_factor' => 10000,
                    ]
                ],
                'value' => function ($item) {
                    return $item->image->metadata->colorfulness ?? null;
                },
            ],
            'color' => [
                'doc' => 'Dominant color of this artwork in HSL',
                'type' => 'object',
                'elasticsearch' => [
                    'mapping' => [
                        'type' => 'object',
                        'properties' => [
                            'population' => [ 'type' => 'integer' ],
                            'percentage' => [ 'type' => 'float' ],
                            'h' => [ 'type' => 'integer' ],
                            's' => [ 'type' => 'integer' ],
                            'l' => [ 'type' => 'integer' ],
                        ],
                    ],
                ],
                'value' => function ($item) {
                    return $item->image->metadata->color ?? null;
                },
            ],


            /**
             * Mobile and location fields:
             */
            'latitude' => [
                'doc' => 'Latitude coordinate of the location of this work in our galleries',
                'type' => 'number',
                'elasticsearch' => 'float',
                'value' => function ($item) {
                    return $item->mobileArtwork->latitude ?? null;
                },
            ],
            'longitude' => [
                'doc' => 'Longitude coordinate of the location of this work in our galleries',
                'type' => 'number',
                'elasticsearch' => 'float',
                'value' => function ($item) {
                    return $item->mobileArtwork->longitude ?? null;
                },
            ],
            'latlon' => [
                'doc' => 'Latitude and longitude coordinates of the location of this work in our galleries',
                'type' => 'string',
                'elasticsearch' => 'geo_point',
                'value' => function ($item) {
                    $latitude = $item->mobileArtwork->latitude ?? null;
                    $longitude = $item->mobileArtwork->latitude ?? null;
                    if ($latitude && $longitude)
                    {
                        return $latitude . ',' . $longitude;
                    }
                },
            ],
            'selector_number' => [
                'doc' => 'The code that can be entered in our audioguides to learn more about this work',
                'type' => 'number',
                'elasticsearch' => 'integer',
                'value' => function ($item) {
                    return $item->mobileArtwork->selector_number ?? null;
                },
            ],
            'is_on_view' => [
                'doc' => 'Whether the work is on display',
                'type' => 'boolean',
                'elasticsearch' => 'boolean',
                'value' => function ($item) {
                    return $item->gallery && !$item->gallery->closed ? true : false;
                },
            ],

            /**
             * TODO: Refactor relationships:
             */
            'gallery_title' => [
                'doc' => 'The location of this work in our museum',
                'type' => 'string',
                'elasticsearch' => 'text',
                'value' => function ($item) {
                    return $item->gallery->title ?? null;
                },
            ],
            'gallery_id' => [
                'doc' => 'Unique identifier of the location of this work in our museum',
                'type' => 'number',
                'elasticsearch' => 'integer',
                'value' => function ($item) {
                    return $item->gallery->citi_id ?? null;
                },
            ],
            'artwork_type_title' => [
                'doc' => 'The kind of object or work (e.g. Painting, Sculpture, Book)',
                'type' => 'string',
                'value' => function ($item) {
                    return $item->artworkType->title ?? null;
                },
            ],
            'artwork_type_id' => [
                'doc' => 'Unique identifier of the kind of object or work',
                'type' => 'number',
                'elasticsearch' => 'integer',
                'value' => function ($item) {
                    return $item->artworkType->citi_id ?? null;
                },
            ],
            'department_title' => [
                'doc' => 'Name of the curatorial department that this work belongs to',
                'type' => 'string',
                'value' => function ($item) {
                    return $item->departments->first()->title ?? null;
                },
            ],
            'department_id' => [
                'doc' => 'Unique identifier of the curatorial department that this work belongs to',
                'type' => 'number',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return $item->departments->first()->lake_uid ?? null;
                },
            ],
            'artist_id' => [
                'doc' => 'Unique identifier of the preferred artist/culture associated with this work',
                'type' => 'integer',
                'elasticsearch' => 'integer',
                'value' => function ($item) {
                    return $item->artist->citi_id ?? null;
                },
            ],
            'artist_title' => [
                'doc' => 'Name of the preferred artist/culture associated with this work',
                'type' => 'string',
                'value' => function ($item) {
                    return $item->artist->title ?? null;
                },
            ],
            'alt_artist_ids' => [
                'doc' => 'Unique identifiers of the non-preferred artists/cultures associated with this work',
                'type' => 'array',
                'elasticsearch' => 'integer',
                'value' => function ($item) {
                    return array_pluck($item->altArtists, 'citi_id');
                },
            ],
            'artist_ids' => [
                'doc' => 'Unique identifier of all artist/cultures associated with this work',
                'type' => 'integer',
                'elasticsearch' => 'integer',
                'value' => function ($item) {
                    return $item->artists->pluck('citi_id');
                },
            ],
            'artist_titles' => [
                'doc' => 'Names of all artist/cultures associated with this work',
                'type' => 'array',
                'elasticsearch' => [
                    'default' => true,
                    // This is controllable via .env so we can tweak it without pushing to prod
                    'boost' => (float) ( env('SEARCH_BOOST_ARTIST_TITLES') ?: 2 ),
                ],
                'value' => function ($item) {
                    return $item->artists->pluck('title');
                },
            ],
            'category_ids' => [
                'doc' => 'Unique identifiers of the categories this work is a part of',
                'type' => 'array',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return $item->categories->pluck('lake_uid');
                },
            ],
            'category_titles' => [
                'doc' => 'Names of the categories this artwork is a part of',
                'type' => 'array',
                'elasticsearch' => [
                    'default' => true,
                ],
                'value' => function ($item) {
                    return $item->categories->pluck('title');
                },
            ],
            'artwork_catalogue_ids' => [
                'doc' => 'This list represents all the catalogues this work is included in. This isn\'t an exhaustive list of publications where the work has been mentioned. For that, see `publication_history`.',
                'type' => 'array',
                'elasticsearch' => 'integer',
                'value' => function ($item) {
                    return $item->artworkCatalogues->pluck('citi_id');
                },
            ],
            'term_titles' => [
                'doc' => 'The names of the taxonomy tags for this work',
                'type' => 'array',
                'elasticsearch' => [
                    'default' => true,
                    'boost' => 2,
                ],
                'value' => function ($item) {
                    return $item->terms->pluck('title');
                },
            ],
            'style_id' => [
                'doc' => 'Unique identifier of the preferred style term for this work',
                'type' => 'string',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return $item->style->lake_uid ?? null;
                },
            ],
            'style_title' => [
                'doc' => 'The name of the preferred style term for this work',
                'type' => 'string',
                'value' => function ($item) {
                    return $item->style->title ?? null;
                },
            ],
            'alt_style_ids' => [
                'doc' => 'Unique identifiers of all other non-preferred style terms for this work',
                'type' => 'array',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return array_pluck($item->altStyles, 'lake_uid');
                },
            ],
            'style_ids' => [
                'doc' => 'Unique identifiers of all style terms for this work',
                'type' => 'array',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return array_pluck($item->styles, 'lake_uid');
                },
            ],
            'style_titles' => [
                'doc' => 'The names of all style terms related to this artwork',
                'type' => 'array',
                'value' => function ($item) {
                    return array_pluck($item->styles, 'title');
                },
            ],
            'classification_id' => [
                'doc' => 'Unique identifier of the preferred classification term for this work',
                'type' => 'string',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return $item->classification->lake_uid ?? null;
                },
            ],
            'classification_title' => [
                'doc' => 'The name of the preferred classification term for this work',
                'type' => 'string',
                'value' => function ($item) {
                    return $item->classification->title ?? null;
                },
            ],
            'alt_classification_ids' => [
                'doc' => 'Unique identifiers of all other non-preferred classification terms for this work',
                'type' => 'array',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return array_pluck($item->altClassifications, 'lake_uid');
                },
            ],
            'classification_ids' => [
                'doc' => 'Unique identifiers of all classification terms for this work',
                'type' => 'array',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return array_pluck($item->classifications, 'lake_uid');
                },
            ],
            'classification_titles' => [
                'doc' => 'The names of all classification terms related to this artwork',
                'type' => 'array',
                'value' => function ($item) {
                    return array_pluck($item->classifications, 'title');
                },
            ],
            'subject_id' => [
                'doc' => 'Unique identifier of the preferred subject term for this work',
                'type' => 'string',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return $item->subject->lake_uid ?? null;
                },
            ],
            'alt_subject_ids' => [
                'doc' => 'Unique identifiers of all other non-preferred subject terms for this work',
                'type' => 'array',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return array_pluck($item->altSubjects, 'lake_uid');
                },
            ],
            'subject_ids' => [
                'doc' => 'Unique identifiers of all subject terms for this work',
                'type' => 'array',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return array_pluck($item->subjects, 'lake_uid');
                },
            ],
            'subject_titles' => [
                'doc' => 'The names of all subject terms related to this artwork',
                'type' => 'array',
                'value' => function ($item) {
                    return array_pluck($item->subjects, 'title');
                },
            ],
            'material_id' => [
                'doc' => 'Unique identifier of the preferred material term for this work',
                'type' => 'string',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return $item->material->lake_uid ?? null;
                },
            ],
            'alt_material_ids' => [
                'doc' => 'Unique identifiers of all other non-preferred material terms for this work',
                'type' => 'array',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return array_pluck($item->altMaterials, 'lake_uid');
                },
            ],
            'material_ids' => [
                'doc' => 'Unique identifiers of all material terms for this work',
                'type' => 'array',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return array_pluck($item->materials, 'lake_uid');
                },
            ],
            'material_titles' => [
                'doc' => 'The names of all material terms related to this artwork',
                'type' => 'array',
                'value' => function ($item) {
                    return array_pluck($item->materials, 'title');
                },
            ],
            'technique_id' => [
                'doc' => 'Unique identifier of the preferred technique term for this work',
                'type' => 'string',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return $item->technique->lake_uid ?? null;
                },
            ],
            'alt_technique_ids' => [
                'doc' => 'Unique identifiers of all other non-preferred technique terms for this work',
                'type' => 'array',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return array_pluck($item->altTechniques, 'lake_uid');
                },
            ],
            'technique_ids' => [
                'doc' => 'Unique identifiers of all technique terms for this work',
                'type' => 'array',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return array_pluck($item->techniques, 'lake_uid');
                },
            ],
            'technique_titles' => [
                'doc' => 'The names of all technique terms related to this artwork',
                'type' => 'array',
                'value' => function ($item) {
                    return array_pluck($item->techniques, 'title');
                },
            ],
            'theme_titles' => [
                'doc' => 'The names of all thematic publish categories related to this artwork',
                'type' => 'array',
                'value' => function ($item) {
                    return $item->themes->pluck('title');
                },
            ],
            'image_id' => [
                'doc' => 'Unique identifier of the preferred image to use to represent this work',
                'type' => 'uuid',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return $item->image->lake_guid ?? null;
                },
            ],
            'alt_image_ids' => [
                'doc' => 'Unique identifiers of all non-preferred images of this work.',
                'type' => 'array',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return array_pluck($item->altImages, 'lake_guid');
                },
            ],
            'document_ids' => [
                'doc' => 'Unique identifiers of assets that serve as documentation for this artwork',
                'type' => 'array',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return $item->documents->pluck('lake_guid') ?? null;
                },
            ],
            'sound_ids' => [
                'doc' => 'Unique identifiers of the audio about this work',
                'type' => 'uuid',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return array_pluck($item->sounds(), 'lake_guid') ?? null;
                },
            ],
            'video_ids' => [
                'doc' => 'Unique identifiers of the videos about this work',
                'type' => 'uuid',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return array_pluck($item->videos(), 'lake_guid') ?? null;
                },
            ],
            'text_ids' => [
                'doc' => 'Unique identifiers of the texts about this work',
                'type' => 'uuid',
                'elasticsearch' => 'keyword',
                'value' => function ($item) {
                    return array_pluck($item->texts(), 'lake_guid') ?? null;
                },
            ],
            'tour_stop_ids' => [
                'doc' => 'Unique identifiers of the tour stops this work is included in',
                'type' => 'array',
                'elasticsearch' => 'integer',
                'value' => function ($item) {
                    return $item->mobileArtwork ? ( $item->mobileArtwork->stops->pluck('id') ) : [];
                },
            ],
            'tour_titles' => [
                'doc' => 'Names of the tours this work is a part of',
                'type' => 'array',
                'elasticsearch' => 'text',
                'value' => function ($item) {
                    return $item->mobileArtwork && $item->mobileArtwork->tours ? $item->mobileArtwork->tours->pluck('title') ?? null : null; },
            ],
            'section_ids' => [
                'doc' => 'Unique identifiers of the digital publication chaptes this work in included in',
                'type' => 'array',
                'elasticsearch' => 'long',
                'value' => function ($item) {
                    return $item->sections->pluck('dsc_id');
                },
            ],
            'section_titles' => [
                'doc' => 'Names of the digital publication chapters this work is included in',
                'type' => 'array',
                'elasticsearch' => 'text',
                'value' => function ($item) {
                    return $item->sections->pluck('title');
                },
            ],
            'site_ids' => [
                'doc' => 'Unique identifiers of the microsites this work is a part of',
                'type' => 'array',
                'elasticsearch' => 'integer',
                'value' => function ($item) {
                    return $item->sites->pluck('site_id');
                },
            ],
        ];
    }

    /**
     * Add suggest fields and values. By default, only boosted works are added to the autocomplete.
     *
     * @link https://www.elastic.co/guide/en/elasticsearch/reference/5.3/search-suggesters.html
     * @link https://www.elastic.co/blog/you-complete-me
     *
     * @return array
     */
    protected function getSuggestFields()
    {
        $suggestFields = $this->traitGetSuggestFields();

        $suggestFields['suggest_autocomplete_all']['value'] = function ($item) {
            return [
                [
                    'input' => [
                        $item->main_id
                    ],
                    'contexts' => [
                        'groupings' => [
                            'accession',
                        ]
                    ],
                ],
                [
                    'input' => [
                        $item->title
                    ],
                    'weight' => $item->pageviews ?? 1,
                    'contexts' => [
                        'groupings' => [
                            'title',
                        ]
                    ],
                ],
            ];
        };

        return $suggestFields;

    }

}
