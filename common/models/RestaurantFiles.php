<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "restaurant_files".
 *
 * @property int $rest_id
 * @property int $files_id
 * @property int $created_ts
 * @property int $position
 */
class RestaurantFiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'restaurant_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rest_id', 'files_id'], 'required'],
            [['rest_id', 'files_id', 'created_ts', 'position'], 'integer'],
            [['rest_id', 'files_id'], 'unique', 'targetAttribute' => ['rest_id', 'files_id']],
        ];
    }




    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Files::className(), ['id' => 'files_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurant()
    {
        return $this->hasOne(Restaurant::className(), ['id' => 'rest_id']);
    }



    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rest_id' => 'Rest ID',
            'files_id' => 'Files ID',
            'created_ts' => 'Created Ts',
            'position' => 'Position',
        ];
    }
}
