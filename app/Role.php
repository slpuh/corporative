<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    public function users() {
        return $this->belongsToMany('Corp\User', 'role_users');
    }

    public function permissions() {
        return $this->belongsToMany('Corp\Permission', 'permission_roles');
    }

    public function hasPermission($name, $require = false) {
        if (is_array($name)) {
            foreach ($name as $permissionName) {
                $hasPermission = $this->hasPermission($permissionName);
                if ($hasPermission && !$require) {
                    return true;
                } else if (!$hasPermission && $require) {
                    return false;
                }
            }
            return $require;
        } else {
            foreach ($this->permissions as $permission) {

                if ($permission->name == $name) {
                    return true;
                }
            }
        }
    }

    public function savePermissions($inputPermissions) {
        if (!empty($inputPermissions)) {
            $this->permissions()->sync($inputPermissions);
        } else {
            $this->permissions()->detach();
        }
        return true;
    }

}
