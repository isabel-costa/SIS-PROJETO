<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;

class CategoriaController extends ActiveController {
    public $modelClass = 'common\models\Categoria';

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
