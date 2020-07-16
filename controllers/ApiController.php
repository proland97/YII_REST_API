<?php
namespace app\controllers;

use app\models\User;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use Yii;


class ApiController extends ActiveController
{
    //Authentication
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        //$behaviors['authenticator']['only'] = ['create', 'update', 'delete'];
        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::class
        ];
        return $behaviors;
    }

    protected function isAdmin(){
        return Yii::$app->user->id === 2;
    }
}