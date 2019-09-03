<?php

use yii\db\Migration;

/**
 * Class m190902_093329_menu_items
 */
class m190902_093329_menu_items extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('menu_items', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->string(1000),
            'price'=> $this->integer(),
            'status' => $this->smallInteger(2),
            'created_ts' => $this->integer(),
            'updated_ts' => $this->integer(),
            'user_id' => $this->integer(),
            'restaurant_id'=>$this->integer()
        ]);

        $this->createIndex('inx_menu_items_restaurant_id', 'menu_items','restaurant_id');
        $this->addForeignKey('fk_menu_items_restaurant_id', 'menu_items','restaurant_id','restaurant','id','cascade','cascade');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190902_093329_menu_items cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190902_093329_menu_items cannot be reverted.\n";

        return false;
    }
    */
}
