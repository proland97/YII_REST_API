<?php

use yii\db\Migration;

/**
 * Class m200702_092917_groups
 */
class m200702_092917_groups extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('groups', [
            'group_id' => $this->primaryKey(),
            'group_name' => $this->string(),
            'createtime' => 'timestamp default now()'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('groups');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200702_092917_groups cannot be reverted.\n";

        return false;
    }
    */
}
