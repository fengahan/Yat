<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-11-25
 * Time: 下午11:11
 * 路由管理控制器
 */

namespace backend\controllers;


use backend\models\Route;
use common\base\BaseController;
use common\core\component\AdminConfigsComponent;
use yii\data\ArrayDataProvider;
use yii;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class RouteController extends BaseController
{

    /**
     * @routeName 路由管理
     * @routeDescription 获取已有路由列表
     */
    public function actionAsIndex()
    {
      return  $this->render("as-index");
    }

    /**
     *
     */
    public function actionAvIndex()
    {
        return  $this->render("av-index");
    }

    /**
     * @routeName 路由列表
     * @routeDescription 获得当前数据库的路由
     * @throws
     */
    public function actionAssignedList()
    {

        \Yii::$app->response->format=Response::FORMAT_JSON;
        $routeModel=new Route();
        $routes= $routeModel->getAssignedRoutes();
        $provider = new ArrayDataProvider([
            'allModels' => $routes,
            'pagination' => self::PAGE_CONFIG,

            'sort' => [
                'attributes' => ['name', 'created_at'],
            ],
        ]);
        $routesList=ArrayHelper::toArray($provider->getModels());
        $rs=$r=[];
        foreach ($routesList as $key=>$val){
            $routeData=$val['data'];
            $r['name']=$val['name'];
            $r['route_name']=$routeData['route_name']??"";
            $r['route_description']=$routeData['route_description']??"";
            $r['created_at']=Yii::$app->formatter->asDatetime($val['createdAt']);
            $r['updated_at']=Yii::$app->formatter->asDatetime($val['updatedAt']);
            $rs[]=$r;

        }
        return $this->FormatLayerTable(self::REQUEST_LAY_SUCCESS,'获取成功',$rs,count($routes));
    }
    /**
     *@routeName 可添加路由列表
     *@routeDescription 获取当前项目支持的路由
     */
    public function actionAvailableList()
    {

        \Yii::$app->response->format=Response::FORMAT_JSON;
        $routeModel=new Route();
        $available_routes=$routeModel->getAvaliableRoutes();
        $assigned_routes=$routeModel->getAssignedRoutes();
        $diff=array_diff(array_keys($available_routes),array_keys($assigned_routes));
        $routes=[];
        foreach ($diff as $key=>$value){
            $routes[]=$available_routes[$value];
        }
        $provider = new ArrayDataProvider([
            'allModels' =>$routes,
            'pagination' => self::PAGE_CONFIG,
        ]);
        $data= $provider->getModels();

        return $this->FormatLayerTable(self::REQUEST_LAY_SUCCESS,'获取成功',$data,count($routes));
    }
    /**
     *@routeName 路由详情
     *@routeDescription 获取路由详情
     */
    public function actionView()
    {

        $req=\Yii::$app->request;
        $route_name=$req->get("route_name");
        if (empty($route_name)){
            return $this->FormatArray(self::REQUEST_FAIL,"路由不存在",[]);
        }

        \Yii::$app->response->format=Response::FORMAT_JSON;
        $route_info=Route::findOne(['name'=>$route_name])->toArray();
        if (!empty($route_info)){
            return $this->FormatArray(self::REQUEST_SUCCESS,"获取成功",[]);
        }

        return $this->FormatArray(self::REQUEST_FAIL,"未找到路由",[]);
    }
    /**
     *@routeName 添加路由
     *@routeDescription 添加新路由
     * @throws
     */
    public function actionCreate()
    {
        $req=\Yii::$app->request;
        if ($req->isPost){
            \Yii::$app->response->format=Response::FORMAT_JSON;
            $routeModel=new Route();
            if(  $routeModel->load($req->post(),'')==false || $routeModel->validate()==false){
                return $this->FormatArray(self::REQUEST_FAIL,'添加失败.'.$routeModel->getErrorSummary(false)[0],[]);
            }
            $route_data['route_description']=$req->post('data_description');
            $route_data['route_name']=$req->post('data_name');
            $r=[['route'=>$routeModel->name,'data'=>$route_data]];
            $routeModel->data=$route_data;
            $routeModel->addNew($r);
            return $this->FormatArray(self::REQUEST_SUCCESS,'添加成功',[]);

        } else{
            return $this->render('create');
        }
    }


    /**
     *@routeName 更新路由
     *@routeDescription 更新路由详情
     * @throws
     */
    public function actionUpdate()
    {
        $req=\Yii::$app->request;
        if ($req->isPost) {
            $route_name = $req->post('route_name');
        }else{
            $route_name = $req->get('route_name');
        }
        if (empty($route_name)){
            throw new BadRequestHttpException("路由不存在");

        }
        $routeModel=Route::findOne(['name'=>$route_name]);
        if (empty($routeModel)){
            throw new BadRequestHttpException("未找到路由");
        }
        $route_info=$routeModel->toArray();
        $route_info['data']=unserialize($route_info['data']);
        if ($req->isPost){
            \Yii::$app->response->format=Response::FORMAT_JSON;
            if ($routeModel->load($req->post(),"")){

                $route_info['route_description']=$req->post('data_description');
                $route_info['route_name']=$req->post('data_name');
                $routeModel->data=serialize($route_info);
                if ($routeModel->save()){
                    return $this->FormatArray(self::REQUEST_SUCCESS,'修改成功',[]);
                }else{
                    return $this->FormatArray(self::REQUEST_FAIL,'修改失败.'.$routeModel->getErrorSummary(false)[0],[]);
                }
            }else{
                return $this->FormatArray(self::REQUEST_FAIL,'修改失败.'."系统错误",[]);
            }

        } else{
            return $this->render('update',['route_info'=> $route_info]);
        }
    }


    /**
     *@routeName 添加路由到可用
     *@routeDescription 添加路由到可用
     */
    public function actionAssignRoute()
    {
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $req=\Yii::$app->request;
        $routeModel=new Route();
        $routes=$req->post('routes',[]);
        if ($req->post("all")==1){
            $routes=array_keys($routeModel->getAvaliableRoutes());
        }
        $r=[];
        foreach ($routes as $key=>$val){
            $r[]=['route'=>$val];
        }
        $routeModel->addNew($r);

        return $this->FormatArray(1,"添加成功",[]);
    }

    /**
     *@routeName 移出路由
     *@routeDescription 从可用路由列表移除
     */
    public function actionRemoveRoute()
    {
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $req=\Yii::$app->request;
        $routeModel=new Route();
        $routes=$req->post('routes',[]);
        $routeModel->remove($routes);
        return $this->FormatArray(1,"移除成功",[]);
    }




}