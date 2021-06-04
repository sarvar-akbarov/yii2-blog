<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property int|null $category_id Категория
 * @property int|null $user_id Создатель
 * @property string|null $date_cr Дата создании
 * @property string|null $slug Слуг
 * @property string|null $image Картинка
 * @property int|null $status Статус
 * @property int|null $view_count  Количество просмотров
 *
 * @property BlogCategory $category
 * @property User $user
 * @property BlogView[] $blogViews
 */
class Blog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'user_id', 'status', 'view_count'], 'integer'],
            [['date_cr'], 'safe'],
            [['slug', 'image'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'user_id' => 'Создатель',
            'date_cr' => 'Дата создании',
            'slug' => 'Слуг',
            'image' => 'Картинка',
            'status' => 'Статус',
            'view_count' => ' Количество просмотров',
        ];
    }
    
    // title varchar(255) // Наименование
    // short_text text // Короткое Описание
    // text text // Текст
    // //--------------------SEO Поиск в категории------------
    // mtitle varchar(255) // Заголовок (title)
    // mkeywords text // Ключевые слова (meta keywords)
    // mdescription text // Описание (meta description)
    // titleh1 varchar(255) // Заголовок H1 
    // seotext text // SEO текст
    // breadcrumb varchar(255) // Хлебная крошка
    // //------------------SEO Просмотр объявления------------
    // view_mtitle varchar(255) // Заголовок (title )
    // view_mkeywords text // Ключевые слова (meta keywords)
    // view_mdescription text // Описание (meta description)
    // view_share_title varchar(255) //Заголовок (поделиться в соц. сетях)
    // view_share_description text // Описание (поделиться в соц. сетях)
    // view_share_sitename varchar(255) // Название сайта (поделиться в соц. сетях)
    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(BlogCategory::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[BlogViews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlogViews()
    {
        return $this->hasMany(BlogView::className(), ['blog_id' => 'id']);
    }
}
