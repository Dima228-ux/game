<?php


namespace app\models;


use yii\db\ActiveRecord;

/**
 * Class Statistics
 * @package app\models
 *  @property int $id [int(11)]
 * @property int $id_user [int(11)]
 * @property int $count_wins  [int(11)]
 * @property int $count_defeats  [int(11)]
 * @property int $count_draws  [int(11)]
 *  @property int $count_game  [int(11)]
 */
class Statistics extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'statistics';
    }
}