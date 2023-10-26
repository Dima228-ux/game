<?php


namespace app\models;


class StatisticsForm extends Model
{
    public $id_user;
    public $count_wins;
    public $count_defeats;
    public $count_draws;
    public $count_game;

    /**
     *  constructor.
     *
     * @param Statistics $statistic
     */

    public function __construct(Statistics $statistic)
    {
        parent::__construct($statistic);
        $this->setAttributes($this->_entity->getAttributes(), false);
    }

    public function save(){
        /** @var Statistics $statistic */
        $statistic = $this->_entity;
        $statistic->id_user=\Yii::$app->user->id;
        $statistic->count_defeats=$this->count_defeats;
        $statistic->count_wins=$this->count_wins;
        $statistic->count_draws=$this->count_draws;
        $statistic->count_game=$this->count_game;

        if($statistic->save()){
            return true;
        }
        return false;
    }

    public static function uploadStatisticUser($state){
        $is_statistic=Statistics::find()->where(['id_user'=>\Yii::$app->user->id])->exists();
        if($is_statistic){
            $statistic=Statistics::find()->where(['id_user'=>\Yii::$app->user->id])->one();
            $where = ['id_user' => $statistic['id_user']];
            $collum='';

            if($state==='win'){
                $collum=['count_wins'=>$statistic['count_wins']+1,'count_game'=>$statistic['count_game']+1];
            }
            elseif($state==='lose'){
                $collum=['count_defeats'=>$statistic['count_defeats']+1,'count_game'=>$statistic['count_game']+1];
            }
            elseif($state==='draws'){
                $collum=['count_draws'=>$statistic['count_draws']+1,'count_game'=>$statistic['count_game']+1];
            }

            Statistics::updateAll($collum,$where);
            return true;
        }
        return false;
    }
}