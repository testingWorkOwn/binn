<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * CarSearch represents the model behind the search form about `app\models\Car`.
 */
class CarSearch extends Car
{
    /**
     * @var
     */
    public $fromYear;
    /**
     * @var
     */
    public $toYear;
    /**
     * @var
     */
    public $fromPrice;
    /**
     * @var
     */
    public $toPrice;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'categoryId', 'price', 'year', 'fromYear', 'toYear', 'fromPrice', 'toPrice'], 'integer'],
            [['title', 'created_at', 'updated_at'], 'safe'],
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
        $query = Car::find();

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
            'status' => $this->status,
            'categoryId' => $this->categoryId,
            'price' => $this->price,
            'year' => $this->year,
        ]);

        $query
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', new Expression('FROM_UNIXTIME([[created_at]], "%Y-%m-%d")'), $this->created_at])
            ->andFilterWhere(['like', new Expression('FROM_UNIXTIME([[updated_at]], "%Y-%m-%d")'), $this->updated_at]);

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function searchOnfrontend($params)
    {
        $query = Car::find();

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
            'categoryId' => $this->categoryId,
        ]);

        $query->andFilterWhere(['>=', 'price', $this->fromPrice]);
        $query->andFilterWhere(['<=', 'price', $this->toPrice]);

        $query->andFilterWhere(['>=', 'year', $this->fromYear]);
        $query->andFilterWhere(['<=', 'year', $this->toYear]);

        return $dataProvider;
    }
}
