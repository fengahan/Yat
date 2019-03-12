<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-12-26
 * Time: 下午3:52
 */

namespace backend\models\search;

use Yii;
use backend\models\BizRule as MBizRule;
use common\base\BaseModel;
use yii\data\ArrayDataProvider;
use backend\models\RouteRule;


class BizSearch extends BaseModel
{
    /**
     * @var string name of the rule
     */
    public $name;

    public function rules()
    {
        return [
            [['name'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('rbac-admin', 'Name'),
        ];
    }

    /**
     * Search BizRule
     * @param array $params
     * @return ArrayDataProvider
     */
    public function search($params)
    {
        /* @var \yii\rbac\ManagerInterface $authManager */
        $authManager = Yii::$app->authManager;
        $models = [];
        $included = !($this->load($params) && $this->validate() && trim($this->name) !== '');
        foreach ($authManager->getRules() as $name => $item) {
            if ($name != RouteRule::RULE_NAME && ($included || stripos($item->name, $this->name) !== false)) {
                $models[$name] = new MBizRule($item);
            }
        }

        return new ArrayDataProvider([
            'allModels' => $models,
        ]);
    }
}