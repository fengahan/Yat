<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-11-25
 * Time: 下午11:10
 * 菜单管理控制器
 */

namespace backend\controllers;


use backend\models\Menu;
use backend\models\Route;
use backend\models\search\MenuSearch;
use common\base\BaseController;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Response;

/**
 * Class MenuController
 * @package backend\controllers
 */
class MenuController extends BaseController
{

    /**
     * @routeName 菜单管理
     */
    public function actionIndex()
    {
       return $this->render('index');
    }
    /**
     * @routeName 菜单列表
     * @routeDescription 菜单列表
     */
    public function actionMenuList(){
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $searchModel=new MenuSearch();
        $dataProvider=$searchModel->search(\Yii::$app->request->queryParams);
        $menuList=$dataProvider->getModels();
        $menu_list=ArrayHelper::toArray($menuList);
        foreach ( $menu_list as $key=>$value){
            if (isset($value['data'])){
                $menu_list[$key]['icon']=json_decode($value['data'],true)['icon']??"";
            }
        }
        return  $this->FormatLayerTable(0,'获取成功', $menu_list,$dataProvider->getTotalCount());
    }

    /**
     * @routeName 菜单详情
     * @routeDescription 获取菜单详情
     */
    public function actionView()
    {
        //Todo
    }

    /**
     * @routeName 更新菜单
     * @routeDescription 更新菜单详情
     * @throws
     */
    public function actionUpdate()
    {
        $req=\Yii::$app->request;
        $menu_id=$req->get('menu_id');
        if($req->isPost){
            $menu_id=$req->post('menu_id');
        }
        $menuInfo=Menu::findOne(['id'=>$menu_id]);
        if (empty($menuInfo)){
            throw new BadRequestHttpException('未找到菜单');
        }
        $menu_info=ArrayHelper::toArray($menuInfo);
        $menu_info_data=json_decode($menu_info['data'],true);
        if ($req->isPost){
            \Yii::$app->response->format=Response::FORMAT_JSON;
            $menuInfo->load($req->post(),'');
            $menuInfo->data=json_encode(['icon'=>$req->post('icon')]);
            if ($menuInfo->save()){
                return $this->FormatArray(self::REQUEST_SUCCESS,'修改成功',[]);
            }else{
                return $this->FormatArray(self::REQUEST_FAIL,'修改失败'.$menuInfo->getErrorSummary(false)[0],[]);
            }
        } else {
            $routeModel=new Route();
            $route_list=ArrayHelper::toArray($routeModel->getAssignedRoutes());
            return $this->render('update',['menu_info'=>$menu_info,'route_list'=>$route_list,'menu_info_data'=>$menu_info_data]);
        }
    }

    /**
     * @routeName 删除菜单
     * @routeDescription 删除菜单
     */
    public function actionDelete()
    {
        $req=\Yii::$app->request;
        \Yii::$app->response->format=Response::FORMAT_JSON;

        $menu_id=$req->post('menu_id');
        if (empty($menu_id)){
            return $this->FormatArray(self::REQUEST_FAIL,'删除失败',[]);
        }
        $menuInfo=Menu::findOne(['id'=>$menu_id]);
        if (empty($menuInfo)){
            return $this->FormatArray(self::REQUEST_FAIL,'删除失败',[]);
        }elseif (Menu::findOne(['parent'=>$menuInfo->id])){
                return $this->FormatArray(self::REQUEST_FAIL,'删除失败,无法删除子分类',[]);
        } elseif($menuInfo->delete()){
            return $this->FormatArray(self::REQUEST_SUCCESS,'删除成功',[]);
        }else{
            return $this->FormatArray(self::REQUEST_FAIL,'删除失败,请联系管理员',[]);
        }

    }

    /**
     * @routeName 添加菜单
     * @routeDescription 添加新的菜单
     * @throws
     */
    public function actionCreate()
    {
        $req=\Yii::$app->request;
        $parent_id=$req->get('parent_id');
        if($req->isPost){
            $parent_id=$req->post('parent_id');
        }
        $menuModel=new Menu();
        $parent_info=Menu::find()->where(['id'=>$parent_id])->asArray()->one();
        if ($req->isPost){
            \Yii::$app->response->format=Response::FORMAT_JSON;
            $menuModel->load($req->post(),'');
            $menuModel->parent=$parent_info['id']??'';
            $menuModel->data=json_encode(['icon'=>$req->post('icon')]);
            if ($menuModel->save()){
                return $this->FormatArray(self::REQUEST_SUCCESS,'添加成功',[]);
            }else{
                return $this->FormatArray(self::REQUEST_FAIL,'添加失败'.$menuModel->getErrorSummary(false)[0],[]);
            }
        } else {
            $routeModel=new Route();
            $route_list=ArrayHelper::toArray($routeModel->getAssignedRoutes());
            return $this->render('create',['parent_info'=>$parent_info,'route_list'=>$route_list]);
        }

    }

}