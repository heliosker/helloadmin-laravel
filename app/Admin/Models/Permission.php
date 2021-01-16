<?php
/**
 *
 * User: bing
 * Date: 2020/12/27
 * Time: 16:07
 */

namespace App\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'admin_permissions';

    /**
     * @var array
     */
    protected $fillable = ['name', 'slug', 'http_method', 'http_path'];

    /**
     * @var array
     */
    public static $httpMethods = [
        'GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS', 'HEAD',
    ];

    /**
     * @param string $path
     *
     * @return mixed
     */
    public function getHttpPathAttribute($path)
    {
        return explode(',', $path);
    }

    /**
     * @param $path
     * @return string
     */
    public function setHttpPathAttribute($path)
    {
        if (is_array($path)) {
            $path = implode(',', $path);
        }

        return $this->attributes['http_path'] = $path;
    }

    /**
     * @param $method
     */
    public function setHttpMethodAttribute($method)
    {
        if (is_array($method)) {
            $this->attributes['http_method'] = implode(',', $method);
        }
    }

    /**
     * @param $method
     *
     * @return array
     */
    public function getHttpMethodAttribute($method)
    {
        if (is_string($method)) {
            return array_filter(explode(',', $method));
        }

        return $method;
    }

    public static function tree()
    {
        $permission = [];
        if ($menus = self::where('parent_id', 0)->select('id', 'name', 'parent_id')->orderBy('order', 'asc')->get()) {
            foreach ($menus as $key => $item) {
                $permission[$key] = $item;
                $permission[$key]['children'] = self::where('parent_id', $item->id)->select('id', 'name', 'parent_id')->orderBy('order', 'asc')->get();
            }
        }
        return $permission;
    }

}
