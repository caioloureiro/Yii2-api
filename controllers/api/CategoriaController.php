<?php

namespace app\controllers\api;

use yii\rest\ActiveController;
use yii\web\Response;
use app\models\Categorias;

class CategoriaController extends ActiveController
{
    public $modelClass = 'app\models\Categorias';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 86400,
            ],
        ];

        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete']);
        return $actions;
    }

    public function actionDelete($id)
    {
        $model = Categorias::findOne($id);
        
        if (!$model) {
            \Yii::$app->response->statusCode = 404;
            return ['status' => 'error', 'message' => 'Categoria não encontrada'];
        }

        if ($model->softDelete()) {
            return ['status' => 'success', 'message' => 'Categoria marcada como inativa'];
        }

        \Yii::$app->response->statusCode = 400;
        return ['status' => 'error', 'message' => 'Erro ao marcar categoria como inativa', 'errors' => $model->errors];
    }

    public function actionInativos()
    {
        return Categorias::find()->where(['ativo' => '0'])->all();
    }

    public function actionAtivar($id)
    {
        $model = Categorias::findOne($id);
        
        if (!$model) {
            \Yii::$app->response->statusCode = 404;
            return ['status' => 'error', 'message' => 'Categoria não encontrada'];
        }

        $model->ativo = '1';
        if ($model->save(false)) {
            return ['status' => 'success', 'message' => 'Categoria reativada com sucesso'];
        }

        \Yii::$app->response->statusCode = 400;
        return ['status' => 'error', 'message' => 'Erro ao reativar categoria', 'errors' => $model->errors];
    }

    public function actionIndex()
    {
        return Categorias::find()->where(['ativo' => '1'])->all();
    }
}