<?php

namespace common\models;

use Yii;
use backend\models\Compraloja;

/**
 * This is the model class for table "lojas".
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $contacto
 * @property string $rua
 * @property string|null $localidade
 * @property string $codpostal
 *
 * @property Compraloja[] $compralojas
 * @property Produtoloja[] $produtolojas
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
            [['nome', 'localidade'], 'string', 'max' => 45],
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
            'localidade' => 'Localidade',
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
        return $this->hasMany(Produtoloja::class, ['loja_id' => 'id']);
    }
}
