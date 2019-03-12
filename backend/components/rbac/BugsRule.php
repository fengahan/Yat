<?php
/**
 * Created by PhpStorm.
 * User: hanfeng
 * Date: 2017/12/13
 * Time: 上午11:20
 */

namespace backend\components\rbac;
use backend\models\AdminUser;
use common\models\Bugs;
use Yii;
use yii\rbac\Rule;

class BugsRule extends Rule
{
    /***
     * @var string
     *此处为测试代码请删除!!!
     */
    public $name = '更新BUG';
    public $model;
    public function execute($user, $item, $params)
    {

       return true;

    }
}