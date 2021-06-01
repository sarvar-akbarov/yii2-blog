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
            [['default', 'status'], 'integer'],
            [['code', 'local', 'name', 'image'], 'string', 'max' => 255],
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
}
