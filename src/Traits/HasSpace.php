<?php

namespace Laravelit\Spaces\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

trait HasSpace
{
    /**
     * Property for caching spaces.
     *
     * @var \Illuminate\Database\Eloquent\Collection|null
     */
    protected $spaces;


    /**
     * User belongs to many spaces.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function spaces()
    {
        return $this->belongsToMany(config('spaces.models.space'))->withTimestamps();
    }

    /**
     * Get all spaces as collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSpaces()
    {
        return (!$this->spaces) ? $this->spaces = $this->spaces()->get() : $this->spaces;
    }

    /**
     * Check if the user has a space or spaces.
     *
     * @param int|string|array $space
     * @param bool $all
     * @return bool
     */
    public function use($space, $all = false)
    {
        if ($this->isPretendSpacesEnabled()) {
            return $this->pretendSpaces('use');
        }

        return $this->{$this->getMethodName('use', $all)}($space);
    }

    /**
     * Check if the user has at least one space.
     *
     * @param int|string|array $space
     * @return bool
     */
    public function useOne($space)
    {
        foreach ($this->getArrayFrom($space) as $space) {
            if ($this->hasSpace($space)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the user has all spaces.
     *
     * @param int|string|array $space
     * @return bool
     */
    public function useAll($space)
    {
        foreach ($this->getArrayFrom($space) as $space) {
            if (!$this->hasSpace($space)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if the user has space.
     *
     * @param int|string $space
     * @return bool
     */
    public function hasSpace($space)
    {
        return $this->getSpaces()->contains(function ($key) use ($space) {
            return $space == $key->id || Str::is($space, $key->slug);
        });
    }

    /**
     * Attach space to a user.
     *
     * @param int|\Laravelit\Spaces\Models\Space $space
     * @return null|bool
     */
    public function attachSpace($space)
    {
        return (!$this->getSpaces()->contains($space)) ? $this->spaces()->attach($space) : true;
    }

    /**
     * Detach space from a user.
     *
     * @param int|\Laravelit\Spaces\Models\Space $space
     * @return int
     */
    public function detachSpace($space)
    {
        $this->spaces = null;

        return $this->spaces()->detach($space);
    }

    /**
     * Detach all spaces from a user.
     *
     * @return int
     */
    public function detachAllSpaces()
    {
        $this->spaces = null;

        return $this->spaces()->detach();
    }

    
    /**
     * Get all permissions from spaces.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function spacePermissions()
    {
        $permissionModel = app(config('roles.models.permission'));

        if (!$permissionModel instanceof Model) {
            throw new InvalidArgumentException('[roles.models.permission] must be an instance of \Illuminate\Database\Eloquent\Model');
        }

        return $permissionModel::select(['permissions.*', 'permission_space.created_at as pivot_created_at', 'permission_space.updated_at as pivot_updated_at'])
                ->join('permission_space', 'permission_space.permission_id', '=', 'permissions.id')->join('spaces', 'spaces.id', '=', 'permission_space.space_id')
                ->whereIn('spaces.id', $this->getSpaces()->lists('id')->toArray())
                ->groupBy(['permissions.id', 'pivot_created_at', 'pivot_updated_at']);
    }

    
    /**
     * Check if pretend option is enabled.
     *
     * @return bool
     */
    private function isPretendSpacesEnabled()
    {
        return (bool) config('spaces.pretend_spaces.enabled');
    }

    /**
     * Allows to pretend or simulate package behavior.
     *
     * @param string $option
     * @return bool
     */
    private function pretendSpaces($option)
    {
        return (bool) config('spaces.pretend_spaces.options.' . $option);
    }

    /**
     * Get method name.
     *
     * @param string $methodName
     * @param bool $all
     * @return string
     */
    private function getMethodName($methodName, $all)
    {
        return ((bool) $all) ? $methodName . 'All' : $methodName . 'One';
    }

    /**
     * Get an array from argument.
     *
     * @param int|string|array $argument
     * @return array
     */
    private function getArrayFrom($argument)
    {
        return (!is_array($argument)) ? preg_split('/ ?[,|] ?/', $argument) : $argument;
    }

    /**
     * Handle dynamic method calls.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (starts_with($method, 'use')) {
        	return $this->use(snake_case(substr($method, 2), config('spaces.separator')));
        }

        return parent::__call($method, $parameters);
    }
}
