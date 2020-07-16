<?php
namespace app\controllers;

use app\models\Message;
use app\controllers\ApiController;
use app\models\User;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use Yii;
use yii\web\NotFoundHttpException;

class MessageController extends ApiController
{
    public $modelClass = Message::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['index'], $actions['view'],$actions['delete'],$actions['update']);
        return $actions;
    }

    public function loadAll()
    {
        //Check user is admin
        if($this->isAdmin()){
            return Message::find()->all();
        }else{
            return Message::find()->ofUserId(Yii::$app->user->id)->all();
        }
    }
    public function loadOne($id)
    {
        //Check user is admin
        if($this->isAdmin()){
            return Message::find()->ofId($id)->one();
        }else{
            return Message::find()->ofUserId(Yii::$app->user->id)->ofId($id)->one();
        }
    }

    public function actionIndex()
    {
        $result = $this->loadAll();
        if(empty($result)){
            throw new NotFoundHttpException('Not found!');
        }else{
            return $result;
        }
    }

    public function actionView($id)
    {
        $result = $this->loadOne($id);
        if(empty($result)){
            throw new NotFoundHttpException('Not found!');
        }else{
            return $result;
        }
    }

    public function actionDelete($id)
    {
        $result = $this->loadOne($id);
        if(empty($result)){
            throw new NotFoundHttpException('Not found!');
        }else{
            $result->delete();
            return [
                'success' => true,
                'message' => 'Message deleted!'
            ];
        }
    }

    public function actionUpdate($id)
    {
        $message = $this->loadOne($id);
        $request = Yii::$app->request;
        if(empty($message)){
            throw new NotFoundHttpException('Not found!');
        }
        $message->message = isset($request->bodyParams['message']) ? $request->bodyParams['message'] : $message->message;
        $message->save();
        return [
            "success" => true,
            "message" => 'Message updated!'
        ];
    }

    public function actionCreate()
    {
        if(!isset(\Yii::$app->request->bodyParams['message'], Yii::$app->request->bodyParams['belongs_to_group'])){
            return [
                'success' => false,
                'message' => 'Message and belongs_to_group are required!'
            ];
        }

        $message = new Message();
        $message->message = Yii::$app->request->bodyParams['message'];
        $message->created_by = Yii::$app->user->id;
        $message->belongs_to_group = Yii::$app->request->bodyParams['belongs_to_group'];

        if($message->validate() && $message->save()){
            return [
                'success' => true,
                'message'=>'Message created'
            ];
        }else{
            return [
                'success' => false,
                'message'=>'Error during creating new message!',
                'errors' => $message->errors
            ];
        }
    }
}