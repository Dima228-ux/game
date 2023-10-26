<?php


namespace app\models;


use yii\db\ActiveRecord;

/**
 * Class SessionGame
 * @package app\models
 * @property int $id [int(11)]
 * @property int $id_room [int(11)]
 * @property int $id_user1 [int(11)]
 * @property int $id_user2 [int(11)]
 * @property string $collum1 [varchar(20)]
 * @property string $collum2 [varchar(20)]
 * @property string $collum3 [varchar(20)]
 * @property string $collum4 [varchar(20)]
 * @property string $collum5 [varchar(20)]
 * @property string $collum6 [varchar(20)]
 * @property string $collum7 [varchar(20)]
 * @property string $collum8 [varchar(20)]
 * @property string $collum9 [varchar(20)]
 * @property boolean $move_player1 [tinyint(1)]
 * @property boolean $move_player2 [tinyint(1)]
 * @property int $count [int(11)]
 */
class SessionGame extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'session_game';
    }


}