<?php

use yii\db\Migration;

/**
 * Class m231024_125619_session_game
 */
class m231024_125619_session_game extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%session_game}}', [
            'id' => $this->primaryKey(),
            'id_room' => $this->integer(),
            'id_user1'=>$this->integer(),
            'id_user2'=>$this->integer(),
            'collum1' => $this->string(20),
            'collum2' => $this->string(20),
            'collum3' => $this->string(20),
            'collum4' => $this->string(20),
            'collum5' => $this->string(20),
            'collum6' => $this->string(20),
            'collum7' => $this->string(20),
            'collum8' => $this->string(20),
            'collum9' => $this->string(20),
            'move_player1' => $this->boolean(),
            'move_player2' => $this->boolean(),
            'count'=>$this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%session_game}}');
    }


}
