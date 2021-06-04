<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banner_statistic".
 *
 * @property int $id
 * @property int|null $banner_id Рекламный баннер
 * @property string|null $date Дата
 * @property int|null $clicks Количество кликов
 * @property int|null $shows Количество просмотр
 *
 * @property BannerItem $banner
 */
class BannerStatistic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banner_statistic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['banner_id', 'clicks', 'shows'], 'integer'],
            [['date'], 'safe'],
            [['banner_id'], 'exist', 'skipOnError' => true, 'targetClass' => BannerItem::className(), 'targetAttribute' => ['banner_id' => 'id']],
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
            'date' => 'Дата',
            'clicks' => 'Количество кликов',
            'shows' => 'Количество просмотр',
        ];
    }

    /**
     * Gets query for [[Banner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBannerItems()
    {
        return $this->hasOne(BannerItem::className(), ['id' => 'banner_id'])->joinWith('banner');
    }
}
