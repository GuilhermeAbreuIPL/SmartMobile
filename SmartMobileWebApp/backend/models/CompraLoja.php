<?php

namespace backend\models;

use common\models\Loja;
use common\models\Produto;

/**
 * This is the model class for table "compraloja".
 *
 * @property int $id
 * @property float|null $preçofornecedor
 * @property int|null $quantidade
 * @property string|null $datacompra
 * @property int|null $fornecedor_id
 * @property int|null $loja_id
 * @property int|null $produto_id
 *
 * @property Fornecedor $fornecedor
 * @property Loja $loja
 * @property Produto $produto
 */
class CompraLoja extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'compraloja';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['preçofornecedor'], 'number'],
            [['quantidade', 'fornecedor_id', 'loja_id', 'produto_id'], 'integer'],
            [['datacompra'], 'safe'],
            [['fornecedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fornecedor::class, 'targetAttribute' => ['fornecedor_id' => 'id']],
            [['loja_id'], 'exist', 'skipOnError' => true, 'targetClass' => Loja::class, 'targetAttribute' => ['loja_id' => 'id']],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preçofornecedor' => 'Preçofornecedor',
            'quantidade' => 'Quantidade',
            'datacompra' => 'Datacompra',
            'fornecedor_id' => 'Fornecedor ID',
            'loja_id' => 'Loja ID',
            'produto_id' => 'Produto ID',
        ];
    }

    /**
     * Gets query for [[Fornecedor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFornecedor()
    {
        return $this->hasOne(Fornecedor::class, ['id' => 'fornecedor_id']);
    }

    /**
     * Gets query for [[Loja]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoja()
    {
        return $this->hasOne(Loja::class, ['id' => 'loja_id']);
    }

    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['id' => 'produto_id']);
    }
}
