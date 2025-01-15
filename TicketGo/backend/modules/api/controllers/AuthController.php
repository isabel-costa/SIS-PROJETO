<?php

namespace backend\controllers\api;

use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;
use common\models\User; // O modelo de usuários
use yii\web\Response;

class AuthController extends ActiveController
{
    // Desabilitar a validação CSRF para facilitar o login via API
    public $enableCsrfValidation = false;

    // Ação de Login
    public function actionLogin()
    {
        $data = Yii::$app->request->get(); // Receber dados via query parameter

        // Verifique se o nome de usuário e a senha foram fornecidos
        if (empty($data['username']) || empty($data['password'])) {
            throw new BadRequestHttpException('Missing required parameters.');
        }

        // Encontre o usuário no banco de dados
        $user = User::findOne(['username' => $data['username']]);

        // Verifique se o usuário existe e se a senha é válida
        if ($user === null || !$user->validatePassword($data['password'])) {
            throw new UnauthorizedHttpException('Invalid credentials.');
        }

        // Gerar o auth key se não existir
        if (empty($user->auth_key)) {
            $user->generateAuthKey();  // Método que gera o auth key
            if (!$user->save()) {
                throw new UnauthorizedHttpException('Error generating auth key.');
            }
        }

        // Retornar o auth key
        return ['auth_key' => $user->auth_key];
    }

    // Ação para acessar dados protegidos
    public function actionProtectedData()
    {
        $authKey = Yii::$app->request->get('auth_key'); // Pega o auth_key da query parameter

        // Verificar se o auth_key foi fornecido
        if (empty($authKey)) {
            throw new UnauthorizedHttpException('Access token is missing.');
        }

        // Validar o auth_key
        $user = User::findIdentityByAuthKey($authKey);
        
        if ($user === null) {
            throw new UnauthorizedHttpException('Invalid auth key.');
        }

        // Retorne os dados protegidos
        return [
            'message' => 'Protected data accessed!',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ]
        ];
    }
}
