<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Blog;

/**
 * BlogSearch represents the model behind the search form about `app\models\Blog`.
 */
class BlogSearch extends Blog
{
    public $title;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'view_count'], 'integer'],
            [['date_cr','category_id', 'slug', 'user_id', 'title'], 'safe'],
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
        $query = Blog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith(['category', 'translations', 'user']);

        $query->andFilterWhere([
            'id' => $this->id,
            'blog.date_cr' => $this->date_cr,
            'blog.status' => $this->status,
            'blog.category_id' => $this->category_id,
            'blog.view_count' => $this->view_count,
        ]);

        $query->andFilterWhere(['like', 'blog.slug', $this->slug])
            ->andFilterWhere(['like', 'blog.image', $this->image])
            ->andFilterWhere(['like', 'user.fio', $this->user_id]);
        
        if($this->title){
            $query->andWhere(['translate.field_name' => 'title'])
                ->andFilterWhere(['like', 'translate.field_value', $this->title]);
        }

        return $dataProvider;
    }
}
