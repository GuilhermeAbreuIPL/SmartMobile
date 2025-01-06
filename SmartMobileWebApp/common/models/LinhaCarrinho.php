<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "linhacarrinho".
 *
 * @property int $id
 * @property int|null $quantidade
 * @property float|null $precounitario
 * @property int|null $carrinho_id
 * @property int|null $produto_id
 *
 * @property Carrinho $carrinho
 * @property Produto $produto
 */
class LinhaCarrinho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linhacarrinho';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade', 'carrinho_id', 'produto_id'], 'integer'],
            [['precounitario'], 'number'],
            [['carrinho_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carrinho::class, 'targetAttribute' => ['carrinho_id' => 'id']],
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
            'quantidade' => 'Quantidade',
            'precounitario' => 'Precounitario',
            'carrinho_id' => 'Carrinho ID',
            'produto_id' => 'Produto ID',
        ];
    }

    /**
     * Gets query for [[Carrinho]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinho()
    {
        return $this->hasOne(Carrinho::class, ['id' => 'carrinho_id']);
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
     * Verifica se há alterações no preço unitário de um produto e atualiza as linhas correspondentes.
     * Remove a linha do carrinho se o produto não existir.
     *
     * @return void
     */
    public static function verificarPrecoProdutos()
    {
        $linhasCarrinho = self::find()->all();

        foreach ($linhasCarrinho as $linha) {
            $produto = Produto::findOne($linha->produto_id);

            if ($produto) {
                if ($produtopromocao = ProdutoPromocao::findOne(['produto_id' => $linha->produto_id])) {
                    $promocao = Promocao::findOne($produtopromocao->promocoes_id);
                    $linha->precounitario = $produto->preco * (1 - $promocao->descontopercentual / 100);
                }else{
                    $linha->precounitario = $produto->preco;
                }

                $linha->save();
            } else {
                $linha->delete();
            }
        }
    }
    public function afterSave($insert, $changedAttributes)
    {

        parent::afterSave($insert, $changedAttributes);

        $id = $this->id;
        $topic = "smartmobile/linhacarrinho/{$id}/save";


        $jsonAttributes = Json::encode($this->attributes);

        $mensagem= 'A LinhaCarrinho foi criado ou modificado';

        HelperMosquitto::FazPublishNoMosquitto($topic,$jsonAttributes);
        HelperMosquitto::FazPublishNoMosquitto($topic,$mensagem);
    }

    public function afterDelete()
    {
        parent::afterDelete();

        $id = $this->id;
        $topic = "smartmobile/linhacarrinho/{$id}/delete";

        // Concatenar o id à mensagem
        $mensagem = "Uma linhacarrinho foi removida. ID da linhacarrinho: {$id}";

        HelperMosquitto::FazPublishNoMosquitto($topic, $mensagem);
    }
}
