<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BlogCategory;

/**
 * BlogCategorySearch represents the model behind the search form about `app\models\BlogCategory`.
 */
class BlogCategorySearch extends BlogCategory
{
    public $title;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'numlevel', 'parent_id'], 'integer'],
            [['icon_b','title', 'icon_s', 'keyword', 'status'], 'safe'],
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
        $query = BlogCategory::find()->where(['parent_id' => null])->groupBy(['id']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->with('blogCategories');
        $query->joinWith('translations');

        $query->andFilterWhere([
            'id' => $this->id,
            'numlevel' => $this->numlevel,
            'parent_id' => $this->parent_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'icon_b', $this->icon_b])
            ->andFilterWhere(['like', 'icon_s', $this->icon_s])
            ->andFilterWhere(['like', 'keyword', $this->keyword]);

        if($this->title){
            $query->andWhere(['translate.field_name' => 'title'])
                ->andFilterWhere(['like', 'translate.field_value', $this->title]);
        }

        return $dataProvider;
    }
}
