<?php

namespace Foushua\Authorization\Traits;

use Foushua\Authorization\Role;
use Illuminate\Support\Facades\Config;

trait Authorizable
{
    /**
     * Returns the role attached to the user.
     *
     * @return mixed
     */
    public function role()
    {
        return $this->belongsTo(Config::get('authorization.models.role'), 'role_id');
    }

    /**
     * Check if user has specified role.
     *
     * @param $role
     *
     * @return bool
     */
    public function hasRole($role)
    {
        if ($this->role === null) return false;
        if (is_string($role)) return $this->role->name === $role;
        if (is_integer($role)) return $this->role->id === $role;
        if ($role instanceof Role) return $this->role->id === $role->id;

        return false;
    }

    /**
     * Get role level of user.
     *
     * @return int
     */
    public function level()
    {
        return $this->role->level ?? 0;
    }

    /**
     * Set user's role.
     * @param int|Role $role
     *
     * @return mixed
     */
    public function setRole($role)
    {
        return $this->forceFill([
            'role_id' => $role instanceof Role ? $role->id : $role
        ])->save();
    }
}
