<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-12-27
 * Time: 下午3:57
 */

namespace backend\models\search;

use Yii;
use backend\models\AdminUser;
use yii\data\ActiveDataProvider;

class AdminUserSearch extends AdminUser
{

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['username', 'nickname','username'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query =AdminUser::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>self::PAGE_CONFIG,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username]);
        $query->andFilterWhere(['like', 'nickname', $this->nickname]);
        return $dataProvider;
    }



}