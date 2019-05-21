<?php
namespace backend\controllers;

use common\base\BaseController;
use backend\models\AdminUser;
use common\core\helper\MenuHelper;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use yii\web\Response;
use backend\models\Route;
/**
 * Site controller
 */
class SiteController extends BaseController
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha'=>[
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'backColor'=>0x008080,//背景颜色
                'maxLength' => 5, //最大显示个数
                'minLength' => 5,//最少显示个数
                'padding' => 5,//间距
                'height'=>37,//高度
                'width' => 90,  //宽度
                'foreColor'=>0x00FFFF,     //字体颜色
                'offset'=>4,        //设置字符偏移量 有效果
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $header_nav=$this->getMenuList();
        foreach ($header_nav as $key=>&$val){
            unset($val["children"]);
        }

        return $this->renderPartial('index',['header_nav'=>$header_nav]);
    }

    /**
     * Login action.
     *
     */
    public function actionLogin()
    {
        $this->layout=false;
        $data=[];
        $model = new LoginForm();
        Yii::$app->user->logout();
        if (Yii::$app->request->getIsAjax()){
            Yii::$app->response->format=Response::FORMAT_JSON;
            if (!Yii::$app->user->isGuest) {
                $data["url"]=Yii::$app->getHomeUrl();
                return $this->FormatArray(self::REQUEST_SUCCESS,"您已经登录",$data);
            }else if($model->load(Yii::$app->request->post(),"") && $model->login()){
                $defaultUrl=Url::to(['/site/index']);
                $AdminUser=AdminUser::findOne(Yii::$app->user->identity->getId());
                $session= Yii::$app->session;
                $session->set("last_login_time",$AdminUser->last_login_at);
                $AdminUser->last_login_at=time();
                $AdminUser->save(false);
                $data["url"]=Yii::$app->getUser()->getReturnUrl($defaultUrl);
                return $this->FormatArray(self::REQUEST_SUCCESS,"登录成功",$data);
            }else{
                $msg=$model->getErrorSummary(false)[0];
                return $this->FormatArray(self::REQUEST_FAIL,$msg,$data);
            }
        }else{
            $model->password = '';
            return $this->renderPartial('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @return string
     */
    public function actionMain(){

        return $this->render("main");
    }


    /**
     *
     *
     */
    public function actionLeftNav()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $data=$this->getMenuList();

        return $this->FormatArray(self::REQUEST_SUCCESS,"获取成功",$data);
    }
    protected function getMenuList(){

        $callback = function($menu){
            $data = json_decode($menu['data'], true);
            $items = $menu['children'];
            $return = [
                'title' => $menu['name'],
                'href' => [$menu['route']],
                'icon'=>$data['icon'],
            ];
            //没配置图标的显示默认图标，默认图标大家可以自己随便修改
            (!isset($return['icon']) || !$return['icon']) && $return['icon'] = 'layui-icon-star-fill';
            $items && $return['children'] = $items;

            return $return;
        };
        $menuData=MenuHelper::getAssignedMenu(Yii::$app->user->id,null,$callback,true);
        $list=$this->normalizeItems($menuData);
        return $list;

    }
    /**
     * Logout action.
     *
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->response->format=Response::FORMAT_JSON;
        return $this->FormatArray(self::REQUEST_SUCCESS,"退出帐号成功",['url'=>Url::to(['/site/login'])]);
    }

    /**
     * @param $items
     * @return array
     */
    protected function normalizeItems($items)
    {
        foreach ($items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
            if (!isset($item['title'])) {
                $item['title'] = '';
            }
            $items[$i]['title'] = $item['title'];
            $items[$i]['icon'] = isset($item['icon']) ? $item['icon'] : '';
            $items[$i]['href']=$item['href'][0]??'';
            $items[$i]['spread']=false;
            if (isset($item['children'])) {
                $items[$i]['children'] = $this->normalizeItems($item['children']);
                if (empty($items[$i]['children'])) {
                    unset($items[$i]['children']);
                    if (!isset($item['href'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }

        }
        return array_values($items);
    }
}
