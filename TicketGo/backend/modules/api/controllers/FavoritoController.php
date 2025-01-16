<?php
namespace backend\modules\api\controllers;

use common\models\Favorito;
use Yii;
use backend\modules\api\components\QueryParamAuth;
use yii\rest\ActiveController;
use yii\filters\ContentNegotiator;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\BadRequestHttpException;
use common\models\mqttPublisher;

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
    

    public function actionGetProfile($profile_id)
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

    public function actionDeleteFav($evento_id) {
        $favorito = $this->modelClass::findOne(['evento_id' => $evento_id]);

        if ($favorito) {
            if ($favorito->delete()) {
                return [
                    'success' => true,
                    'message' => 'Evento eliminado com sucesso da lista de favoritos.',
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erro ao eliminar o evento da lista de favoritos.',
                ];
            }
        } else {
            throw new NotFoundHttpException('Evento favorito não encontrado.');
        }
    }

    public function actionAddFav($profile_id, $evento_id)
    {
        // Verificar se o evento existe
        $evento = Evento::findOne($evento_id);
        if (!$evento) {
            throw new NotFoundHttpException('Evento não encontrado.');
        }

        // Verificar se o favorito já existe
        $favoritoExistente = Favorito::findOne(['profile_id' => $profile_id, 'evento_id' => $evento_id]);
        if ($favoritoExistente) {
            return [
                'success' => false,
                'message' => 'Este evento já está nos favoritos.',
            ];
        }

        // Adicionar o evento aos favoritos
        $favorito = new Favorito();
        $favorito->profile_id = $profile_id;
        $favorito->evento_id = $evento_id;

        if ($favorito->save()) {
            return [
                'success' => true,
                'message' => 'Evento adicionado com sucesso aos favoritos.',
            ];
        } else {
            throw new BadRequestHttpException('Erro ao adicionar o evento aos favoritos.');
        }
    }
}
