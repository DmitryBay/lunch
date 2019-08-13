<?php

use yii\db\Migration;

/**
 * Class m190810_104415_restaurants
 */
class m190810_104415_restaurants extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('restaurant',[
            'id'=>$this->primaryKey(),
            'title'=>$this->string()->notNull(),
            'logo'=>$this->string(),
            'desc'=>$this->string(1000),


            'has_lunch'=>$this->smallInteger(1)->notNull()->defaultValue(0) ,
            'has_menu'=>$this->smallInteger(1)->notNull()->defaultValue(0) ,
            'has_alko'=>$this->smallInteger(1)->notNull()->defaultValue(0) ,
            'has_sportmenu'=>$this->smallInteger(1)->notNull()->defaultValue(0) ,
            'has_healthmenu'=>$this->smallInteger(1)->notNull()->defaultValue(0) ,

            'is_deleted'=>$this->smallInteger(1)->notNull()->defaultValue(0),
            'deleted_ts'=>$this->integer(),
            'created_ts'=>$this->integer(),
            'updated_ts'=>$this->integer(),
            'lnglat'=>'point not null',
            'geohash'=>$this->string(9),
            'address'=>$this->string(),
        ]);

        $this->createTable('files',[
            'id'=>$this->primaryKey(),
            'filename'=>$this->string(),
            'status'=>$this->smallInteger(2),
            'user_id'=>$this->integer(),
        ]);

        $this->createTable('restaurant_files',
            [
                'rest_id'=>$this->integer(),
                'files_id'=>$this->integer(),
                'created_ts'=>$this->integer(),
                'position'=>$this->smallInteger(2),
            ]);

        $this->addPrimaryKey('restaurant_files_pk','restaurant_files',['rest_id','files_id']);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190810_104415_restaurants cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190810_104415_restaurants cannot be reverted.\n";

        return false;
    }
    */
}
