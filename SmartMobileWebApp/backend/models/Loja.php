<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "lojas".
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $contacto
 * @property string|null $localizacao
 *
 * @property Compraloja[] $compralojas
 * @property Produtolojas[] $produtolojas
 */
class Loja extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lojas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'localizacao'], 'string', 'max' => 45],
            [['contacto'], 'string', 'max' => 9],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'contacto' => 'Contacto',
            'localizacao' => 'Localizacao',
        ];
    }

    /**
     * Gets query for [[Compralojas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompralojas()
    {
        return $this->hasMany(Compraloja::class, ['loja_id' => 'id']);
    }

    /**
     * Gets query for [[Produtolojas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutolojas()
    {
        return $this->hasMany(Produtolojas::class, ['loja_id' => 'id']);
    }
}
