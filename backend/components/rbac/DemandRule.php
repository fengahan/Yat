<?php
/**
 * Created by PhpStorm.
 * User: hanfeng
 * Date: 2017/12/14
 * Time: 下午4:56
 */

namespace backend\components\rbac;
use backend\models\AdminUser;
use common\models\Demand;
use Yii;
use yii\rbac\Rule;

class DemandRule extends Rule
{
    /***
     * @var string
     *此处为测试代码请删除!!!
     */
    public $name = '更新个人的需求';
    public $model;
    public function execute($user, $item, $params)
    {

        return true;
 
    }
}