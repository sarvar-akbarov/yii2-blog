<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banner".
 *
 * @property int $id
 * @property string|null $keyword Ключ
 * @property string|null $title  Наименование рекламы
 * @property int|null $status Статус
 *
 * @property BannerItem[] $bannerItems
 * @property BannerStatistic[] $bannerStatistics
 */
class Banner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['keyword', 'title'], 'required'],
            [['status'], 'integer'],
            [['keyword', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'keyword' => 'Ключ',
            'title' => ' Наименование рекламы',
            'status' => 'Статус',
        ];
    }

    /**
     * Gets query for [[BannerItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBannerItems()
    {
        return $this->hasMany(BannerItem::className(), ['banner_id' => 'id']);
    }

    /**
     * Gets query for [[BannerStatistics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBannerStatistics()
    {
        return $this->hasMany(BannerStatistic::className(), ['banner_id' => 'id']);
    }
}
