<?php

namespace common\models;

use Yii;
use backend\models\ProdutoPromocao;

/**
 * This is the model class for table "promocoes".
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $descricao
 * @property float|null $descontopercentual
 *
 * @property ProdutoPromocao[] $produtoPromocaos
 */
class Promocao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'promocoes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao'], 'string'],
            [['descontopercentual'], 'number'],
            [['nome'], 'string', 'max' => 100],
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
            'descricao' => 'Descricao',
            'descontopercentual' => 'Descontopercentual',
        ];
    }

    /**
     * Gets query for [[ProdutoPromocaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutoPromocaos()
    {
        return $this->hasMany(ProdutoPromocao::class, ['promocoes_id' => 'id']);
    }
}
