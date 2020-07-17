<?php
namespace app\controllers;

use app\models\User;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\VarDumper;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use Yii;


class ApiController extends ActiveController
{
    //Authentication
    public function behaviors()
    {
        $behaviors = parent::behaviors();
//        $behaviors['authenticator']['only'] = ['create', 'update', 'delete'];
//        $behaviors['authenticator']['authMethods'] = [
//            'class' => HttpBearerAuth::class,
//            'header' => 'auth',
//        ];
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                //HttpBearerAuth::class,
                [
                    'class'=>HttpBearerAuth::class,
                    'header'=>'auth',
                ],
            ]
        ];
        //Yii::error(VarDumper::dumpAsString($behaviors['authenticator']['authMethods']), __METHOD__);
        return $behaviors;
    }

    protected function isAdmin(){
        return Yii::$app->user->id === 2;
    }
}