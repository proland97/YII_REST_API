<?php


namespace app\controllers;
use yii\web\ErrorAction;
use yii\web\Response;

class SiteController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    public function actionIndex()
    {
        \Yii::$app->response->format = Response::FORMAT_HTML;
        return $this->render('index');
    }

}