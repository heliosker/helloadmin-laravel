<?php
/**
 *
 * User: bing
 * Date: 2020/12/27
 * Time: 16:07
 */

namespace App\Admin\Models;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $table = 'admin_roles';

    const ADMINISTRATOR = 'administrator';

    const ADMINISTRATOR_ID = 1;

    protected $fillable = ['name', 'slug'];

    /**
     * A role belongs to many users.
     *
     * @return BelongsToMany
     */
    public function administrators(): BelongsToMany
    {
        $pivotTable = config('admin.database.role_users_table');
        $relatedModel = config('admin.database.users_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'role_id', 'user_id');
    }

    /**
     * A role belongs to many permissions.
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        $pivotTable = config('admin.database.role_permissions_table');
        $relatedModel = config('admin.database.permissions_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'role_id', 'permission_id')->withTimestamps();
    }

    /**
     * Check user has permission.
     *
     * @param $permission
     *
     * @return bool
     */
    public function can(?string $permission): bool
    {
        return $this->permissions()->where('slug', $permission)->exists();
    }

    /**
     * Check user has no permission.
     *
     * @param $permission
     *
     * @return bool
     */
    public function cannot(?string $permission): bool
    {
        return ! $this->can($permission);
    }

    /**
     * Get id of the permission by id.
     *
     * @param array $roleIds
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getPermissionId(array $roleIds)
    {
        if (! $roleIds) {
            return collect();
        }
        $related = config('admin.database.role_permissions_table');

        $model = new static();
        $keyName = $model->getKeyName();

        return $model->newQuery()
            ->leftJoin($related, $keyName, '=', 'role_id')
            ->whereIn($keyName, $roleIds)
            ->get(['permission_id', 'role_id'])
            ->groupBy('role_id')
            ->map(function ($v) {
                $v = $v instanceof Arrayable ? $v->toArray() : $v;

                return array_column($v, 'permission_id');
            });
    }

    /**
     * @param string $slug
     *
     * @return bool
     */
    public static function isAdministrator(?string $slug)
    {
        return $slug === static::ADMINISTRATOR;
    }


}
