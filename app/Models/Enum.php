<?php
/**
 * Created by PhpStorm.
 * User: pavel
 * Date: 26.09.15
 * Time: 6:23
 */

namespace Models;

use Illuminate\Database\Eloquent\Collection;
class Enum extends BaseModel
{
    protected $table = 'enum';

    /**
     * @var array
     */
    protected static $_cache = [];

    /**
     * @var bool
     */
    protected static $_useCache = true;


    /**
     * Извлекает справочник по пути к нему, возвращает объект типа enum или массив enum,
     * если была переданна `*`
     * @param $path
     * @return mixed
     */
    public static function get($path) {
        if (empty(self::$_cache[$path])) {
            $result = self::_find(explode('.', $path));
            if (self::$_useCache) {
                self::$_cache[$path] = $result;
            }
        } else {
            $result = self::$_cache[$path];
        }
        return $result;
    }

    /**
     * Рекурсивно извлекает данные по справочнику
     * @param array $path
     * @param int $offset
     * @param Enum $parent
     * @throws \Exception
     * @return Enum
     */
    protected static function _find(array $path, $offset = 0, $parent = null)
    {
        if ($path[$offset] === '*') {  // все дети данного parent-а
            $res = is_null($parent)
                ? static::whereNull('parent')->get()
                : static::where('parent', '=', $parent->id)->get();

            return $res;
        } else {  // ребенок по sys_name
            $target = static::where(function($q) use ($path, $offset
                                                        , $parent) {
                $q->where('sys_name', '=', $path[$offset]);
                is_null($parent)
                    ? $q->whereNull('parent')
                    : $q->where('parent', '=', $parent->id);
            })->get();
            $target = $target->first();
        }

        // Если нет такого пути, выкиним exception
        if (empty($target)) {
            throw new \Exception('Cat`n find enum field. Be sure the path is correct. '
                . $offset . ' parent: ' . ' path: ' . $path[$offset]);
        }

        if (count($path)-1 === $offset) {
            return $target;
        } else {
            // рекурсия
            return self::_find($path, $offset + 1, $target);
        }
    }

} 