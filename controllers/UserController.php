<?php
namespace app\controllers;

use app\models\User;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\VarDumper;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use app\controllers\ApiController;
use Yii;
use yii\web\NotFoundHttpException;


class UserController extends ApiController
{
    public $modelClass = User::class;
    /**
     * Checks the privilege of the current user.
     *
     * This method should be overridden to check whether the current user has the privilege
     * to run the specified action against the specified data model.
     * If the user does not have access, a [[ForbiddenHttpException]] should be thrown.
     *
     * @param string $action the ID of the action to be executed
     * @param User $model the model to be accessed. If null, it means no specific model is being accessed.
     * @param array $params additional parameters
     * @throws ForbiddenHttpException if the user does not have access
     */
    /*
    public function checkAccess($action, $model = null, $params = [])
    {
        if(in_array($action, ['update','delete']) && $model->id !== Yii::$app->user->id && \Yii::$app->user->id !== 2){
            throw new ForbiddenHttpException("You do not have permission for this");
        }

        if(in_array($action, ['index',]) && \Yii::$app->user->id !== 2 ){
            throw new ForbiddenHttpException("You do not have permission for this");
        }
        if(in_array($action, ['view',]) && $model->id !== \Yii::$app->user->id && \Yii::$app->user->id !== 2){
            throw new ForbiddenHttpException("You do not have permission for this");
        }
    }
    */

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['view'],$actions['index'],$actions['delete'],$actions['update']);
        return $actions;
    }

    public function loadAll()
    {
        //Check user is admin
        if($this->isAdmin()){
            return User::find()->all();
        }else{
            return User::find()->ofId(Yii::$app->user->id)->all();
        }
    }

    public function loadOne($id)
    {
        //Check user is admin
        if($this->isAdmin()){
            return User::find()->ofId($id)->one();
        }else{
            return User::find()->ofId(Yii::$app->user->id)->ofId($id)->one();
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

    public function actionIndex()
    {
        //Yii::error(VarDumper::dumpAsString($this->behaviors['authenticator']), __METHOD__);
        $result = $this->loadAll();
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
        $user = $this->loadOne($id);
        $request = Yii::$app->request;
        if(empty($user)){
            throw new NotFoundHttpException('Not found!');
        }
        $user->username = isset($request->bodyParams['username']) ? $request->bodyParams['username'] : $user->username;
        $user->password = isset($request->bodyParams['password']) ? Yii::$app->security->generatePasswordHash($request->bodyParams['password']) : $user->password;
        $user->save();
        return [
            "success" => true,
            "message" => 'User updated!'
        ];
    }

    public function actionCreate()
    {
        if(!isset(\Yii::$app->request->bodyParams['username'], Yii::$app->request->bodyParams['password'])){
            return [
                'success' => false,
                'message' => 'Username and password are required!'
            ];
        }

        $user = new User();
        $user->username = Yii::$app->request->bodyParams['username'];
        $user->password = Yii::$app->security->generatePasswordHash(Yii::$app->request->bodyParams['password']);
        $user->access_token = Yii::$app->security->generateRandomString();
        $user->auth_key = Yii::$app->security->generateRandomString();

        if($user->validate() && $user->save()){
            return [
                'success' => true,
                'message'=>'User created'
            ];
        }else{
            return [
                'success' => false,
                'message'=>'Error during creating new user',
                'erros' => $user->errors
            ];
        }
    }
}