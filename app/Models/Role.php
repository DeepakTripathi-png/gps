<?php

namespace App\Models;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Role extends Model {

    public function permissions() {
        return $this->belongsToMany(Permission::class);

    }
    public static function hasPermission($code = null) {
        $admin = Auth::guard('admin')->user();

        if ($admin->id == 1) {
            return true;
        }

        $permissionsCacheKey = 'Permissions:' . $admin->id;

        $permissions = Cache::remember($permissionsCacheKey, now()->addMinutes(60), function () use ($admin) {
            return $admin->role->permissions->pluck('code')->toArray();
        });

        if (is_array($code)) {
            $permissionsInString = implode(', ', $permissions);
            $codesInString = implode(', ', $code);

            if (str_contains($codesInString, '*')) {
                foreach ($code as $route) {
                    $route = str_replace('*', '', $route);
                    if (str_contains($permissionsInString, $route)) {
                        return true;
                    }
                }
            }

            if (empty(array_intersect($code, $permissions))) {
                return false;
            }

            return true;
        }

        $allPermissionsCacheKey = 'AllPermissions';

        $allPermissions = Cache::remember($allPermissionsCacheKey, now()->addHours(6), function () {
            return Permission::pluck('code')->toArray();
        });
        // echo "<pre>";
        // print_r($allPermissions);
        // print_r($permissions);
        
        // die;
        $routeName = $code ?? request()->route()->getName();
        
      
        if (in_array($routeName, $allPermissions) && !in_array($routeName, $permissions)) {
            Cache::forget($permissionsCacheKey);
            return false;
        }
    
        return true;
    }



    // public static function hasPermission($code = null) {

    //     $admin = Auth::guard('admin')->user();
    //     if ($admin->id == 1) {
    //         return true;
    //     }


    //     $permissions = Cache::get('Permissions');

    //     if (!$permissions) {
    //         $permissions = $admin->role->permissions->pluck('code')->toArray();
    //         Cache::put('Permissions', $permissions);
    //     }


    //     if (is_array($code)) {

    //         $permissionsInString = implode(', ', $permissions);
    //         $codesInString       = implode(', ', $code);

    //         if (str_contains($codesInString, '*')) {
    //             foreach ($code as $route) {
    //                 $route = str_replace('*', '', $route);
    //                 if (str_contains($permissionsInString, $route)) {
    //                     return true;
    //                 }
    //             }
    //         }

    //         if (empty(array_intersect($code, $permissions))) {
    //             return false;
    //         }
    //         return true;
    //     }

    //     $allPermissions = Cache::get('AllPermissions');

    //     if (!$allPermissions) {
    //         $allPermissions = Permission::select('code')->get()->pluck('code')->toArray();
    //         Cache::put('AllPermissions', $allPermissions);
    //     }

    //     $routeName = $code ?? request()->route()->getName();
    //     if (in_array($routeName, $allPermissions) && !in_array($routeName, $permissions)) {
    //         return false;
    //     }

    //     return true;
    // }

    protected static function boot() {
        parent::boot();
        static::saved(function () {
            Cache::forget('Permissions');
        });
    }
}
