<?php

use yii\db\Migration;

/**
 * Class m200708_143543_messages
 */
class m200708_143543_messages extends Migration
{

    public function safeUp()
    {
        $this->createTable('messages', [
            'message_id' => $this->primaryKey(),
            'message' => $this->string(),
            'created_by' => $this->integer(),
            'belongs_to_group' => $this->integer(),
            'createtime' => 'timestamp default now()'
        ]);


        $this->addForeignKey('FK_message_user_user_id','messages','created_by','users','id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_message_group_group_id','messages','belongs_to_group','groups','group_id', 'CASCADE', 'CASCADE');

        $this->insert('messages', ['message' => ' this is amessage', 'created_by' => 1, 'belongs_to_group' => 1]);
        $this->insert('messages', ['message' => 'admin message', 'created_by' => 2, 'belongs_to_group' => 1]);
        $this->insert('messages', ['message' => 'some message', 'created_by' => 1, 'belongs_to_group' => 2]);

    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'FK_message_user_user_id',
            'messages'
        );

        $this->dropForeignKey(
            'FK_message_group_group_id',
            'messages'
        );

        $this->dropTable('messages');
    }

}
