<?php

use yii\db\Migration;

/**
 * Class m190812_062539_rest_status
 */
class m190812_062539_rest_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('restaurant','status',$this->smallInteger(2));
        $this->addColumn('restaurant','price_category',$this->smallInteger(2));



    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190812_062539_rest_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190812_062539_rest_status cannot be reverted.\n";

        return false;
    }
    */
}
