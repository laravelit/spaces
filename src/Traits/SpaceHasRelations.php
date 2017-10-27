<?php

namespace Laravelit\Spaces\Traits;

trait SpaceHasRelations
{
    /**
     * Space belongs to many permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(config('roles.models.permission'))->withTimestamps();
    }
    
    /**
     * Space belongs to many profiles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function profiles()
    {
    	return $this->belongsToMany(config('profiles.models.profile'))->withTimestamps();
    }
    
    /**
     * Space belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
    	return $this->belongsToMany(config('roles.models.role'))->withTimestamps();
    }

    /**
     * Space belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(config('auth.model'))->withTimestamps();
    }

    /**
     * Attach role to a space.
     *
     * @param int|\Laravelit\Spaces\Models\Permission $role
     * @return int|bool
     */
    public function attachRole($role)
    {
        return (!$this->roles()->get()->contains($role)) ? $this->roles()->attach($role) : true;
    }

    /**
     * Detach role from a space.
     *
     * @param int|\Laravelit\Spaces\Models\Role $role
     * @return int
     */
    public function detachRole($role)
    {
        return $this->roles()->detach($role);
    }

    /**
     * Detach all roles.
     *
     * @return int
     */
    public function detachAllRoles()
    {
        return $this->roles()->detach();
    }
    
    /**
     * Attach permission to a space.
     *
     * @param int|\Laravelit\Spaces\Models\Permission $permission
     * @return int|bool
     */
    public function attachPermission($permission)
    {
    	return (!$this->permissions()->get()->contains($permission)) ? $this->permissions()->attach($permission) : true;
    }
    
    /**
     * Detach permission from a space.
     *
     * @param int|\Laravelit\Spaces\Models\Permission $permission
     * @return int
     */
    public function detachPermission($permission)
    {
    	return $this->permissions()->detach($permission);
    }
    
    /**
     * Detach all permissions.
     *
     * @return int
     */
    public function detachAllPermissions()
    {
    	return $this->permissions()->detach();
    }
}
