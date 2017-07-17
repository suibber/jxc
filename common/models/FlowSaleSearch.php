<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FlowSale;

/**
 * FlowSaleSearch represents the model behind the search form about `common\models\FlowSale`.
 */
class FlowSaleSearch extends FlowSale
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'quantity'], 'integer'],
            [['number', 'sale_number', 'bill_number', 'model', 'comment', 'custom', 'custom_short', 'salesman', 'product_name', 'operator', 'created_at', 'updated_at'], 'safe'],
            [['in_one_price', 'in_price', 'sale_one_price', 'sale_price'], 'number'],
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
        $query = FlowSale::find();

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
            'sale_one_price' => $this->sale_one_price,
            'sale_price' => $this->sale_price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'sale_number', $this->sale_number])
            ->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'custom', $this->custom])
            ->andFilterWhere(['like', 'custom_short', $this->custom_short])
            ->andFilterWhere(['like', 'salesman', $this->salesman])
            ->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'operator', $this->operator]);

        return $dataProvider;
    }
}
