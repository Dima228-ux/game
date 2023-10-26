<?php


namespace app\models;


use Yii;

class SessionGameForm extends Model
{
    public $id;
    public $id_room;
    public $id_user1;
    public $id_user2;
//    public $collum1;
//    public $collum2;
//    public $collum3;
//    public $collum4;
//    public $collum5;
//    public $collum6;
//    public $collum7;
//    public $collum8;
//    public $collum9;
//    public $move_player1;
//    public $move_player2;

    /**
     *  constructor.
     *
     * @param SessionGame $game
     */

    public function __construct(SessionGame $game)
    {
        parent::__construct($game);
        $this->setAttributes($this->_entity->getAttributes(), false);
    }

    public function save()
    {
//        if (!$this->validate()) {
//            return false;
//        }

        /** @var SessionGame $game */
        $game = $this->_entity;
        $game->id_room = $this->id_room;
        $game->id_user1 = $this->id_user1;
        $game->id_user2 = $this->id_user2;


        if ($game->save()) {
            return true;
        }
        return false;
    }

    public static function movePlaer($id_room, $id_collum)
    {
        $id_user = Yii::$app->user->id;
        $char = '';
        $count=0;
        $session_game = SessionGame::find()->select(['id_user1', 'id_user2','count'])->where(['id_room' => $id_room])->one();

        if ($id_user == $session_game['id_user1']) {
            $char = 'x';
            $session_game['count']+=1;
            $where = ['id_room' => $id_room];
            SessionGame::updateAll(['collum' . $id_collum => $char,
                'move_player1' => true, 'move_player2' => false,'count'=>$session_game['count']], $where);

            return true;
        } elseif ($id_user == $session_game['id_user2']) {
            $char = '0';
            $session_game['count']+=1;
            $where = ['id_room' => $id_room];
            SessionGame::updateAll(['collum' . $id_collum => $char,
                    'move_player1' => false, 'move_player2' => true,'count'=>$session_game['count']]
                , $where);

            return true;
        }
        return false;
    }

    public static function winnerPaler($id_room)
    {
        $session = SessionGame::find()->where(['id_room' => $id_room])->one();
        if ($session['collum1'] === 'x' && $session['collum2'] === 'x' && $session['collum3'] === 'x') {
            return $session['id_user1'];
        } elseif ($session['collum4'] === 'x' && $session['collum5'] === 'x' && $session['collum6'] === 'x') {
            return $session['id_user1'];
        } elseif ($session['collum7'] === 'x' && $session['collum8'] === 'x' && $session['collum9'] === 'x') {
            return $session['id_user1'];
        } elseif ($session['collum1'] === 'x' && $session['collum5'] === 'x' && $session['collum9'] === 'x') {
            return $session['id_user1'];
        } elseif ($session['collum3'] === 'x' && $session['collum5'] === 'x' && $session['collum7'] === 'x') {
            return $session['id_user1'];
        } elseif ($session['collum1'] === 'x' && $session['collum4'] === 'x' && $session['collum7'] === 'x') {
            return $session['id_user1'];
        } elseif ($session['collum2'] === 'x' && $session['collum5'] === 'x' && $session['collum8'] === 'x') {
            return $session['id_user1'];
        } elseif ($session['collum3'] === 'x' && $session['collum6'] === 'x' && $session['collum9'] === 'x') {
            return $session['id_user1'];
        } elseif ($session['collum1'] === '0' && $session['collum2'] === '0' && $session['collum3'] === '0') {
            return $session['id_user2'];
        } elseif ($session['collum4'] === '0' && $session['collum5'] === '0' && $session['collum6'] === '0') {
            return $session['id_user2'];
        } elseif ($session['collum7'] === '0' && $session['collum8'] === '0' && $session['collum9'] === '0') {
            return $session['id_user2'];
        } elseif ($session['collum1'] === '0' && $session['collum5'] === '0' && $session['collum9'] === '0') {
            return $session['id_user2'];
        } elseif ($session['collum3'] === '0' && $session['collum5'] === '0' && $session['collum7'] === '0') {
            return $session['id_user2'];
        } elseif ($session['collum1'] === '0' && $session['collum4'] === '0' && $session['collum7'] === '0') {
            return $session['id_user2'];
        } elseif ($session['collum2'] === '0' && $session['collum5'] === '0' && $session['collum8'] === '0') {
            return $session['id_user2'];
        } elseif ($session['collum3'] === '0' && $session['collum6'] === '0' && $session['collum9'] === '0') {
            return $session['id_user2'];
        }
        elseif ($session['count'] == 9 ){
            return 'stop';
        }
        return false;
    }

    public static function uploadMove($id_room)
    {
        $session = SessionGame::find()->where(['id_room' => $id_room])->one();
        $id_user = Yii::$app->user->id;

        if ($session['id_user1'] == $id_user) {
            if ($session['move_player2']) {
                $where = ['id_room' => $id_room];
                SessionGame::updateAll(['move_player1' => false, 'move_player2' => false]
                    , $where);
                return true;
            }
            return false;
        }

        if ($session['id_user2'] == $id_user) {
            if ($session['move_player1']) {
                $where = ['id_room' => $id_room];
                SessionGame::updateAll(['move_player1' => false, 'move_player2' => false]
                    , $where);
                return true;
            }
            return false;
        }
        return false;
    }

    public static function statusGame($user_win)
    {
        $session = Yii::$app->session;
        if (!$session->isActive) {
            $session->open();
        }

        if (!$user_win) {
            $session['game'] = true;
            return;
        } elseif ($user_win > 0) {
            $session['game'] = false;
            if ($user_win == Yii::$app->user->id) {
                $session['win'] = 'you';
                return;
            }
            $session['win'] = 'false';

        }elseif ($user_win==='stop'){
            $session['game']='stop';
        }

    }


}