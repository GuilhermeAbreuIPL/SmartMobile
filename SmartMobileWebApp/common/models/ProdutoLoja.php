<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "produtolojas".
 *
 * @property int $id
 * @property int|null $quantidade
 * @property int|null $produto_id
 * @property int|null $loja_id
 *
 * @property Loja $loja
 * @property Produto $produto
 */
class ProdutoLoja extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produtolojas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade', 'produto_id', 'loja_id'], 'integer'],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'id']],
            [['loja_id'], 'exist', 'skipOnError' => true, 'targetClass' => Loja::class, 'targetAttribute' => ['loja_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quantidade' => 'Quantidade',
            'produto_id' => 'Produto ID',
            'loja_id' => 'Loja ID',
        ];
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

    public function afterSave($insert, $changedAttributes)
    {

        parent::afterSave($insert, $changedAttributes);

        $id = $this->id;
        $topic = "smartmobile/produtoloja/{$id}/save";


        $jsonAttributes = Json::encode($this->attributes);

        $mensagem= 'O produtoloja foi criado ou modificado';

        HelperMosquitto::FazPublishNoMosquitto($topic,$jsonAttributes);
        HelperMosquitto::FazPublishNoMosquitto($topic,$mensagem);
    }

    public function afterDelete()
    {
        parent::afterDelete();

        $id = $this->id;
        $topic = "smartmobile/produtoloja/{$id}/delete";

        // Concatenar o id à mensagem
        $mensagem = "Uma produtoloja foi removida. ID da produtoloja: {$id}";

        HelperMosquitto::FazPublishNoMosquitto($topic, $mensagem);
    }
}
