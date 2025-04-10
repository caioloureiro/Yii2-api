<?php

namespace app\models;

use yii\db\ActiveRecord;

class Categorias extends ActiveRecord
{
    public static function tableName()
    {
        return 'categorias';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['ativo'], 'string', 'max' => 1],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'ativo',
        ];
    }

    public function extraFields()
    {
        return ['produtos']; // Relação com produtos se necessário
    }

    public function getProdutos()
    {
        return $this->hasMany(Produtos::className(), ['categoria' => 'id']);
    }

    public function softDelete()
    {
        $this->ativo = '0';
        return $this->save(false);
    }
}