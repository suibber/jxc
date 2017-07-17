<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FlowOrder;

/**
 * FlowOrderSearch represents the model behind the search form about `common\models\FlowOrder`.
 */
class FlowOrderSearch extends FlowOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'quantity'], 'integer'],
            [['number', 'order_number', 'bill_number', 'model', 'discount', 'comment', 'product_suppliers', 'product_name', 'operator', 'created_at', 'updated_at'], 'safe'],
            [['discount_price', 'order_price', 'product_price'], 'number'],
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
        $query = FlowOrder::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
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
            'quantity' => $this->quantity,
            'discount_price' => $this->discount_price,
            'order_price' => $this->order_price,
            'product_price' => $this->product_price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'order_number', $this->order_number])
            ->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'discount', $this->discount])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'product_suppliers', $this->product_suppliers])
            ->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'operator', $this->operator]);

        return $dataProvider;
    }
}
