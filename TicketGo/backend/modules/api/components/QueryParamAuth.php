<?php
namespace backend\components;

use Yii;
use yii\filters\auth\AuthMethod;
use yii\web\UnauthorizedHttpException;

class QueryParamAuth extends AuthMethod
{
    public function authenticate($user, $request, $response)
    {
        $authToken = $request->getQueryParam('token');
        if (!empty($authToken)) {
            $identity = User::findIdentityByAccessToken($authToken);
            if ($identity) {
                return $identity;
            }
            throw new ForbiddenHttpException('No authentication');
        }
        throw new ForbiddenHttpException('Sem Token');
    }
}

