<?php

namespace app\models;

use yii\db\ActiveRecord;

class Produtos extends ActiveRecord
{
    public static function tableName()
    {
        return 'produtos';
    }

    public function rules()
    {
        return [
            [['nome', 'quantidade', 'categoria'], 'required'],
            [['quantidade', 'categoria'], 'integer'],
            [['ativo'], 'boolean'],
            [['nome'], 'string', 'max' => 255],
        ];
    }

    public function fields()
    {
        return [
            'id',
            'nome',
            'quantidade',
            'categoria',
            'ativo',
            'categoria_nome' => function ($model) {
                return $model->categoriaRel->name ?? null;
            },
        ];
    }

    public function extraFields()
    {
        return ['categoriaRel'];
    }

    public function getCategoriaRel()
    {
        return $this->hasOne(Categorias::className(), ['id' => 'categoria']);
    }

    public function softDelete()
    {
        $this->ativo = 0;
        return $this->save(false);
    }
}