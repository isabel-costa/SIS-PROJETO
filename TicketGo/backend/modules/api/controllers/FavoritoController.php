<?php
namespace backend\modules\api\controllers;

use common\models\Favorito;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

class FavoritoController extends ActiveController {
    public $modelClass = 'common\models\Favorito';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
        ];

        return $behaviors;
    }

}
