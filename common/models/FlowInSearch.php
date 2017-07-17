<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FlowIn;

/**
 * FlowInSearch represents the model behind the search form about `common\models\FlowIn`.
 */
class FlowInSearch extends FlowIn
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'quantity'], 'integer'],
            [['number', 'in_number', 'bill_number', 'order_number', 'in_store', 'code_one', 'code_two', 'lot_number', 'expiration_date_one', 'expiration_date_two', 'model', 'comment', 'product_suppliers', 'product_suppliers_short', 'product_name', 'type', 'operator', 'created_at', 'updated_at'], 'safe'],
            [['in_one_price', 'in_price'], 'number'],
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
        $query = FlowIn::find();

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
            'in_one_price' => $this->in_one_price,
            'in_price' => $this->in_price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'in_number', $this->in_number])
            ->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'order_number', $this->order_number])
            ->andFilterWhere(['like', 'in_store', $this->in_store])
            ->andFilterWhere(['like', 'code_one', $this->code_one])
            ->andFilterWhere(['like', 'code_two', $this->code_two])
            ->andFilterWhere(['like', 'lot_number', $this->lot_number])
            ->andFilterWhere(['like', 'expiration_date_one', $this->expiration_date_one])
            ->andFilterWhere(['like', 'expiration_date_two', $this->expiration_date_two])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'product_suppliers', $this->product_suppliers])
            ->andFilterWhere(['like', 'product_suppliers_short', $this->product_suppliers_short])
            ->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'operator', $this->operator]);

        return $dataProvider;
    }
}
