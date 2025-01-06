<?php

namespace backend\controllers\api;

use common\models\User;
use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\web\ForbiddenHttpException;

class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // Aumente o suporte para CORS ou outras necessidades
        return $behaviors;
    }

    // Registo de um novo utilizador
    public function actionSignup()
    {
        $model = new User();
        $model->username = Yii::$app->request->post('username');
        $model->password = Yii::$app->request->post('password');

        // Validação do modelo
        if ($model->signup()) {
            return [
                'status' => 'success',
                'message' => 'User created successfully!',
            ];
        }

        // Se não passou na validação
        return [
            'status' => 'error',
            'message' => 'Failed to create user!',
        ];
    }

    // Login de um utilizador
    public function actionLogin()
    {
        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');

        $user = User::find()->where(['username' => $username])->one();

        if ($user && $user->validatePassword($password)) {
            $accessToken = $user->generateAuthKey();
            $user->save(); // Atualiza o token na bd

            return [
                'status' => 'success',
                'access-token' => $accessToken, // Retorna o token de autenticação
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Invalid username or password',
        ];
    }
}
