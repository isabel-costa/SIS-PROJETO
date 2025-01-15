<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;
use common\models\User;
use common\models\Profile;
use yii\web\Response;

class AuthController extends Controller
{
    //Desativarbilitar a validação CSRF para facilitar o login via API
    public $modelClass = 'common\models\User';
    public $enableCsrfValidation = false;

    public function actionLogin()
    {
        $userModel = new $this->modelClass;
        $request = Yii::$app->request; // Receber dados via query parameter
        $username = $request->getBodyParam('username');
        $password = $request->getBodyParam('password');

        // Verifca se o username e a password foram fornecidos
        if (empty($username) || empty($password)) {
            throw new BadRequestHttpException('Missing required parameters.');
        }

        // Encontra o utilizador na bd
        $user = User::findOne(['username' => $username]);

        $profile = Profile::findOne(['user_id' => $user->id]);

        // Verifica se o user existe e se a password é válida
        if (!$user || !$user->validatePassword($password)) {
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
}
