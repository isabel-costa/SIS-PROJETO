<?php
namespace backend\modules\api\controllers;

use common\models\Favorito;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\filters\ContentNegotiator;

class FavoritoController extends ActiveController {

    public $modelClass = 'common\models\Favorito';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    public function authCustom($token)
    {
        $user = User::findIdentityByAccessToken($token);
        if ($user) {
            $this->user = $user;
            return $user_;
        }
        throw new ForbiddenHttpException('No authentication'); //403
    }

    public function checkAccess($action, $model = null, $params = [])
    {
            if (isset(Yii::$app->params['id']) && Yii::$app->params['id'] == 1) {
                if ($action === "delete") {
                    throw new \yii\web\ForbiddenHttpException('Proibido');
                }
            }
    }
    

    public function actionProfilefav($profile_id)
    {
        $favoritos = $this->modelClass::find()->where(['profile_id' => $profile_id])->all();

        if ($favoritos) {
            return $favoritos;
        } else {
            return [
                'success' => false,
                'message' => 'Este utilizador não tem eventos favoritos.',
            ];
        }
    }

}
