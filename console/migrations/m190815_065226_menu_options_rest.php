<?php

use yii\db\Migration;

/**
 * Class m190815_065226_menu_options_rest
 */
class m190815_065226_menu_options_rest extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('restaurant','type',$this->smallInteger(2)->notNull());
        $this->addColumn('restaurant','has_delivery',$this->smallInteger(1) );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190815_065226_menu_options_rest cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190815_065226_menu_options_rest cannot be reverted.\n";

        return false;
    }
    */
}
