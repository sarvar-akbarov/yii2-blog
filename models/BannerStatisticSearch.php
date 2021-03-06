<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BannerStatistic;

/**
 * BannerStatisticSearch represents the model behind the search form about `app\models\BannerStatistic`.
 */
class BannerStatisticSearch extends BannerStatistic
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'clicks', 'shows'], 'integer'],
            [['date', 'banner_id'], 'safe'],
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
    public function search($id, $params)
    {
        $query = BannerStatistic::find()->orderBy(['date' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->joinWith(['bannerItems'])->where(['banner.id' => $id]);    

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
            'clicks' => $this->clicks,
            'shows' => $this->shows,
        ]);
        
        $query->andFilterWhere(['like', 'banner_id', $this->banner_id]);

        return $dataProvider;
    }
}
