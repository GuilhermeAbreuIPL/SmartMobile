<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lojas".
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $contacto
 * @property string $rua
 * @property string|null $localizacao
 * @property string $codpostal
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
            [['rua', 'codpostal'], 'required'],
            [['nome', 'localizacao'], 'string', 'max' => 45],
            [['contacto'], 'string', 'max' => 15],
            [['rua'], 'string', 'max' => 85],
            [['codpostal'], 'string', 'max' => 8],
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
            'rua' => 'Rua',
            'localizacao' => 'Localizacao',
            'codpostal' => 'Codpostal',
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
