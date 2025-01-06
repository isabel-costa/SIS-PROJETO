<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;

class BilheteController extends ActiveController
{
    public $modelClass = 'common\models\Bilhete';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
        ];

        return $behaviors;
    }

}
