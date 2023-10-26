<?php

use yii\db\Migration;

/**
 * Class m231025_194225_statistics
 */
class m231025_194225_statistics extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%statistics}}', [
            'id' => $this->primaryKey(),
            'id_user'=>$this->integer(),
            'count_game'=>$this->integer(),
            'count_wins' => $this->integer(),
            'count_defeats' => $this->integer(),
            'count_draws' => $this->boolean(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%statistics}}');
    }
}
