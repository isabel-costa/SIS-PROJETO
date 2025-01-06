<?php
namespace backend\modules\api\components;

use yii\filters\auth\AuthMethod;

class CustomAuth extends AuthMethod
{
        public function authenticate($user, $request, $response) {
            $token = $request->getQueryParam('access-token');
            if ($token === null) {
                return null; //Se nenhum token fornecido
            }

            $identity = $user->loginByAccessToken($token, get_class($this));
            if ($identity === null) {
                $this->handleFailure($response);
            }

            return $identity;
        }
}
