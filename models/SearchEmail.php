<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Email;

/**
 * SearchEmail represents the model behind the search form of `app\models\Email`.
 */
class SearchEmail extends Email
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'send_date', 'created'], 'integer'],
            [['type', 'content_area_1', 'content_area_2', 'content_area_3', 'send_to'], 'safe'],
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
    public function search($params)
    {
        $query = Email::find();

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
            'send_date' => $this->send_date,
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'content_area_1', $this->content_area_1])
            ->andFilterWhere(['like', 'content_area_2', $this->content_area_2])
            ->andFilterWhere(['like', 'content_area_3', $this->content_area_3])
            ->andFilterWhere(['like', 'send_to', $this->send_to]);

        return $dataProvider;
    }
}
