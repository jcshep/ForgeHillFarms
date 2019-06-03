<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProductWeek;

/**
 * SearchProductWeek represents the model behind the search form of `app\models\ProductWeek`.
 */
class SearchProductWeek extends ProductWeek
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'week_start', 'week_end'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $week_start, $week_end, $type = NULL)
    {
        $query = ProductWeek::find()->joinWith('product');

        if($type)
            $query->where(['product.type'=>$type]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'product_id' => $this->product_id,
            'week_start' => $this->week_start,
            'week_end' => $this->week_end,
        ]);

        $query->andFilterWhere(['week_start' => $week_start]);

        return $dataProvider;
    }
}
