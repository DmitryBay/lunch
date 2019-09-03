<?php

use yii\db\Migration;

/**
 * Class m190903_080406_menu_items_category
 */
class m190903_080406_menu_items_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('menu_items','category', $this->smallInteger(3));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190903_080406_menu_items_category cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190903_080406_menu_items_category cannot be reverted.\n";

        return false;
    }
    */
}
