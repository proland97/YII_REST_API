<?php

use yii\db\Migration;

/**
 * Class m200701_141204_users
 */
class m200701_141204_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'auth_key' => $this->string()->notNull(),
            'access_token' => $this->string()->notNull()->unique(), //TODO migrations
            'cratetime' => $this->dateTime()->defaultValue('now()')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }

}
