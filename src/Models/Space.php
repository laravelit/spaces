<?php

namespace Laravelit\Spaces\Models;

use Laravelit\Spaces\Traits\Slugable;
use Illuminate\Database\Eloquent\Model;
use Laravelit\Spaces\Traits\SpaceHasRelations;
use Laravelit\Spaces\Contracts\SpaceHasRelations as SpaceHasRelationsContract;

class Role extends Model implements SpaceHasRelationsContract
{
    use Slugable, SpaceHasRelations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'level'];

    /**
     * Create a new model instance.
     *
     * @param array $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if ($connection = config('spaces.connection')) {
            $this->connection = $connection;
        }
    }
}
