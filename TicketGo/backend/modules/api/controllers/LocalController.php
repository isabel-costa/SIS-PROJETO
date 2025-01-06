<?php
namespace backend\modules\api\controllers;

use yii\rest\ActiveController;

class LocalController extends ActiveController {
    public $modelClass = 'common\models\Local';

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
