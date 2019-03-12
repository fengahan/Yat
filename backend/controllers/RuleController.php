<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-12-25
 * Time: 下午8:29
 */

namespace backend\controllers;

use backend\models\search\BizSearch;
use Yii;
use common\base\BaseController;
use backend\models\BizRule;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

class RuleController extends BaseController
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
     * @routeName 规则管理
     * @routeDescription 规则管理
     */
    public function actionIndex()
    {

       return $this->render('index');

    }

    /**
     * @routeName 规则列表
     * @routeDescription 规则列表
     */
    public function actionList()
    {
        {
            Yii::$app->response->format=Response::FORMAT_JSON;
            $searchModel = new BizSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
            $data=array_values($dataProvider->getModels());
            $data= ArrayHelper::toArray($data);
            foreach ($data as $key=>$value){
                $data[$key]['createdAt']=Yii::$app->formatter->asDatetime($value['createdAt']);
                $data[$key]['updatedAt']=Yii::$app->formatter->asDatetime($value['updatedAt']);
            }
            return $this->FormatLayerTable(self::REQUEST_LAY_SUCCESS,"获取成功",$data,$dataProvider->totalCount);
        }
    }

    /**
     * @routeName 创建规则
     * @routeDescription 创建访问规则
     * @return string|Response|array
     */
    public function actionCreate()
    {
        $model = new BizRule(null);
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
     * @routeName 更新规则
     * @routeDescription 更新指定规则信息
     * @return array |Response |string
     * @throws
     */
    public function actionUpdate()
    {
        $req=Yii::$app->request;
        if ($req->isPost){
            $rule_name=$req->post('rule_name');
        }else{
            $rule_name=$req->get('rule_name');
        }
        $model = $this->findModel($rule_name);
        $rule_info=ArrayHelper::toArray($model);
        if ($req->isPost){
            Yii::$app->response->format=Response::FORMAT_JSON;
            if ($model->load($req->post(),'') && $model->save()) {
                return $this->FormatArray(self::REQUEST_SUCCESS,'修改成功',[]);
            } else {
                return $this->FormatArray(self::REQUEST_FAIL,'修改失败,'.$model->getErrorSummary(false)[0],[]);
            }
        } else {
            return $this->render('update', ['rule_info'=>$rule_info]);
        }
    }

    /**
     * @routeName 删除规则
     * @routeDescription 删除指定规则
     * @return array
     * @throws
     */

    public function actionDelete()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $req=Yii::$app->request;
        $rule_name=$req->post("rule_name");
        $model = $this->findModel($rule_name);
        Yii::$app->authManager->remove($model->item);
        return $this->FormatArray(self::REQUEST_SUCCESS,'删除成功',[]);
    }

    /**
     * @param $id
     * @return BizRule
     * @throws
     */
    protected function findModel($id)
    {
        $item = Yii::$app->authManager->getRule($id);
        if ($item) {
            return new BizRule($item);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}