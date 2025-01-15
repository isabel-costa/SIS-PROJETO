<?php
namespace backend\modules\api\controllers;

use common\models\Profile;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

class ProfileController extends ActiveController {
    public $modelClass = 'common\models\Profile';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
        ];

        return $behaviors;
        
    }
}
