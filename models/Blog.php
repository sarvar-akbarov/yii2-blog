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
    public $translatableAttr;
    public $tab = 1; // active tab

    public $file;

    public function __construct()
    {
        $this->translatableAttr = [];
        foreach($this->translatableAttributes() as $field){
            $this->translatableAttr[$field] = [];
        }
    }

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
            [['image', 'category_id'],'required'],
            [['category_id', 'user_id', 'status', 'view_count', 'tab'], 'integer'],
            [['date_cr'], 'safe'],
            [['slug', 'image'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['file'],'file'],
            [['translatableAttr'],'validateAttr'],
        ];
    }

    public function validateAttr($attribute, $params, $validator)
    {
        $required = ['title','short_text', 'text'];
        $fields = array_keys($this->$attribute);
        $errors = [];
        foreach($fields as $field){
            if (array_search($field, $required) !== false){
                if(array_values($this->$attribute[$field])[0] == ''){
                    array_push($errors, $field);
                }
            }
        }
        if(!empty($errors)){
            $this->addError('attrs', implode(',', $errors));
        }
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
            //----------------------tarjima uchun maydonlar------------------------
            'title'  => 'Наименование',
            'short_text' => 'Короткое Описание',
            'text' => 'Текст',
            //--------------------SEO Поиск в категории------------
            'mtitle'  => 'Заголовок (title)',
            'mkeywords'  => 'Ключевые слова (meta keywords)',
            'mdescription'  => 'Описание (meta description)',
            'titleh1'  => 'Заголовок H1',
            'seotext'  => 'SEO текст',
            'breadcrumb'  => 'Хлебная крошка',
            //------------------SEO Просмотр объявления------------
            'view_mtitle'  => 'Заголовок (title )',
            'view_mkeywords'  => 'Ключевые слова (meta keywords)',
            'view_mdescription'  => 'Описание (meta description)',
            'view_share_title'  => 'Заголовок (поделиться в соц. сетях)',
            'view_share_description'  => 'Описание (поделиться в соц. сетях)',
            'view_share_sitename'  => 'Название сайта (поделиться в соц. сетях)',
        ];
    }
    
    public function translatableAttributes()
    {
        return [
            'title' => 'string',
            'short_text' => 'text', // Короткое Описание
            'text' => 'text', // Текст
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
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(BlogCategory::className(), ['id' => 'category_id'])->with(['translations']);
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

    /**
     * Gets query for [[Translate]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(Translate::className(), ['model_id' => 'id'])->where(['translate.table_name' => self::tableName()]);
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord){
            $this->date_cr = date('Y-m-d');
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            Yii::$app->session->setFlash('success', 'Запись добавлена');
        } else {
            Yii::$app->session->setFlash('success', 'Запись обновлена');
        }
        Translate::saveTranslations($this);
        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeDelete()
    {
        if(file_exists($this->image) && $this->image){
            unlink(Yii::getAlias($this->image));
        }
        Translate::clear($this);
        return parent::beforeDelete();
    }

    public function afterFind()
    {
        parent::afterFind();
        Translate::getTranslations($this);
    }


    public function getImage()
    {
        if ($this->image){
            return "<img src='/".$this->image."' alt='Company Logo' style='width:100px;' />";
        }else{
            return "<img src='/images/logo.png' alt='Company Logo' style='width:100px;' />";
        }
    }

    public function uploadImage()
    {
        if ($this->file && $this->validate()) {
            if($this->image && file_exists($this->image) ){
                unlink(Yii::getAlias($this->image));
            }
            $fileName = 'uploads/blogs/blog_image_'.time() . '.' . $this->file->extension;
            $this->file->saveAs($fileName);
            $this->image =  $fileName;
            $this->save(false);
        }
        return true;
    }

    public static function getCategoryList()
    {
        return \yii\helpers\ArrayHelper::map(
            BlogCategory::find()->where(['!=', 'parent_id', ''])->with(['translations'])->all(),
            'id',
            function ($category) {
                return array_values($category->translatableAttr['title'])[0];
         });
    }
}
