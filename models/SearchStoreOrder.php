<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cart;

/**
 * SearchStoreOrder represents the model behind the search form of `app\models\Cart`.
 */
class SearchStoreOrder extends Cart
{
    /**
     * @inheritdoc
     */
    public $status;

    public function rules()
    {
        return [
            [['id', 'user', 'order_date'], 'integer'],
            [['total'], 'number'],
            [['fname', 'lname', 'email', 'phone','ready', 'status','cart'], 'safe'],
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
        $query = Cart::find();

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
            'user' => $this->user,
            'total' => $this->total,
            'order_date' => $this->order_date,
        ]);

        $query->andFilterWhere(['like', 'fname', $this->fname])
            ->andFilterWhere(['like', 'lname', $this->lname])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'cart', $this->cart]);

        if($this->status == 'fulfilled') {
            $query->andWhere(['NOT', ['ready' => NULL]]);
        } elseif ($this->status == 'pending') {
            $query->andWhere(['ready'=>NULL]);
        } else {
            
        }



        return $dataProvider;
    }
}
