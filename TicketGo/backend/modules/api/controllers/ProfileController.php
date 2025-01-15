<?php
namespace backend\modules\api\controllers;

use app\models\Profile;
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

    public function actionFavoritos($id)
    {
        //Vai buscar o utilizador
        $user = \common\models\User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException("User not found.");
        }

        //Vai buscar o perfil associado ao utilizador
        $profile = $user->getProfile()->one();
        if (!$profile) {
            throw new NotFoundHttpException("Profile not found for this user.");
        }

        //Valida as permissões
        if (!\Yii::$app->user->can('viewProfile', ['profile' => $profile])) {
            throw new ForbiddenHttpException("You don't have permission to access this user's favorites.");
        }

        //Vai buscar os favoritos associados ao perfil
        $favoritos = $profile->getFavoritos()->all();
        return $favoritos; //Retorna os dados em JSON
    }

    public function actionCarrinho($id)
    {
        //Vai buscar o utilizador
        $user = \common\models\User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException("User not found.");
        }

        //Vai buscar o perfil associado ao utilizador
        $profile = $user->getProfile()->one();
        if (!$profile) {
            throw new NotFoundHttpException("Profile not found for this user.");
        }

        //Valida as permissões
        if (!\Yii::$app->user->can('viewProfile', ['profile' => $profile])) {
            throw new ForbiddenHttpException("You don't have permission to access this user's cart.");
        }

        //Vai buscar o carrinho associado ao perfil
        $carrinhos = $profile->getCarrinhos()->all();
        return $carrinhos; //Retorna os dados em JSON
    }
}
