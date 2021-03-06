<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "translate".
 *
 * @property int $id
 * @property string|null $table_name Наименование таблицы
 * @property int|null $model_id ID строка
 * @property string|null $field_name Наименование строка
 * @property string|null $field_description Описание поля
 * @property string|null $field_value Значение
 * @property int|null $language_id
 *
 * @property Language $language
 */
class Translate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'translate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_value','language_id','model_id','table_name','field_name'], 'required'],
            [['model_id', 'language_id'], 'integer'],
            [['field_value'], 'string'],
            [['table_name', 'field_name', 'field_description'], 'string', 'max' => 255],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'table_name' => 'Table Name',
            'model_id' => 'Model ID',
            'field_name' => 'Field Name',
            'field_description' => 'Field Description',
            'field_value' => 'Field Value',
            'language_id' => 'Language ID',
        ];
    }

    /**
     * Gets query for [[Language]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    public static function saveTranslations($model)
    {
        if ($model->isNewRecord) {
            foreach($model->translatableAttr as $name => $values){
                foreach($values as $language_id => $value){
                
                    $translate = new Translate();
                    $translate->table_name = $model->tableSchema->name;
                    $translate->model_id = $model->id;
                    $translate->field_name = $name;
                    $translate->field_description = "";
                    $translate->field_value = $value;
                    $translate->language_id = $language_id;
                    
                    $translate->save();
                }
            }
            Yii::$app->session->setFlash('success', 'Запись добавлена');
        } else {
            foreach($model->translatableAttr as $name => $values){
                foreach($values as $language_id => $value){
                    $translate = Translate::find()->where([
                        'language_id' => $language_id,
                        'field_name' => $name, 
                        'model_id' => $model->id,
                        'table_name' => $model->tableSchema->name
                    ])->one();
                    if($translate){
                        $translate->field_value = $value;
                        $translate->save();
                    }else{
                        $translate = new Translate();
                        $translate->table_name = $model->tableSchema->name;
                        $translate->model_id = $model->id;
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
    }

    public static function getTranslations($model)
    {
        $translations = $model->translations;
        foreach($translations as $translation){
            $model->translatableAttr[$translation->field_name][$translation->language_id] = $translation->field_value;
        }
    }
    
    public static function clear($model)
    {
        self::deleteAll(['model_id' => $model->id, 'table_name' => $model->tableSchema->name]);
    }
}
