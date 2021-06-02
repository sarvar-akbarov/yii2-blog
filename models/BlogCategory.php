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
    public $translatableAttr;
    public $tab = 1; // active tab

    public $file1;
    public $file2;

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
        return 'blog_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['keyword','status'],'required'],
            [['numlevel', 'status', 'parent_id', 'tab'], 'integer'],
            [['keyword'], 'string'],
            [['icon_b', 'icon_s'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogCategory::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['translatableAttr'],'validateAttr'],
            [['file1'],'file'],
            [['file2'],'file'],
        ];
    }

    public function validateAttr($attribute, $params, $validator)
    {
        $required = ['title','mtitle'];
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
            'file1' => 'Иконка (большая)',
            'icon_s' => 'Иконка (малая)',
            'file2' => 'Иконка (малая)',
            'keyword' => 'Keyword',
            'status' => 'Статус',
            'parent_id' => 'Парент категория',
            //----------------------tarjima uchun maydonlar------------------------
            'title'  => 'Заголовок',
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

    public function beforeSave($insert)
    {
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            foreach($this->translatableAttr as $name => $values){
                foreach($values as $language_id => $value){
                    $translate = new Translate();
                    $translate->table_name = self::tableName();
                    $translate->model_id = $this->id;
                    $translate->field_name = $name;
                    $translate->field_description = "";
                    $translate->field_value = $value;
                    $translate->language_id = $language_id;
                    $translate->save();
                }
            }
            Yii::$app->session->setFlash('success', 'Запись добавлена');
        } else {
            foreach($this->translatableAttr as $name => $values){
                foreach($values as $language_id => $value){
                    $translate = Translate::find()->where([
                        'language_id' => $language_id,
                        'field_name' => $name, 
                        'model_id' => $this->id,
                        'table_name' => self::tableName()
                    ])->one();

                    if($translate){
                        $translate->field_value = $value;
                        $translate->save();
                    }else{
                        $translate = new Translate();
                        $translate->table_name = self::tableName();
                        $translate->model_id = $this->id;
                        $translate->field_name = $name;
                        $translate->field_description = "";
                        $translate->field_value = $value;
                        $translate->language_id = $language_id;
                        $translate->save();
                    }
                }
            }
            Yii::$app->session->setFlash('success', 'Запись обновлена');
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeDelete()
    {
        if(file_exists($this->icon_s) && $this->icon_s){
            unlink(Yii::getAlias($this->icon_s));
        }
        if(file_exists($this->icon_b) && $this->icon_b){
            unlink(Yii::getAlias($this->icon_b));
        }
        return parent::beforeDelete();
    }

    public function getLogo($small = true)
    {
        if ($small){
            $image = $this->icon_s;
        }else{
            $image = $this->icon_b;
        }
        if ($image){
            return "<img src='/".$image."' alt='Company Logo' style='width:100px;' />";
        }else{
            return "<img src='/images/logo.png' alt='Company Logo' style='width:100px;' />";
        }
    }

    public function uploadLogo()
    {
        if ($this->file1 && $this->validate()) {
            if($this->icon_s && file_exists($this->icon_s) ){
                unlink(Yii::getAlias($this->icon_s));
            }
            $fileName = 'uploads/blog-category/logo_s_'.time() . '.' . $this->file1->extension;
            $this->file1->saveAs($fileName);
            $this->icon_s =  $fileName;
            $this->save(false);
        }

        if ($this->file2 && $this->validate()) {
            if($this->icon_b && file_exists($this->icon_b) ){
                unlink(Yii::getAlias($this->icon_b));
            }
            $fileName = 'uploads/blog-category/logo_b_'.time() . '.' . $this->file2->extension;
            $this->file2->saveAs($fileName);
            $this->icon_b =  $fileName;
            $this->save(false);
        }
        
        return true;
    }
}
