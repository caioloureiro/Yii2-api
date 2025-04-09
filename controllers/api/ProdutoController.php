<?php

namespace app\controllers\api;

use yii\rest\ActiveController;
use yii\web\Response;
use app\models\Produtos;

class ProdutoController extends ActiveController
{
    public $modelClass = 'app\models\Produtos';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        // Configuração do CORS
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

        // Configuração do formato de resposta
        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        return $behaviors;
    }

    // Sobrescreve ações padrão para usar soft delete
    public function actions()
    {
        $actions = parent::actions();
        
        // Sobrescreve a ação de delete
        unset($actions['delete']);
        
        return $actions;
    }

    /**
     * Ação para soft delete (marcar como inativo)
     */
    public function actionDelete($id)
    {
        $model = Produtos::findOne($id);
        
        if (!$model) {
            \Yii::$app->response->statusCode = 404;
            return ['status' => 'error', 'message' => 'Produto não encontrado'];
        }

        if ($model->softDelete()) {
            return ['status' => 'success', 'message' => 'Produto marcado como inativo'];
        }

        \Yii::$app->response->statusCode = 400;
        return ['status' => 'error', 'message' => 'Erro ao marcar produto como inativo', 'errors' => $model->errors];
    }

    /**
     * Lista produtos inativos
     */
    public function actionInativos()
    {
        return Produtos::find()->where(['ativo' => 0])->all();
    }

    /**
     * Reativa um produto
     */
    public function actionAtivar($id)
    {
        $model = Produtos::findOne($id);
        
        if (!$model) {
            \Yii::$app->response->statusCode = 404;
            return ['status' => 'error', 'message' => 'Produto não encontrado'];
        }

        $model->ativo = 1;
        if ($model->save(false)) {
            return ['status' => 'success', 'message' => 'Produto reativado com sucesso'];
        }

        \Yii::$app->response->statusCode = 400;
        return ['status' => 'error', 'message' => 'Erro ao reativar produto', 'errors' => $model->errors];
    }

    /**
     * Sobrescreve a ação index para filtrar apenas ativos
     */
    public function actionIndex()
    {
        return Produtos::find()->where(['ativo' => 1])->all();
    }
}