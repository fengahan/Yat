<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-11-25
 * Time: 上午10:31
 */
namespace common\base;
use yii\web\Controller;


class BaseController extends Controller
{

    const REQUEST_SUCCESS=1;
    const REQUEST_FAIL=0;
    const REQUEST_LAY_SUCCESS=0;
    const REQUEST_LAY_FAIL=1;

    const PAGE_CONFIG=['pageSizeParam' =>'limit'];

    public $enableCsrfValidation=false;

    /**
     * @param int $code 状态码
     * @param string $msg 错误消息
     * @param array $data 数据
     * @return array
     */
    public function FormatArray($code,$msg,$data){

        return ['status'=>$code,'msg'=>$msg,'data'=>$data];
    }

    /**
     * @param int $code 状态码
     * @param array $data 数据 请按照layer数组格式
     * @param string $msg 消息内容
     * @param int $count 列表长度
     * @return array
     */

    public function FormatLayerTable(int $code , string $msg, array $data,int $count){

        return ['code'=>$code,'msg'=>$msg,'data'=>$data,'count'=>$count];

    }
}