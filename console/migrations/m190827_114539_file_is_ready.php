<?php

use yii\db\Migration;

/**
 * Class m190827_114539_file_is_ready
 */
class m190827_114539_file_is_ready extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('files','is_ready', $this->smallInteger(1)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190827_114539_file_is_ready cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190827_114539_file_is_ready cannot be reverted.\n";

        return false;
    }
    */
}
