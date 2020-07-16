<?php
namespace app\controllers;

use app\models\Group;
use yii\rest\ActiveController;

class GroupController extends ApiController
{
    public $modelClass = Group::class;
}