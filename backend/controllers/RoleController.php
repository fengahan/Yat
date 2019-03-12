<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-12-9
 * Time: 下午4:56
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
 * Class RoleController
 * @package backend\controllers
 * @property $type int
 */
class RoleController extends BaseController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    /**
     * @routeName 角色管理
     * @routeDescription 角色管理
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @routeName 角色列表
     * @routeDescription 角色列表
     * @throws
     */
    public function actionList()
    {

        \Yii::$app->response->format=Response::FORMAT_JSON;
        $searchModel = new AuthItemSearch(['type' => $this->type]);
        $dataProvider = $searchModel->search(\Yii::$app->request->getQueryParams());
        $data=array_values($dataProvider->getModels());
        $data= ArrayHelper::toArray($data);
        foreach ($data as $key=>$value){
            $data[$key]['createdAt']=Yii::$app->formatter->asDatetime($value['createdAt']);
            $data[$key]['updatedAt']=Yii::$app->formatter->asDatetime($value['updatedAt']);
        }
        return $this->FormatLayerTable(self::REQUEST_LAY_SUCCESS,"获取成功",$data,$dataProvider->totalCount);
    }

    /**
     * @routeName 更新角色
     * @routeDescription 更新指定角色信息
     * @throws
     * @return string|Response|array
     */
    public function actionUpdate()
    {
        $req=Yii::$app->request;
        $name=$req->get("role_name");
        if ($req->isPost) {
            $name = $req->post("role_name");
        }
        $roleModel = $this->findModel($name);
        $roleModel->type = $this->type;
        if ($req->isPost){
            Yii::$app->response->format=Response::FORMAT_JSON;
            if ($roleModel->load(Yii::$app->getRequest()->post(),'') && $roleModel->save()) {
                return $this->FormatArray(self::REQUEST_SUCCESS,'修改成功',[]);
            } else {
                return $this->FormatArray(self::REQUEST_FAIL,'修改失败,'.$roleModel->getErrorSummary(false)[0],[]);
            }
        } else {
            $role_info= $roleModel->toArray();

            return $this->render('update',['role_info'=>$role_info]);
        }
    }

    /**
     * @routeName 创建角色
     * @routeDescription 创建管理员角色
     * @return string|Response|array
     */
    public function actionCreate()
    {
        $model = new AuthItem(null);
        $model->type = $this->type;
        $req=Yii::$app->request;
        if ($req->isPost){
            Yii::$app->response->format=Response::FORMAT_JSON;
            if ($model->load(Yii::$app->getRequest()->post(),'') && $model->save()) {
                return $this->FormatArray(self::REQUEST_SUCCESS,'添加成功',[]);
            } else {
                return $this->FormatArray(self::REQUEST_FAIL,'添加失败,'.$model->getErrorSummary(false)[0],[]);
            }
        } else {
            return $this->render('create');
        }

    }
    /**
     * @routeName 删除角色
     * @routeDescription 删除指定角色
     * @throws
     * @return array
     */

    public function actionDelete()
    {
        $req=Yii::$app->request;
        Yii::$app->response->format=Response::FORMAT_JSON;
        $id=$req->post("role_name");
        $roleModel = $this->findModel($id);
        Yii::$app->getAuthManager()->remove($roleModel->item);
        return $this->FormatArray(self::REQUEST_SUCCESS,'删除成功',[]);
    }

    public function getType()
    {

        return Item::TYPE_ROLE;
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
        $role_name=Yii::$app->request->get('role_name');
        $assModel= $this->findModel($role_name);
        $p=$assModel->getItems();
        //过滤重复添加添加权限
        $assigned=array_keys($p['assigned']);
        $roleModel= Yii::$app->authManager->getPermissions();
        $_data=array_values(ArrayHelper::toArray($roleModel));
        $data=[];
        foreach ($_data as $key=>$value){
            if (!in_array($value['name'],$assigned)){
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
        $role_name=Yii::$app->request->get('role_name');
        $perModel= $this->findModel($role_name);
        $p=$perModel->getItems();
        $assigned=$p['assigned'];
        unset($assigned[$role_name]);

        $data=[];
        $perModel= Yii::$app->authManager->getPermissions();
        $_data=array_values(ArrayHelper::toArray($perModel));
        foreach ($assigned as $k=>$val){
            foreach ($_data as $key=>$value){
                if ($k==$value['name']){
                    $v['name']=$value['name'];
                    $v['ext_name']=!empty($value['data']['route_name'])?$value['data']['route_name']:$value['name'];
                    $v['description']= !empty($value['description'])?$value['description']:$value['data']['route_description'];
                    $v['createdAt']=Yii::$app->formatter->asDatetime($value['createdAt']);
                    $v['updatedAt']=Yii::$app->formatter->asDatetime($value['updatedAt']);
                    $v['type']=strncmp($value['name'], '/', 1) === 0?'路由':'权限';
                    $data[]=$v;
                }
            }
        }
        return $this->FormatLayerTable(self::REQUEST_LAY_SUCCESS,"获取成功",$data,0);
    }

    /**
     * @routeName 分配路由或权限
     * @routeDescription 分配路由到角色
     * @return array
     * @throws
     */
    public function actionAssign()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $req=Yii::$app->request;
        $id= $req->post('role_name');
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
        $id= $req->post('role_name');
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
     * @routeName 查看角色
     * @routeDescription 查看角色详情
     * @return mixed
     * @throws
     */
    public function actionView()
    {
        $req=Yii::$app->request;
        $name=$req->get("role_name");
        $roleModel=$this->findModel($name);
        $role_info=$roleModel->toArray();
        return $this->render('view',['role_info'=>$role_info]);
    }
    /**
     * @param string $id
     * @return AuthItem
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        $auth = Yii::$app->getAuthManager();
        $item = $auth->getRole($id);
        if ($item) {
            return new AuthItem($item);
        } else {
            throw new NotFoundHttpException('权限不存在.'.$id);
        }
    }

}