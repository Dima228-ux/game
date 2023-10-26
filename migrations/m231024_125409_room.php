<?php

use yii\db\Migration;

/**
 * Class m231024_125409_room
 */
class m231024_125409_room extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%room}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'count_users' => $this->integer(),
            'is_free' => $this->boolean(),
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%room}}');
    }


}
