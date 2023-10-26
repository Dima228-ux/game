<?php


namespace app\controllers;


use app\models\Statistics;

class StatisticsController extends BasickController
{
    public function actionGetStatistics()
    {
        $statistic=Statistics::find()->where(['id_user'=>\Yii::$app->user->id])->one();

        return $this->render('index', ['statistic' => $statistic]);
    }
}