<?php


namespace app\controllers;
use yii\web\ErrorAction;
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
        return $this->render('index');
    }

}