<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property int $id
 * @property int|null $type Тип
 * @property int|null $user_id Пользователь
 * @property string|null $user_ip Ip
 * @property string|null $name ФИО
 * @property string|null $email E-mail
 * @property string|null $phone Телефон номер
 * @property string|null $message Сообщение
 * @property string|null $user_agent Браузер пользователья
 * @property string|null $date_cr Дата создание
 * @property int|null $viewed Статус
 *
 * @property User $user
 */
class Contact extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'user_id', 'viewed'], 'integer'],
            [['message', 'user_agent'], 'string'],
            [['date_cr'], 'safe'],
            [['user_ip', 'name', 'email', 'phone'], 'string', 'max' => 255],
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
            'type' => 'Тип',
            'user_id' => 'Пользователь',
            'user_ip' => 'Ip',
            'name' => 'ФИО',
            'email' => 'E-mail',
            'phone' => 'Телефон номер',
            'message' => 'Сообщение',
            'user_agent' => 'Браузер пользователья',
            'date_cr' => 'Дата создание',
            'viewed' => 'Статус',
        ];
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

    public static function getTypeList()
    {
        return [
            1 => 'Ошибка на сайте',
            2 => 'Технический вопрос',
            3 => 'Предложение',
            4 => 'Другие вопросы',
        ];
    }
}
