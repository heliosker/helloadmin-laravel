<?php
/**
 *
 * User: bing
 * Date: 2020/12/27
 * Time: 15:53
 */

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Menu
 * @package App\Admin\Models
 */
class Menu extends Model
{

    protected $table = 'admin_menu';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'order', 'title', 'icon', 'uri', 'extension', 'show'];

    /**
     * A Menu belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        $pivotTable = config('admin.database.role_menu_table');

        $relatedModel = config('admin.database.roles_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'menu_id', 'role_id')->withTimestamps();
    }

    public function permissions(): BelongsToMany
    {
        $pivotTable = config('admin.database.permission_menu_table');

        $relatedModel = config('admin.database.permissions_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'menu_id', 'permission_id')->withTimestamps();
    }

    /**
     * 菜单树
     * @return array
     */
    static public function tree()
    {
        $list = [];
        if ($menus = self::where('parent_id', 0)->where('show', 1)->select('id', 'title', 'uri', 'icon', 'parent_id')->orderBy('order', 'asc')->get()) {
            foreach ($menus as $key => $item) {
                $list[$key] = $item;
                $list[$key]['children'] = self::where('parent_id', $item->id)->select('id', 'title', 'uri', 'icon', 'parent_id')->orderBy('order', 'asc')->get();
            }
        }
        return $list;
    }


}
