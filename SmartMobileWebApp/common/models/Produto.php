<?php

namespace common\models;

use Yii;
use backend\models\CompraLoja;
use backend\models\ProdutoPromocao;

/**
 * This is the model class for table "produtos".
 *
 * @property int $id
 * @property string|null $nome
 * @property float|null $preco
 * @property string|null $descricao
 * @property int|null $categoria_id
 * @property int|null $imagem_id
 *
 * @property Categoria $categoria
 * @property Compraloja[] $compralojas
 * @property Imagem $imagem
 * @property LinhaCarrinho[] $linhacarrinhos
 * @property Linhafatura[] $linhafaturas
 * @property ProdutoPromocao[] $produtoPromocaos
 * @property ProdutoLoja[] $produtolojas
 */
class Produto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produtos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['preco'], 'number'],
            [['descricao'], 'string'],
            [['categoria_id', 'imagem_id'], 'integer'],
            [['nome'], 'string', 'max' => 45],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['categoria_id' => 'id']],
            [['imagem_id'], 'exist', 'skipOnError' => true, 'targetClass' => Imagem::class, 'targetAttribute' => ['imagem_id' => 'id']],
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
            'preco' => 'Preco',
            'descricao' => 'Descricao',
            'categoria_id' => 'Categoria ID',
            'imagem_id' => 'Imagem ID',
        ];
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria_id']);
    }

    /**
     * Gets query for [[Compralojas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompralojas()
    {
        return $this->hasMany(Compraloja::class, ['produto_id' => 'id']);
    }

    /**
     * Gets query for [[Imagem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagem()
    {
        return $this->hasOne(Imagem::class, ['id' => 'imagem_id']);
    }

    /**
     * Gets query for [[Linhacarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhacarrinhos()
    {
        return $this->hasMany(Linhacarrinho::class, ['produto_id' => 'id']);
    }

    /**
     * Gets query for [[Linhafaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhafaturas()
    {
        return $this->hasMany(Linhafatura::class, ['produto_id' => 'id']);
    }

    /**
     * Gets query for [[ProdutoPromocaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutoPromocaos()
    {
        return $this->hasMany(ProdutoPromocao::class, ['produto_id' => 'id']);
    }

    /**
     * Gets query for [[Produtolojas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutolojas()
    {
        return $this->hasMany(ProdutoLoja::class, ['produto_id' => 'id']);
    }
}
