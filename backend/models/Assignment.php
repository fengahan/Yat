<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-12-27
 * Time: 下午7:50
 */

namespace backend\models;


use common\base\BaseModel;
use Yii;
class Assignment extends BaseModel
{


    public $id;
    /**
     * @var \yii\web\IdentityInterface User
     */
    public $user;


    public function __construct($id, $user = null, $config = array())
    {
        $this->id = $id;
        $this->user = $user;
        parent::__construct($config);
    }

    /**
     * Grands a roles from a user.
     * @param array $items
     * @return  int
     */
    public function assign($items)
    {
        $manager = Yii::$app->getAuthManager();
        $success = 0;
        foreach ($items as $name) {
            try {
                $item = $manager->getRole($name);
                $item = $item ? : $manager->getPermission($name);
                $manager->assign($item, $this->id);
                $success++;
            } catch (\Exception $exc) {
                Yii::error($exc->getMessage(), __METHOD__);
            }
        }

        return $success;
    }

    /**
     * Revokes a roles from a user.
     * @param array $items
     * @return integer number of successful revoke
     */
    public function revoke($items)
    {
        $manager = Yii::$app->getAuthManager();
        $success = 0;
        foreach ($items as $name) {
            try {
                $item = $manager->getRole($name);
                $item = $item ? : $manager->getPermission($name);
                $manager->revoke($item, $this->id);
                $success++;
            } catch (\Exception $exc) {
                Yii::error($exc->getMessage(), __METHOD__);
            }
        }

        return $success;
    }

    /**
     * Get all avaliable and assigned roles/permission
     * @return array
     */
    public function getItems()
    {
        $manager = Yii::$app->getAuthManager();
        $avaliable = [];
        foreach (array_keys($manager->getRoles()) as $name) {
            $avaliable[$name] = 'role';
        }

        foreach (array_keys($manager->getPermissions()) as $name) {
            if ($name[0] != '/') {
                $avaliable[$name] = 'permission';
            }
        }

        $assigned = [];
        foreach ($manager->getAssignments($this->id) as $item) {
            $assigned[$item->roleName] = $avaliable[$item->roleName];
            unset($avaliable[$item->roleName]);
        }

        return[
            'avaliable' => $avaliable,
            'assigned' => $assigned
        ];
    }

    /**
     * 获取所有权限和角色
     * @return array
     */
    public static function getAllItems()
    {

        $manager = Yii::$app->getAuthManager();
        $avaliable = [];
        foreach (array_keys($manager->getRoles()) as $name) {
            $avaliable['role'][]=$name;
        }
        foreach (array_keys($manager->getPermissions()) as $name) {
            if ($name[0] != '/') {
                $avaliable['permission'][]=$name;
            }
        }

        return $avaliable;
    }
    /**
     * 获取已有权限和角色
     * @return array
     */
    public function getAssignItems(){
        $manager = Yii::$app->getAuthManager();
        $avaliable = [];
        foreach (array_keys($manager->getRoles()) as $name) {
            $avaliable[$name] = 'role';
        }

        foreach (array_keys($manager->getPermissions()) as $name) {
            if ($name[0] != '/') {
                $avaliable[$name] = 'permission';
            }
        }
        $assign=[];
        foreach ($manager->getAssignments($this->id) as $item) {

            if ($avaliable[$item->roleName]=='role'){
                $assign['role'][]=$item->roleName;
            }elseif ($avaliable[$item->roleName]=='permission'){
                $assign['permission'][]=$item->roleName;
            }
        }

        return $assign;

    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        if ($this->user) {
            return $this->user->$name;
        }
        return null;
    }
}