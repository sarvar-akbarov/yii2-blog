<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banner_item".
 *
 * @property int $id
 * @property int|null $banner_id Рекламный баннер
 * @property int|null $type Тип
 * @property string|null $code Код
 * @property string|null $img Картинка
 * @property string|null $url Ссылка
 * @property string|null $show_start Дата начала
 * @property string|null $show_finish Дата окончание
 * @property int|null $show_limit Количество показа
 * @property int|null $status
 * @property int|null $target_blank Таргет
 * @property int|null $sorting_number Порядковый номер
 * @property int|null $time Время
 *
 * @property Banner $banner
 */
class BannerItem extends \yii\db\ActiveRecord
{
    public $file;
    public $translatableAttr;
    public $tab = 1;

    const TYPE_IMAGE = 1;
    const TYPE_CODE = 2;
    
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
        return 'banner_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['time','show_limit','show_start','show_finish','url'],'required'],
            [['code'], 'required', 'when' => function($model){return $model->type == self::TYPE_CODE;}],
            [['img'], 'required', 'when' => function($model){return $model->type == self::TYPE_IMAGE;}],
            [['banner_id', 'type', 'show_limit', 'status', 'target_blank', 'sorting_number', 'time', 'tab'], 'integer'],
            [['code'], 'string'],
            [['url'],'url'],
            [['show_start', 'show_finish'], 'safe'],
            [['img', 'url'], 'string', 'max' => 255],
            [['banner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Banner::className(), 'targetAttribute' => ['banner_id' => 'id']],
            [['file'],'file'],
            [['translatableAttr'],'validateAttr'],
        ];
    }

    public function validateAttr($attribute, $params, $validator)
    {
        $required = ['title', 'description', 'alt'];
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
            'description' => 'text',
            'alt' => 'string',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'banner_id' => 'Рекламный баннер',
            'type' => 'Тип',
            'code' => 'Код',
            'img' => 'Картинка',
            'url' => 'Ссылка',
            'show_start' => 'Дата начала',
            'show_finish' => 'Дата окончание',
            'show_limit' => 'Количество показа',
            'status' => 'Status',
            'target_blank' => 'Таргет',
            'sorting_number' => 'Порядковый номер',
            'time' => 'Время',
            //----------------------tarjima uchun maydonlar------------------------
            'title' => 'Наименование рекламы',
            'description' => 'Текст' ,
            'alt' => 'Алт',
        ];
    }

    /**
     * Gets query for [[Banner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBanner()
    {
        return $this->hasOne(Banner::className(), ['id' => 'banner_id']);
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
        $this->show_start = Yii::$app->formatter->asDate($this->show_start, 'php:Y-m-d');
        $this->show_finish = Yii::$app->formatter->asDate($this->show_finish, 'php:Y-m-d');

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
        if(file_exists($this->img) && $this->img){
            unlink(Yii::getAlias($this->img));
        }
        Translate::clear($this);
        return parent::beforeDelete();
    }

    public function afterFind()
    {
        parent::afterFind();
        Translate::getTranslations($this);
    }

    public static function getTypeList()
    {
        return [
            self::TYPE_IMAGE => 'Изображение',
            self::TYPE_CODE => 'Код',
        ];
    }

    public static function getTarget()
    {
        return [
            // Таргет или нет 0 - Нет, 1 - Да
            0 => 'Нет',
            1 => 'Да'
        ];
    }

    public function getImage()
    {
        if ($this->img){
            return "<img src='/".$this->img."' alt='Company Logo' style='width:100px;' />";
        }else{
            return false;
        }
    }

    public function uploadImage()
    {
        if ($this->file && $this->validate()) {

            if($this->img && file_exists($this->img) ){
                unlink(Yii::getAlias($this->img));
            }

            $fileName = 'uploads/banner-item/banner_img_' . time() . '.' . $this->file->extension;
            $this->file->saveAs($fileName);
            $this->img =  $fileName;
            $this->save(false);
        }
        
        return true;
    }

}
