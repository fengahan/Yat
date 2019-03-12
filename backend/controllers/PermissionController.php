<?php
/**
 *
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-11-27
 * Time: 上午11:43
 * 角色
 */

namespace backend\controllers;

use yii;
use backend\models\AuthItem;
use backend\models\search\AuthItemSearch;
use common\base\BaseController;
use yii\rbac\Item;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
/**
 * Class PermissionController
 * @package backend\controllers
 * @property $type int
 */
class PermissionController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                    'assign' => ['post'],
                    'remove' => ['post'],
                ],
            ],
        ];
    }
    /**
     * @routeName 权限管理
     * @routeDescription 权限管理
     */
    public function actionIndex()
    {

       return $this->render('index');

    }


    /**
     * @routeName 权限列表
     * @routeDescription 所有权限
     * @throws
     * @return array
     */
    public function actionList()
    {
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $searchModel = new AuthItemSearch(['type' => $this->type]);
        $dataProvider = $searchModel->search(\Yii::$app->request->getQueryParams());
        $data=array_values($dataProvider->getModels());
        $data= ArrayHelper::toArray($data);
        foreach ($data as $key=>$value){
            $data[$key]['createdAt']= Yii::$app->formatter->asDatetime($value['createdAt']);
            $data[$key]['updatedAt']= Yii::$app->formatter->asDatetime($value['updatedAt']);

        }
        return $this->FormatLayerTable(self::REQUEST_LAY_SUCCESS,"获取成功",$data,$dataProvider->totalCount);
    }

    /**
     * 所有权限
     * @routeName 所有权限
     * @routeDescription 所有可以分配到权限
     * @return array
     * @throws
     */
    public function actionPermissionAll()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $per_name=Yii::$app->request->get('per_name');
        $assModel= $this->findModel($per_name);
        $p=$assModel->getItems();
        //过滤重复添加添加权限
        $assigned=array_keys($p['assigned']);
        $assigned[]=$per_name;
        $manager = Yii::$app->getAuthManager();

        $perModel= Yii::$app->authManager->getPermissions();
        $_data=array_values(ArrayHelper::toArray($perModel));
        $data=[];
        foreach ($_data as $key=>$value){
                $i=0;
                foreach ($manager->getChildren($value['name']) as $item) {
                    $i++;
                }
                if (!in_array($value['name'],$assigned) && $i<1){
                    $v=[];
                    $v['name']=$value['name'];
                    $v['ext_name']=!empty($value['data']['route_name'])?$value['data']['route_name']:$value['name'];
                    $v['description']=$value['description']??$value['data']['route_description']??'';
                    $v['createdAt']=Yii::$app->formatter->asDatetime($value['createdAt']);
                    $v['updatedAt']=Yii::$app->formatter->asDatetime($value['updatedAt']);
                    $v['type']=strncmp($value['name'], '/', 1) === 0?'路由':'权限';
                    $data[]=$v;
            }
        }
      return $this->FormatLayerTable(self::REQUEST_LAY_SUCCESS,"获取成功",$data,0);
    }

    /**
     * 已经拥有的权限
     * @routeName 已有权限
     * @routeDescription 所拥有的权限列表
     * @return array
     * @throws
     */
    public function actionPermissionAss()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $per_name=Yii::$app->request->get('per_name');
        $perModel= $this->findModel($per_name);
        $p=$perModel->getItems();
        $assigned=$p['assigned'];
        unset($assigned[$per_name]);

        $data=[];
        $perModel= Yii::$app->authManager->getPermissions();
        $_data=array_values(ArrayHelper::toArray($perModel));
        foreach ($assigned as $k=>$val){
            foreach ($_data as $key=>$value){
                if ($k==$value['name']){
                    $v['name']=$value['name'];
                    $v['ext_name']=!empty($value['data']['route_name'])?$value['data']['route_name']:$value['name'];
                    $v['description']= !empty($value['description'])?$value['description']:$value['data']['route_description'];
                    $v['createdAt']= Yii::$app->formatter->asDatetime($value['createdAt']);
                    $v['updatedAt']= Yii::$app->formatter->asDatetime($value['updatedAt']);
                    $v['type']=strncmp($value['name'], '/', 1) === 0?'路由':'权限';
                    $data[]=$v;
                }
            }
        }

        return $this->FormatLayerTable(self::REQUEST_LAY_SUCCESS,"获取成功",$data,0);
    }
    /**
     * @routeName 创建权限
     * @routeDescription 创建管理员权限
     * @return string|Response|array
     */
    public function actionCreate()
    {
        $model = new AuthItem(null);
        $model->type = $this->type;
        $req=Yii::$app->request;
        if ($req->isPost){
            Yii::$app->response->format=Response::FORMAT_JSON;
            if ($model->load($req->post(),'') && $model->save()) {
                return $this->FormatArray(self::REQUEST_SUCCESS,'添加成功',[]);
            } else {
                return $this->FormatArray(self::REQUEST_FAIL,'添加失败,'.$model->getErrorSummary(false)[0],[]);
            }
        } else {
            return $this->render('create');
        }

    }
    /**
     * @routeName 分配路由
     * @routeDescription 分配路由到权限
     * @return array
     * @throws
     */
    public function actionAssign()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $req=Yii::$app->request;
        $id= $req->post('per_name');
        $items =  $req->post('items', []);
        $model = $this->findModel($id);
        $success = $model->addChildren($items);
        if ($success>0){
            return $this->FormatArray(self::REQUEST_SUCCESS,'添加成功',[]);
        }else{
            return $this->FormatArray(self::REQUEST_FAIL,'添加失败',[]);
        }
    }

    /**
     * 移除 items
     * @routeName 移除权限
     * @routeDescription 移除权限的其他权限或者路由
     * @return array
     * @throws
     */
    public function actionRemove()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $req=Yii::$app->request;
        $id= $req->post('per_name');
        $items = $req->post('items', []);
        $perModel = $this->findModel($id);
        $success = $perModel->removeChildren($items);
        if ($success>0){
            return $this->FormatArray(self::REQUEST_SUCCESS,'移除成功',[]);
        }else{
            return $this->FormatArray(self::REQUEST_FAIL,'移除失败',[]);
        }
    }

    /**
     * @routeName 更新权限
     * @routeDescription 更新权限
     * @throws
     * @return mixed
     */

    public function actionUpdate()
    {
        $req=Yii::$app->request;
        $name=$req->get("per_name");
        if ($req->isPost) {
            $name = $req->post("per_name");
        }
        $perModel = $this->findModel($name);
        $perModel->type = $this->type;
        if ($req->isPost){
            Yii::$app->response->format=Response::FORMAT_JSON;
            if ($perModel->load($req->post(),'') && $perModel->save()) {
                return $this->FormatArray(self::REQUEST_SUCCESS,'修改成功',[]);
            } else {
                return $this->FormatArray(self::REQUEST_FAIL,'修改失败,'.$perModel->getErrorSummary(false)[0],[]);
            }
        } else {
            $per_info= $perModel->toArray();

            return $this->render('update',['per_info'=>$per_info]);
        }
    }

    /**
     * @routeName 删除权限
     * @routeDescription 删除指定权限
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionDelete()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $req=Yii::$app->request;
        $id=$req->post("per_name");
        $perModel = $this->findModel($id);
        Yii::$app->getAuthManager()->remove($perModel->item);
        return $this->FormatArray(self::REQUEST_SUCCESS,'删除成功',[]);
    }

    /**
     * @routeName 查看权限
     * @routeDescription 查看权限详情
     * @return mixed
     * @throws
     */

    public function actionView()
    {
        $req=Yii::$app->request;
        $name=$req->get("per_name");
        $perModel=$this->findModel($name);
        $per_info=$perModel->toArray();
        return $this->render('view',['per_info'=>$per_info]);
    }

    public function getType()
    {

        return Item::TYPE_PERMISSION;
    }


    /**
     * @param string $id
     * @return AuthItem
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        $auth = Yii::$app->getAuthManager();
        $item = $auth->getPermission($id);
        if ($item) {
            return new AuthItem($item);
        } else {
            throw new NotFoundHttpException('权限不存在.'.$id);
        }
    }
}