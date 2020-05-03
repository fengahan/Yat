<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-11-25
 * Time: 下午11:13
 * 后台用户管理控制器
 */

namespace backend\controllers;

use backend\models\AdminUser;
use backend\models\Assignment;
use backend\models\SignUser;
use Yii;
use backend\models\search\AdminUserSearch;
use common\base\BaseController;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class AdminUserController extends BaseController
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
     * @routeName 管理员管理
     * @routeDescription 管理员管理
     */
    public function actionIndex()
    {

        return $this->render('index');

    }

    /**
     * @routeName 管理员列表
     * @routeDescription 管理员列表
     */
    public function actionList()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;

        $searchModel=new AdminUserSearch();
        $dataProvider=$searchModel->search(Yii::$app->request->queryParams);

        return $this->FormatLayerTable(
            self::REQUEST_LAY_SUCCESS,'获取成功',
            $dataProvider->getModels(),$dataProvider->getTotalCount()
        );
    }
    /**
     * @routeName 创建管理员
     * @routeDescription 创建新的管理员
     * @throws
     * @return string |Response |array
     */
    public function actionCreate()
    {
        $req=Yii::$app->request;
        if ($req->isPost){
            Yii::$app->response->format=Response::FORMAT_JSON;
            $signUser=new SignUser();
            $signUser->last_login_at=time();
            $items=$req->post('items',[]);
            if ($signUser->load($req->post(),'') && $signUser->save()){
                $assignModel=$this->findAssignModel($signUser->id);
                $success= $assignModel->assign($items);
                if ($success==count($items) && $success>1){
                    return $this->FormatArray(self::REQUEST_SUCCESS,"添加成功",[]);
                }else{
                    return $this->FormatArray(self::REQUEST_FAIL,"管理员添加成功,但权限分配有误,请到更新处确认",[]);
                }
            }else{
                return $this->FormatArray(self::REQUEST_FAIL,$signUser->getErrorSummary(false)[0],[]);
            }
        }
        $assignData=Assignment::getAllItems();
        return $this->render('create',['assignData'=>$assignData]);

    }

    /**
     * @routeName 更新管理员
     * @routeDescription 更新管理员信息
     * @throws
     */
    public function actionUpdate()
    {
        $req=Yii::$app->request;
        $admin_user_id=$req->get('admin_user_id');
        if ($req->isPost){
            $admin_user_id=$req->post('admin_user_id');
        }
        $adminModel=$this->findModel($admin_user_id);

        $assignModel=$this->findAssignModel($admin_user_id);
        $assignData = $assignModel->getAssignItems();
        if ($req->isPost){
            Yii::$app->response->format=Response::FORMAT_JSON;
            $items=$req->post('items',[]);
            if ($adminModel->load($req->post(),'')==false){
               return $this->FormatArray(self::REQUEST_FAIL,"参数异常",[]);
            }
            if ($adminModel->role==AdminUser::ROLE_ROOT){
                $adminModel->status=$adminModel->getOldAttribute("status");
                $adminModel->role=$adminModel->getOldAttribute("role");
            }

            if ( $adminModel->save()){
                $assigned= array_reduce($assignData, 'array_merge', []);;//已经拥有的
                $removeAss=array_diff($assigned,$items);//需要移除的权限或者角色
                $assignAss=array_diff($items,$assigned);//新增的权限或者角色
                $rm_success = $assignModel->revoke($removeAss);
                $as_success= $assignModel->assign($assignAss);
                if ($rm_success+$as_success !=$removeAss+$assignAss || $rm_success!=$removeAss){
                    return $this->FormatArray(self::REQUEST_SUCCESS,"更新成功",[]);
                }else{
                    return $this->FormatArray(self::REQUEST_FAIL,"管理员更新成功,但权限分配有误,请到更新处确认",[]);
                }
            }else{
                return $this->FormatArray(self::REQUEST_FAIL,$adminModel->getErrorSummary(false)[0],[]);
            }
        }else{

            $all_role = Assignment::getAllItems();
            return $this->render('update',['admin_user'=>$adminModel->toArray(),'assignData'=>$assignData,'all_role'=>$all_role]);
        }

    }

    /**
     * @routeName 删除管理员
     * @routeDescription 删除指定管理员
     * @return array
     * @throws
     */
    public function actionDelete()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $req=Yii::$app->request;
        $admin_user_id=(int)$req->post('admin_user_id');
        $adminUser=$this->findModel($admin_user_id);
        if ($adminUser->role==AdminUser::ROLE_ROOT){
            return $this->FormatArray(self::REQUEST_FAIL,"禁止删除超级管理员",[]);
        }
        if ($adminUser->delete()){
            return $this->FormatArray(self::REQUEST_SUCCESS,"删除成功",[]);
        }else{
            return $this->FormatArray(self::REQUEST_SUCCESS,"删除失败",[]);
        }


    }

    /**
     * @routeName 上传头像
     * @routeDescription 上传头像
     * @inheritdoc
     * @todo
     */
    public function actionUploadHeadImg()
    {

        Yii::$app->response->format=Response::FORMAT_JSON;
        $data['head_img']='https://www.yiichina.com/uploads/avatar/000/02/90/86_avatar_small.jpg';
        return $this->FormatArray(self::REQUEST_SUCCESS,"上传成功",$data);


    }

    /**
     * @routeName 更新状态
     * @routeDescription 更新状态
     * @return array |Response|string
     * @throws NotFoundHttpException
     */
    public function actionUpdateStatus(){

        Yii::$app->response->format=Response::FORMAT_JSON;
        $req=Yii::$app->request;
        $admin_user_id=(int)$req->post('admin_user_id');

        $adminUser=$this->findModel($admin_user_id);
        if ($adminUser->role==AdminUser::ROLE_ROOT){
            return $this->FormatArray(self::REQUEST_FAIL,"禁止更新超级管理员状态",[]);
        }
        $adminUser->status = $adminUser->status==10?0:10;
        if ($adminUser->save()){
            return $this->FormatArray(self::REQUEST_SUCCESS,"更新成功",[]);
        }else{
            return $this->FormatArray(self::REQUEST_FAIL,"更新失败",[]);
        }
    }

    /**
     * @param int $id 用户ID
     * @return Assignment
     * @throws NotFoundHttpException
     */
    protected function findAssignModel($id)
    {

        if (($user = AdminUser::findOne($id)) !== null) {
            return new Assignment($id, $user);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $id
     * @return null|AdminUser
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = AdminUser::findOne($id)) !== null) {
           return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}