<?php
namespace backend\modules\api\controllers;

use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

class LinhaFaturaController extends ActiveController {
    public $modelClass = 'common\models\LinhaFatura';

    public function behaviors()
    {
        $behaviors = parent::behaviors(); $behaviors['authenticator'] = [
        'class' => QueryParamAuth::className(),
        //only=> ['index'], //Apenas para o GET
    ];
        return $behaviors;
    }
}
