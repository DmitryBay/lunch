<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "restaurant".
 * TODO Note - all tables without FK
 *
 * @property int $id
 * @property string $title
 * @property string $logo
 * @property string $desc
 * @property int $has_lunch
 * @property int $has_menu
 * @property int $has_alko
 * @property int $has_sportmenu
 * @property int $has_healthmenu
 * @property int $is_deleted
 * @property int $deleted_ts
 * @property int $created_ts
 * @property int $updated_ts
 * @property string $place_location
 * @property string $geohash
 * @property string $address
 */

class Restaurant extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'restaurant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'place_location'], 'required'],
            [['has_lunch', 'has_menu', 'has_alko', 'has_sportmenu', 'has_healthmenu', 'is_deleted', 'deleted_ts', 'created_ts', 'updated_ts'], 'integer'],
            [['place_location'], 'string'],
            [['title', 'logo', 'address'], 'string', 'max' => 255],
            [['desc'], 'string', 'max' => 1000],
            [['geohash'], 'string', 'max' => 9],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'logo' => 'Logo',
            'desc' => 'Desc',
            'has_lunch' => 'Has Lunch',
            'has_menu' => 'Has Menu',
            'has_alko' => 'Has Alko',
            'has_sportmenu' => 'Has Sportmenu',
            'has_healthmenu' => 'Has Healthmenu',
            'is_deleted' => 'Is Deleted',
            'deleted_ts' => 'Deleted Ts',
            'created_ts' => 'Created Ts',
            'updated_ts' => 'Updated Ts',
            'place_location' => 'Place Location',
            'geohash' => 'Geohash',
            'address' => 'Address',
        ];
    }
}
