<?php
namespace backend\modules\api\controllers;

use Yii;
use common\models\Profile;
use backend\modules\api\components\QueryParamAuth;
use yii\rest\ActiveController;
use common\models\mqttPublisher;

class ProfileController extends ActiveController {
    public $modelClass = 'common\models\Profile';

    public function checkAccess($action, $model = null, $params = [])
    {
        // Bloqueia qualquer método que não seja GET e PUT
        if (in_array($action, ['create', 'delete'])) {
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

    public function actionUpdateProfile($id)
    {
        $profile = $this->findModel($id);

        if ($profile->load(Yii::$app->request->post(), '') && $profile->save()) {
            return $profile;
        }

        return ['message' => 'Failed to update profile details', 'errors' => $profile->errors];
    }

}
