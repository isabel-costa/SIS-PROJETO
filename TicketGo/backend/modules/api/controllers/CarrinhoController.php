<?php
namespace backend\modules\api\controllers;

use common\models\Carrinho;
use Yii;
use backend\modules\api\components\QueryParamAuth;
use yii\rest\ActiveController;
use common\models\mqttPublisher;

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

    public function actionGetProfile($profile_id)
    {
        $carrinhos = $this->modelClass::find()->where(['profile_id' => $profile_id])->all();

        if (!$carrinho) {
            throw new NotFoundHttpException('Carrinho não encontrado para este perfil.');
        }

        return $carrinho;
    }

    public function actionGetLinhasCarrinho($profile_id)
    {
        $carrinho = Carrinho::findOne(['profile_id' => $profile_id]);

        if (!$carrinho) {
            throw new NotFoundHttpException('Carrinho não encontrado para este perfil.');
        }

        return $carrinho->linhasCarrinhos;
    }

}
