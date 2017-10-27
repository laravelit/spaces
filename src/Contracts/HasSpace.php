<?php

namespace Laravelit\spaces\Contracts;

use Illuminate\Database\Eloquent\Model;

interface HasSpace
{
    /**
     * User belongs to many spaces.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function spaces();

    /**
     * Get all spaces as collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSpaces();

    /**
     * Check if the user has a space or spaces.
     *
     * @param int|string|array $space
     * @param bool $all
     * @return bool
     */
    public function use($space, $all = false);

    /**
     * Check if the user has all spaces.
     *
     * @param int|string|array $space
     * @return bool
     */
    public function useAll($Space);

    /**
     * Check if the user has at least one space.
     *
     * @param int|string|array $space
     * @return bool
     */
    public function useOne($space);

    /**
     * Check if the user has space.
     *
     * @param int|string $space
     * @return bool
     */
    public function hasSpace($space);

    /**
     * Attach space to a user.
     *
     * @param int|\Laravelit\Spaces\Models\Space $space
     * @return null|bool
     */
    public function attachSpace($space);

    /**
     * Detach space from a user.
     *
     * @param int|\Laravelit\Spaces\Models\Space $space
     * @return int
     */
    public function detachSpace($space);

    /**
     * Detach all spaces from a user.
     *
     * @return int
     */
    public function detachAllSpaces();

 
    /**
     * Get all permissions from spaces.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function spacePermissions();

}
