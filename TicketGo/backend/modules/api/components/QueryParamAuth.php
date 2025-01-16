<?php
namespace backend\modules\api\components;

use Yii;
use common\models\User;
use yii\filters\auth\AuthMethod;
use yii\web\UnauthorizedHttpException;
use yii\web\ForbiddenHttpException;

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

