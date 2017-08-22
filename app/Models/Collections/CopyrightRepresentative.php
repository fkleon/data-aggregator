<?php

namespace App\Models\Collections;

class CopyrightRepresentative extends Agent
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agents';

    public function newQuery($excludeDeleted = true)
    {

        return parent::newQuery()->whereHas('agentType', function ($query) { $query->where('title', '=', 'Copyright Representative'); });

    }

    /**
     * Create a new instance of the given model.
     *
     * @param  array  $attributes
     * @param  bool  $exists
     * @return static
     */
    public function newInstance($attributes = [], $exists = false)
    {

        $model = parent::newInstance($attributes, $exists);
        $model->agentType()->associate(\App\Models\Collections\AgentType::where('title', 'Copyright Representative')->first());
        return $model;

    }

    public function getAgentTypeAttribute()
    {

        App\Models\Collections\AgentType::where('title', 'Copyright Representative')->first();

    }

    /**
     * The artworks that belong to the category.
     */
    public function artworks()
    {

        return $this->belongsToMany('App\Models\Collections\Artwork');

    }


}