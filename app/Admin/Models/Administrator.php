<?php
/**
 *
 * User: bing
 * Date: 2020/12/27
 * Time: 15:50
 */

namespace App\Admin\Models;

use App\Admin\Models\Menu;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Administrator extends Authenticatable implements JWTSubject
{
    const DEFAULT_ID = 1;

    protected $table = 'admin_users';

    protected $fillable = ['username', 'password', 'name', 'avatar'];

    protected $hidden = ['password'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * A user has and belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        $pivotTable = config('admin.database.role_users_table');

        $relatedModel = config('admin.database.roles_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'user_id', 'role_id')->withTimestamps();
    }

    /**
     * 判断是否允许查看菜单.
     *
     * @param array|Menu $menu
     *
     * @return bool
     */
    public function canSeeMenu($menu)
    {
        return true;
    }
}
