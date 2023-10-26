<?php


namespace app\controllers;


use app\models\Room;
use app\models\SessionGame;
use app\models\SessionGameForm;
use app\models\Statistics;
use app\models\StatisticsForm;
use Yii;
use yii\base\BaseObject;
use yii\helpers\Url;
use yii\web\HttpException;

class SessionController extends BasickController
{

    public function actionEntrance()
    {
        $id_room = $this->getInt('id');

        $session = Yii::$app->session;
        if ($session->isActive) {
            if (!$session['game']) {
                if ($session['win'] == 'you') {
                    $this->setFlash('success', 'Congratulations you won');
                   if(!StatisticsForm::uploadStatisticUser('win')){
                       $statistic=new StatisticsForm(new Statistics());
                       $statistic->count_game=1;
                       $statistic->count_wins=1;
                       $statistic->save();
                   }
                } elseif ($session['win'] == 'false') {
                    if(!StatisticsForm::uploadStatisticUser('lose')){
                        $statistic=new StatisticsForm(new Statistics());
                        $statistic->count_game=1;
                        $statistic->count_defeats=1;
                        $statistic->save();
                    }
                    $this->setFlash('error', 'Unfortunately you lost');
                }

            }elseif ($session['game']==='stop'){
                if(!StatisticsForm::uploadStatisticUser('draws')){
                     $statistic=new StatisticsForm(new Statistics());
                     $statistic->count_game=1;
                     $statistic->count_draws=1;
                     $statistic->save();
                }
                $this->setFlash('error', 'Unfortunately Draw in the game');
            }
        }

        if (!$id_room) {
            $game = SessionGame::find()->where(['id_user1' => Yii::$app->user->id])->one();
            if (!$game) {
                $game = SessionGame::find()->where(['id_user2' => Yii::$app->user->id])->one();
                if (!$game) {
                    throw new HttpException(404);
                }
            }
            return $this->render('index', [
                'game' => $game,
            ]);
        }

        $game = SessionGame::find()->where(['id_room' => $id_room])->one();

        if (!$game) {
            throw new HttpException(404);
        }

        Room::updateRoom($id_room);

        $game = SessionGame::find()->where(['id_room' => $id_room])->one();

        return $this->render('index', [
            'game' => $game,
        ]);
    }

    public function actionMovePlayer()
    {
        if ($this->isPost()) {
            $id_room = $this->post()['id_room'];
            $id_collum = $this->post()['id_collum'];
            if (SessionGameForm::movePlaer($id_room, $id_collum)) {
                $user_win = SessionGameForm::winnerPaler($id_room);
                SessionGameForm::statusGame($user_win);
                return $this->redirect(Url::toRoute(['session/entrance']));
            }

        }
    }

    public function actionUploadMove()
    {
        if ($this->isPost()) {
            $id_room = $this->post()['id_room'];
            $is_room=SessionGame::find()->where(['id_room'=>$id_room])->exists();

            if(!$is_room){
                $session = Yii::$app->session;
                if ($session->isActive) {
                    $session->destroy();
                }
                return $this->redirect(Url::toRoute(['rooms/get-rooms']));
            }
            if (SessionGameForm::uploadMove($id_room)) {
                $user_win = SessionGameForm::winnerPaler($id_room);
                SessionGameForm::statusGame($user_win);
                return $this->redirect(Url::toRoute(['session/entrance']));
            }
        }

    }

    public function actionExit()
    {
        if ($this->isPost()) {
            $id_room = $this->post()['id_room'];
            $session = Yii::$app->session;
            if ($session->isActive) {
                $session->destroy();
            }

            SessionGame::deleteAll(['id_room' => $id_room]);
            Room::deleteAll(['id' => $id_room]);
            return $this->redirect(Url::toRoute(['rooms/get-rooms']));

        }
        return $this->redirect(Url::toRoute(['rooms/get-rooms']));
    }

    public function actionBreakGame(){

        $id_room=$this->getInt('id');

        if ($id_room>0) {
            SessionGame::deleteAll(['id_room' => $id_room]);
            Room::deleteAll(['id' => $id_room]);
            return $this->redirect(Url::toRoute(['rooms/get-rooms']));
        }
    }
}