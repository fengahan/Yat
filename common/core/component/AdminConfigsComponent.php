<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-12-9
 * Time: 下午5:38
 */

namespace common\core\component;

use yii\di\Instance;
use yii\caching\Cache;
use yii;

class AdminConfigsComponent extends yii\base\BaseObject
{

    /**
     * @var Cache
     */
    public $cache;

    const CACHE_TAG='AdminAuthCache';
    /**
     * @var int 缓存时间
     */
    public $cacheDuration;

    /**
     * @var array
     */
    public $options=[];
    /**
     * @var self Instance of self
     */
    private static $_instance;

    private static $_classes = [
        'cache' => 'yii\caching\Cache',
    ];

    public function init()
    {
        foreach (self::$_classes as $key => $class) {
            try {
                $this->{$key} = empty($key) ? null : Instance::ensure($key, $class);
            } catch (\Exception $exc) {
                $this->{$key} = null;
                Yii::error($exc->getMessage());
            }
        }
    }

    /**
     * @return AdminConfigsComponent|object
     * @throws yii\base\InvalidConfigException
     */
    public static function instance(){
        if (empty(self::$_instance)){
            return self::$_instance=Yii::createObject(static::class);
        }
        return self::$_instance;

    }

    /**
     * @return Cache
     * @throws yii\base\InvalidConfigException
     */

    public static function cache(){

        return static::instance()->cache;
    }

    /**
     * @param $name string 属性
     * @param $arguments string|array|null 参数
     * @return mixed|null
     * @throws yii\base\InvalidConfigException
     */

    public static function __callStatic($name, $arguments)
    {
        $instance = static::instance();
        if ($instance->hasProperty($name)) {
            return $instance->$name;
        } else {
            if (count($arguments)) {
                $instance->options[$name] = reset($arguments);
                return null;
            } else {
                return array_key_exists($name, $instance->options) ? $instance->options[$name] : null;
            }
        }
    }




}