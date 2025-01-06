<?php
namespace backend\components;

use Yii;
use yii\filters\auth\AuthMethod;
use yii\web\UnauthorizedHttpException;

class QueryParamAuth extends AuthMethod
{
    public function authenticate($user, $request, $response)
    {
        $accessToken = Yii::$app->request->get('access-token'); //Obtém o parâmetro de consulta

        if (empty($accessToken)) {
            throw new UnauthorizedHttpException('Access token is missing');
        }

        //Verificar a validade do token
        //Exemplo de verificação simples
        $userIdentity = \backend\models\User::findIdentityByAccessToken($accessToken);

        if ($userIdentity === null) {
            throw new UnauthorizedHttpException('Invalid access token');
        }

        //Se o token for válido, define o utilizador autenticado
        Yii::$app->user->login($userIdentity);
        return $userIdentity;
    }
}

