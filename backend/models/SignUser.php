<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-12-27
 * Time: 下午8:36
 */

namespace backend\models;

use yii\behaviors\TimestampBehavior;
class SignUser extends AdminUser
{

    public $password;
    public function behaviors()
    {
        parent::behaviors();
        return [
            TimestampBehavior::class,
        ];

    }
    public function rules()
    {

        return [

            [['username','email','nickname'],'required'],

            ['password','required','on'=>self::OP_INSERT],//新增管理员必须输入密码
            ['status','required','on'=>self::OP_UPDATE],//新增管理员必须输入密码
            ['password','string','length'=>[8,14]],
            ['password','filter','filter'=>function($value){
                if ($this->password !=null){
                    $this->setPassword($value);
                    $this->generateAuthKey();
                }
            }]
        ];
    }


}