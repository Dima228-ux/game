<?php

use yii\db\Migration;

/**
 * Class m231023_164749_users
 */
class m231023_164749_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255),
            'email' => $this->string(255),
            'password' => $this->string(255),
            'authKey' => $this->text(),
            'accessToken' => $this->string(32),
        ]);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
