<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-11-25
 * Time: 上午10:36
 */

namespace common\base;

use yii\db\ActiveRecord;
class BaseActive extends ActiveRecord
{

    const PAGE_CONFIG=['pageSizeParam' =>'limit','pageSize'=>20];

}