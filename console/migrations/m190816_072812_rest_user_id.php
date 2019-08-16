<?php

use yii\db\Migration;

/**
 * Class m190816_072812_rest_user_id
 */
class m190816_072812_rest_user_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('restaurant','user_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190816_072812_rest_user_id cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190816_072812_rest_user_id cannot be reverted.\n";

        return false;
    }
    */
}
