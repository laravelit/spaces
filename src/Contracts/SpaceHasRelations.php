<?php

namespace Laravelit\Roles\Contracts;

interface SpaceHasRelations
{
    /**
     * Space belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles();

    /**
     * Space belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users();
    
    /**
     * Space belongs to many profiles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function profiles();
    
    /**
     * Space belongs to many permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions();
    
    /**
     * Attach role to a space.
     *
     * @param int|\Laravelit\Roles\Models\Role $role
     * @return null|bool
     */
    public function attachRole($role);
    
    /**
     * Detach role from a space.
     *
     * @param int|\Laravelit\Roles\Models\Role $role
     * @return int
     */
    public function detachRole($role);
    
    /**
     * Detach all roles from a space.
     *
     * @return int
     */
    public function detachAllRoles();
    
    /**
     * Attach permission to a space.
     *
     * @param int|\Laravelit\Spaces\Models\Permission $permission
     * @return null|bool
     */
    public function attachPermission($permission);
    
    /**
     * Detach permission from a space.
     *
     * @param int|\Laravelit\Spaces\Models\Permission $permission
     * @return int
     */
    public function detachPermission($permission);
    
    /**
     * Detach all permissions from a space.
     *
     * @return int
     */
    public function detachAllPermissions();
}
