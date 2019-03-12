<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-12-15
 * Time: 下午12:10
 */

namespace backend\models;

use yii\db\Query;
use common\base\BaseActive;
/**
 * This is the model class for table "menu".
 *
 * @property integer $id Menu id(autoincrement)
 * @property string $name Menu name
 * @property integer $parent Menu parent
 * @property string $route Route for this menu
 * @property integer $order Menu order
 * @property string $data Extra information for this menu
 *
 * @property Menu $menuParent Menu parent
 * @property Menu[] $menus Menu children
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Menu extends BaseActive
{


    public $parent_name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent', 'route', 'data', 'order'], 'default'],
            [['parent'], 'filterParent', 'when' => function() {
                return !$this->isNewRecord;
            }],
            [['order'], 'integer'],
//            [['route'], 'in',
//                'range' => static::getSavedRoutes(),
//                'message' => '未找到路由"{value}".']
        ];
    }

    /**
     * Use to loop detected.
     */
    public function filterParent()
    {
        $parent = $this->parent;
        $db = static::getDb();
        $query = (new Query)->select(['parent'])
            ->from(static::tableName())
            ->where('[[id]]=:id');
        while ($parent) {
            if ($this->id == $parent) {
                $this->addError('parent_name', 'Loop detected.');
                return;
            }
            $parent = $query->params([':id' => $parent])->scalar($db);
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => "Id",
            'name' => "菜单名称",
            'parent' => "上级菜单",
            'parent_name' =>"上级菜单名称",
            'route' => "路由地址",
            'order' => "排序",
            'data' => "扩展数据",
        ];
    }

    /**
     * Get menu parent
     * @return \yii\db\ActiveQuery
     */
    public function getMenuParent()
    {
        return $this->hasOne(Menu::class, ['id' => 'parent']);
    }

    /**
     * Get menu children
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::class, ['parent' => 'id']);
    }
    private static $_routes;

    /**
     * Get saved routes.
     * @return array
     */
    public static function getSavedRoutes()
    {
        if (self::$_routes === null) {
            self::$_routes = [];
            foreach (\Yii::$app->getAuthManager()->getPermissions() as $name => $value) {
                if ($name[0] === '/' && substr($name, -1) != '*') {
                    self::$_routes[] = $name;
                }
            }
        }
        return self::$_routes;
    }

    public static function getMenuSource()
    {
        $tableName = static::tableName();
        return (new Query())
            ->select(['m.id', 'm.name', 'm.route', 'parent_name' => 'p.name'])
            ->from(['m' => $tableName])
            ->leftJoin(['p' => $tableName], '[[m.parent]]=[[p.id]]')
            ->all();
    }


}