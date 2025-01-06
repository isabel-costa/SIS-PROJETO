<?php
namespace backend\modules\api\controllers;

use common\models\Carrinho;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

class CarrinhoController extends ActiveController {
    public $modelClass = 'common\models\Carrinho';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
        ];

        return $behaviors;
    }

}
