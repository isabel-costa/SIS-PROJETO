<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;

class BilheteController extends ActiveController
{
    public $modelClass = 'common\models\Bilhete';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            //only=> ['index'], //Apenas para o GET
        ];
        return $behaviors;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if ($action === 'delete') {
            throw new \yii\web\ForbiddenHttpException('Não Autorizado!');

        } else if ($action === 'post') {
            throw new \yii\web\ForbiddenHttpException('Não Autorizado!');

        } else if ($action === 'put') {
            throw new \yii\web\ForbiddenHttpException('Não Autorizado!');
        }
    }
}
