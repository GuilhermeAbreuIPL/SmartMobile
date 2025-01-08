<?php

namespace common\models;

use yii\helpers\Json;

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

    public function afterSave($insert, $changedAttributes)
    {

        parent::afterSave($insert, $changedAttributes);

        $id = $this->id;
        $topic = "smartmobile/produtopromocao/{$id}/save";


        $jsonAttributes = Json::encode($this->attributes);

        $mensagem= 'O produtopromocao foi criado ou modificado';

        HelperMosquitto::FazPublishNoMosquitto($topic,$jsonAttributes);
        HelperMosquitto::FazPublishNoMosquitto($topic,$mensagem);
    }
    public function afterDelete()
    {
        parent::afterDelete();

        $id = $this->id;
        $topic = "smartmobile/produtopromocao/{$id}/delete";

        // Concatenar o id à mensagem
        $mensagem = "Uma produtopromocao foi removida. ID da produtopromocao: {$id}";

        HelperMosquitto::FazPublishNoMosquitto($topic, $mensagem);
    }
}
