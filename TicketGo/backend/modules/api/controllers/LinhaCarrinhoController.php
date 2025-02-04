<?php
namespace backend\modules\api\controllers;

use backend\modules\api\components\QueryParamAuth;
use yii\rest\ActiveController;
use common\models\mqttPublisher;

class LinhaCarrinhoController extends ActiveController {
    public $modelClass = 'common\models\LinhaCarrinho';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
        ];

        return $behaviors;
    }
}
