<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-11-25
 * Time: 上午10:31
 */
namespace common\base;
use Codeception\Util\HttpCode;
use yii\helpers\Url;
use yii\web\Controller;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class BaseController extends Controller
{

    const REQUEST_SUCCESS=1;
    const REQUEST_FAIL=0;
    const REQUEST_LAY_SUCCESS=0;
    const REQUEST_LAY_FAIL=1;
    const REQUEST_UN_AUTH=-1;
    const PAGE_CONFIG=['pageSizeParam' =>'limit'];

    public $enableCsrfValidation=false;

    /**
     * @param $action
     * @return bool
     * @throws BadRequestHttpException
     * @throws ForbiddenHttpException
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if ($this->module->id=="app-backend") {
            $route=$this->getRoute();
            $ing_list=['site/login','site/captcha','site/error'];
            if (Yii::$app->user->isGuest){
                if (!in_array($route,$ing_list)){
                    if (Yii::$app->request->isAjax){
                        Yii::$app->response->format=Response::FORMAT_JSON;
                        Yii::$app->response->statusCode=HttpCode::UNAUTHORIZED;
                        Yii::$app->response->data=$this->FormatArray(self::REQUEST_UN_AUTH,'请重新登陆',"");
                        return false;
                    }else{
                        $this->redirect(['site/login']);
                        return false;
                    }
                }
            }else{//验证权限
                array_push($ing_list,'site/left-nav');

                if (in_array($route,$ing_list)){
                    return true;
                }
                if (Yii::$app->user->can('/'.$route)==false && !empty($ing_list)){
                    if (Yii::$app->request->isAjax){
                        Yii::$app->response->format=Response::FORMAT_JSON;
                        Yii::$app->response->statusCode=HttpCode::FORBIDDEN;
                        Yii::$app->response->data=$this->FormatArray(self::REQUEST_FAIL,'无权限操作',"");
                        return false;
                    }else{
                        throw new ForbiddenHttpException("无权限操作");
                    }
                }
                return true;
            }
            return true;
        }
        return true;
    }

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