<?php


namespace app\controllers;


use app\models\Room;
use app\models\RoomsForm;
use app\models\SessionGame;
use app\models\SessionGameForm;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\HttpException;

class RoomsController extends BasickController
{

    public function actionGetRooms()
    {
        $session = Yii::$app->session;
        if ($session->isActive) {
            $session->destroy();
        }

        $is_room=SessionGame::find()->where(['id_user1'=>Yii::$app->user->id])
            ->orWhere(['id_user2'=>Yii::$app->user->id])->exists();
        if($is_room){
            return $this->redirect(Url::toRoute(['session/entrance']));
        }
        $this->view->title = 'Rooms';

        $rooms = Room::find()->all();

        $model = new RoomsForm(new Room());
        $count_free=Room::find()->where(['is_free'=>true])->count();

        return $this->render('index', ['rooms' => $rooms, 'model' => $model,'count_free'=>$count_free]);
    }

    public function actionAddRoom()
    {
        $room = new RoomsForm(new Room());

        if ($this->isPost()) {
            if ($room->load($this->post()) && $room->save()) {
                $this->setFlash('success', 'room  ' . Html::encode($room->name) . ' successfully added');
                return $this->redirect(Url::toRoute(['session/entrance']));
            }
            $this->setFlash('error', 'Error parameter names should not be repeated');
            return $this->redirect(Url::toRoute(['rooms/get-rooms']));
        }

        return $this->redirect(Url::toRoute(['rooms/get-rooms']));
    }

    public function actionUploadRoom()
    {

        if ($this->isPost()) {
            $id = $this->post()['id'];
            $count = $this->post()['count'];
            $count_free=$this->post()['count_free'];

            $answer = Room::find()->where(['>', 'id', $id])->exists();
            $count_db=Room::find()->count();
            $count_free_db=Room::find()->where(['is_free'=>true])->count();



            if ($answer || $count_db<$count|| $count_free_db<$count_free) {
                return $this->redirect(Url::toRoute(['rooms/get-rooms']));
            }
        }

    }



}