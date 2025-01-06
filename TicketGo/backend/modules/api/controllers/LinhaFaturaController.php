<?php
namespace backend\modules\api\controllers;

use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

class LinhaFaturaController extends ActiveController {
    public $modelClass = 'common\models\LinhaFatura';

    public function checkAccess($action, $model = null, $params = [])
    {
        // Bloqueia qualquer método que não seja GET
        if (in_array($action, ['create', 'update', 'delete'])) {
            throw new \yii\web\ForbiddenHttpException('You are not allowed to perform this action');
        }
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
        ];

        return $behaviors;
    }
}
