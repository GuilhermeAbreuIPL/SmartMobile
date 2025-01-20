<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "linhafatura".
 *
 * @property int $id
 * @property int|null $quantidade
 * @property float|null $precounitario
 * @property int|null $fatura_id
 * @property int|null $produto_id
 *
 * @property Fatura $fatura
 * @property Produto $produto
 */
class LinhaFatura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linhafatura';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade', 'fatura_id', 'produto_id'], 'integer'],
            [['precounitario'], 'number'],
            [['fatura_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fatura::class, 'targetAttribute' => ['fatura_id' => 'id']],
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
            'fatura_id' => 'Fatura ID',
            'produto_id' => 'Produto ID',
        ];
    }

    /**
     * Gets query for [[Fatura]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFatura()
    {
        return $this->hasOne(Fatura::class, ['id' => 'fatura_id']);
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
        $topic = "smartmobile/linhafatura/{$id}/save";


        $jsonAttributes = Json::encode($this->attributes);

        $mensagem = 'A linhafatura foi criado ou modificado';

        HelperMosquitto::FazPublishNoMosquitto($topic,$jsonAttributes);
        HelperMosquitto::FazPublishNoMosquitto($topic,$mensagem);
    }
    public function afterDelete()
    {
        parent::afterDelete();

        $id = $this->id;
        $topic = "smartmobile/linhafatura/{$id}/delete";

        // Concatenar o id à mensagem
        $mensagem = "Uma linhafatura foi removida. ID da linhafatura: {$id}";

        HelperMosquitto::FazPublishNoMosquitto($topic, $mensagem);
    }



}
