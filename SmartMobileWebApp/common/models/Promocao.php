<?php

namespace common\models;

use yii\helpers\Json;

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
            [['nome', 'descricao', 'descontopercentual'], 'required'],
            [['descricao'], 'string', 'min' => 0],
            [['descontopercentual'], 'number', 'min' => 0, 'max' => 100],
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

    public function afterSave($insert, $changedAttributes)
    {

        parent::afterSave($insert, $changedAttributes);

        $id = $this->id;
        $topic = "smartmobile/promocao/{$id}/save";


        $jsonAttributes = Json::encode($this->attributes);

        $mensagem = 'A promocao foi criada ou modificada';

        HelperMosquitto::FazPublishNoMosquitto($topic,$jsonAttributes);
        HelperMosquitto::FazPublishNoMosquitto($topic,$mensagem);
    }
}
