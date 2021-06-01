<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "blog_category".
 *
 * @property int $id
 * @property int|null $numlevel Уровень
 * @property string|null $icon_b Иконка (большая)
 * @property string|null $icon_s Иконка (малая)
 * @property string|null $keyword
 * @property int|null $status Статус
 * @property int|null $parent_id Парент категория
 *
 * @property Blog[] $blogs
 * @property BlogCategory $parent
 * @property BlogCategory[] $blogCategories
 */
class BlogCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['keyword','status'],'required'],
            [['numlevel', 'status', 'parent_id'], 'integer'],
            [['keyword'], 'string'],
            [['icon_b', 'icon_s'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogCategory::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    public function translatableAttributes()
    {
        return [
            'title' => 'string',
            'mtitle' => 'string',
            'mkeywords' => 'text',
            'mdescription' => 'text',
            'titleh1' => 'string',
            'seotext' => 'text',
            'breadcrumb' => 'string',
            'view_mtitle' => 'string',
            'view_mkeywords' => 'text',
            'view_mdescription' => 'text',
            'view_share_title' => 'string',
            'view_share_description' => 'text',
            'view_share_sitename' => 'string',
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'numlevel' => 'Уровень',
            'icon_b' => 'Иконка (большая)',
            'icon_s' => 'Иконка (малая)',
            'keyword' => 'Keyword',
            'status' => 'Статус',
            'parent_id' => 'Парент категория',
        ];
    }

    /**
     * Gets query for [[Blogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlogs()
    {
        return $this->hasMany(Blog::className(), ['category_id' => 'id']);
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(BlogCategory::className(), ['id' => 'parent_id']);
    }

    /**
     * Gets query for [[BlogCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlogCategories()
    {
        return $this->hasMany(BlogCategory::className(), ['parent_id' => 'id']);
    }
}
