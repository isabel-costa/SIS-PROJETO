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

    public function actionSignup()
    {
        $request = Yii::$app->request;
        $username = $request->getBodyParam('username');
        $email = $request->getBodyParam('email');
        $password = $request->getBodyParam('password');
        $nome = $request->getBodyParam('nome');
        $datanascimento = $request->getBodyParam('datanascimento');
        $nif = $request->getBodyParam('nif');
        $morada = $request->getBodyParam('morada');
        $dataregisto = date('Y-m-d H:i:s'); // Data de registo atual

        // Verifica se todos os parâmetros obrigatórios foram fornecidos
        if (empty($username) || empty($email) || empty($password) || empty($nome) || empty($datanascimento) || empty($nif) || empty($morada)) {
            throw new BadRequestHttpException('Missing required parameters.');
        }

        // Verifica se o username ou email já existem
        if (User::findOne(['username' => $username]) || User::findOne(['email' => $email])) {
            throw new BadRequestHttpException('Username or email already exists.');
        }

        // Cria um novo utilizador
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey(); // Gera o auth key

        if ($user->save()) {
            // Cria um perfil associado ao utilizador
            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->username = $username;
            $profile->password = $user->password_hash;
            $profile->nome = $nome;
            $profile->datanascimento = $datanascimento;
            $profile->nif = $nif;
            $profile->morada = $morada;
            $profile->dataregisto = $dataregisto;

            if ($profile->save()) {
                return ['auth_key' => $user->auth_key];
            } else {
                // Se o perfil não for salvo, apaga o utilizador criado
                $user->delete();
                throw new BadRequestHttpException('Error creating profile.');
            }
        } else {
            throw new BadRequestHttpException('Error creating user.');
        }
    }
}
