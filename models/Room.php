<?php


namespace app\models;


use Yii;
use yii\db\ActiveRecord;

/**
 * Class Room
 * @package app\models
 *  @property int $id [int(11)]
 * @property string $name [varchar(255)]
 * @property int $count_users  [int(11)]
 * @property bool $is_free  [tinyint(1)]
  */

class Room extends ActiveRecord
{
    public const FREE_ROOM=1;
    public const NOT_FREE_ROOM=0;

    public static function tableName(): string
    {
        return 'room';
    }

    /**
     * @param $status
     *
     * @return string|string[]
     */
    public static function getStatuses($status = null)
    {
        $list = [
            self::FREE_ROOM => 'Spare',
            self::NOT_FREE_ROOM => 'Occupied',
        ];

        return $list[$status] ?? $list;
    }

    public static function updateRoom($id_room){
        $where = ['id_room' => $id_room];
        SessionGame::updateAll(['id_user2'=>Yii::$app->user->id],$where);

        $where=['id' => $id_room];
        Room::updateAll(['count_users'=>2,'is_free'=>self::NOT_FREE_ROOM],$where);

    }
}