<?php
namespace backend\modules\api\controllers;

use Yii;
use backend\modules\api\components\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use common\models\MetodoPagamento;
use common\models\mqttPublisher;

class MetodoPagamentoController extends ActiveController {
    public $modelClass = 'common\models\MetodoPagamento';

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
