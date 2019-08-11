<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Files".
 *
 * @property int $id
 * @property string $filename
 * @property int $status
 * @property int $user_id
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'user_id'], 'integer'],
            [['filename'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Filename',
            'status' => 'Status',
            'user_id' => 'User ID',
        ];
    }
}
