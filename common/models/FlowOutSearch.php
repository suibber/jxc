<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FlowOut;

/**
 * FlowOutSearch represents the model behind the search form about `common\models\FlowOut`.
 */
class FlowOutSearch extends FlowOut
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'quantity'], 'integer'],
            [['number', 'out_number', 'bill_number', 'out_store', 'code_one', 'code_two', 'sale_number', 'model', 'lot_number', 'expiration_date_one', 'expiration_date_two', 'comment', 'type', 'receiver', 'receiver_short', 'product_name', 'operator', 'created_at', 'updated_at'], 'safe'],
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
        $query = FlowOut::find();

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
            ->andFilterWhere(['like', 'out_number', $this->out_number])
            ->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'out_store', $this->out_store])
            ->andFilterWhere(['like', 'code_one', $this->code_one])
            ->andFilterWhere(['like', 'code_two', $this->code_two])
            ->andFilterWhere(['like', 'sale_number', $this->sale_number])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'lot_number', $this->lot_number])
            ->andFilterWhere(['like', 'expiration_date_one', $this->expiration_date_one])
            ->andFilterWhere(['like', 'expiration_date_two', $this->expiration_date_two])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'receiver', $this->receiver])
            ->andFilterWhere(['like', 'receiver_short', $this->receiver_short])
            ->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'operator', $this->operator]);

        return $dataProvider;
    }
}
