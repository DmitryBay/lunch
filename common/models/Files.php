<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;

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


    const SIZE_ORIGINAL = '';
    const SIZE_BIG = '_big';
    const SIZE_MID = '_mid';
    const SIZE_THUMB = '_thumb';
    const SIZE_PRELOAD = '_preload';


    const STATUS_DELETED = 0;
    const STATUS_BLOCK_DELETED = 2;
    const STATUS_BLOCK_DELETED_API = 3;
    const STATUS_APPROVED = 10;

    const DEFAULT_STATUS = self::STATUS_APPROVED;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Files';
    }

    static function getUniqueFilename($create_dir = null)
    {
        $s = "qazwsxedcrfvtgbyhnujmikolp";
        $g = substr($s, rand(0, strlen($s)), 1) . substr($s, rand(0, strlen($s)), 1);
        //$g = substr ($s, rand(0, strlen($s)) , 1).substr ($s, rand(0, strlen($s)) , 1);
        $g .= '/' . substr($s, rand(0, strlen($s)), 1) . substr($s, rand(0, strlen($s)), 1);
        $g .= '/' . substr($s, rand(0, strlen($s)), 1) . substr($s, rand(0, strlen($s)), 1);
        $dir = 'uploads/images/' . $g;


        if ($create_dir && !is_dir($dir)) {
            FileHelper::createDirectory($dir);
            // var_dump(mkdir($this->upload_dir.$dir, 0777));
            //chmod($this->upload_dir.$dir_file_str, 0777);
        }

        $f = uniqid();


        $filename = $dir . '/' . $f . '_big.jpg';

        return $filename;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['status', 'user_id'], 'integer'],
//            [['filename'], 'string', 'max' => 255],
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
