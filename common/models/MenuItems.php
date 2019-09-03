<?php

namespace app\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "menu_items".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $price
 * @property int $category
 * @property int $status
 * @property int $restaurant_id
 * @property int $created_ts
 * @property int $updated_ts
 *
 * @property Restaurant $restaurant
 */
class MenuItems extends \yii\db\ActiveRecord
{


    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const DEFAULT_STATUS = self::STATUS_ACTIVE;



    static $_category = [
        1=>'Горячие блюда',
        2=>'Супы',
        3=>'Пицца',
        4=>'Хлебная тарелка',
        5=>'Десерты',
        6=>'Напитки',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu_items';
    }



    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_ts',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_ts',
                    // ActiveRecord::EVENT_BEFORE_UPDATE => 'date_updated',
                ],
                'value' => function () {
                    return time(); //
                },
            ],

            'user_id' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'user_id',
                    //  ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_ts',
                    // ActiveRecord::EVENT_BEFORE_UPDATE => 'date_updated',
                ],
                'value' => function () {
                    return !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
                }
            ],
            'status' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'status',
                    //  ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_ts',
                    // ActiveRecord::EVENT_BEFORE_UPDATE => 'date_updated',
                ],
                'value' => function () {
                    return self::DEFAULT_STATUS; //
                }
            ]
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price' ], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1000],
//            [['restaurant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurant::className(), 'targetAttribute' => ['restaurant_id' => 'id']],
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
            'description' => 'Description',
            'price' => 'Price',
            'status' => 'Status',
            'restaurant_id' => 'Restaurant ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurant()
    {
        return $this->hasOne(Restaurant::className(), ['id' => 'restaurant_id']);
    }
}
