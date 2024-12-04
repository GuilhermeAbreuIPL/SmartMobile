<?php

namespace common\models;

/**
 * This is the model class for table "produto_promocao".
 *
 * @property int $id
 * @property string|null $datainicio
 * @property string|null $datafim
 * @property int|null $produto_id
 * @property int|null $promocoes_id
 *
 * @property Produto $produto
 * @property Promocao $promocoes
 */
class ProdutoPromocao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produto_promocao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['datainicio', 'datafim'], 'safe'],
            ['datafim', 'compare', 'compareAttribute' => 'datainicio', 'operator' => '>=', 'message' => 'A data de fim não pode ser anterior à data de início.'],
            [['produto_id', 'promocoes_id'], 'integer'],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'id']],
            [['promocoes_id'], 'exist', 'skipOnError' => true, 'targetClass' => Promocao::class, 'targetAttribute' => ['promocoes_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'datainicio' => 'Datainicio',
            'datafim' => 'Datafim',
            'produto_id' => 'Produto ID',
            'promocoes_id' => 'Promocoes ID',
        ];
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

    /**
     * Gets query for [[Promocoes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPromocao()
    {
        return $this->hasOne(Promocao::class, ['id' => 'promocoes_id']);
    }
}
