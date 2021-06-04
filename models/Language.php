<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "language".
 *
 * @property int $id
 * @property string|null $code Код языка
 * @property string|null $local Местное название
 * @property string|null $name Наименование
 * @property string|null $image Фотография
 * @property int|null $default поумолчанию
 * @property int|null $status Статус
 *
 * @property Translate[] $translates
 */
class Language extends \yii\db\ActiveRecord
{   
    public $file;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'language';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'local', 'name'], 'required'],
            [['default', 'status'], 'integer'],
            [['code', 'local', 'name', 'image'], 'string', 'max' => 255],
            ['file','file']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Код языка',
            'local' => 'Местное название',
            'name' => 'Наименование',
            'image' => 'Фотография',
            'file' => 'Фотография',
            'default' => 'поумолчанию',
            'status' => 'Статус',
        ];
    }

    /**
     * Gets query for [[Translates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslates()
    {
        return $this->hasMany(Translate::className(), ['language_id' => 'id']);
    }

    public static function getLanguageList()
    {
        $languages = self::find()->where(['status'=>STATUS_ACTIVE])->orderBy(['default'=>SORT_DESC])->all();
        return \yii\helpers\ArrayHelper::map($languages, 'id', 'local');
    }

    public static function getDefault()
    {
        return [
            0 => 'Нет',
            1 => 'Да'
        ];
    }

    public function getImage()
    {
        if ($this->image){
            return "<img src='/".$this->image."' alt='Company image' style='width:100px;' />";
        }else{
            return false;
        }
    }

    public function uploadImage()
    {
        if ($this->file && $this->validate()) {

            if($this->image && file_exists($this->image) ){
                unlink(Yii::getAlias($this->image));
            }

            $fileName = 'uploads/languages/language_' . time() . '.' . $this->file->extension;
            $this->file->saveAs($fileName);
            $this->image =  $fileName;
            $this->save(false);
        }
        
        return true;
    }
}
