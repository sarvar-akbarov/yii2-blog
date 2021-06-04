<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BannerItem;

/**
 * BannerItemSearch represents the model behind the search form about `app\models\BannerItem`.
 */
class BannerItemSearch extends BannerItem
{
    public $title;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'banner_id', 'type', 'show_limit', 'status', 'sorting_number', 'time'], 'integer'],
            [['code', 'img', 'url','title', 'show_start', 'show_finish', 'target_blank'], 'safe'],
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
    public function search($query,$params)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query->groupBy(['id']),
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        
        $query->joinWith('translations');

        $query->andFilterWhere([
            'id' => $this->id,
            'banner_id' => $this->banner_id,
            'type' => $this->type,
            'show_start' => $this->show_start,
            'show_finish' => $this->show_finish,
            'show_limit' => $this->show_limit,
            'status' => $this->status,
            'sorting_number' => $this->sorting_number,
            'time' => $this->time,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'target_blank', $this->target_blank]);
        
        if($this->title){
            $query->andWhere(['translate.field_name' => 'title'])
                ->andFilterWhere(['like', 'translate.field_value', $this->title]);
        }
        
        return $dataProvider;
    }
}
