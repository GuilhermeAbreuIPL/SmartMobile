<?php

namespace common\models;

use Yii;
use backend\models\Compraloja;
use yii\helpers\Json;

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
            [['nome', 'contacto', 'rua', 'localidade', 'codpostal'], 'required'],
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

    public function afterSave($insert, $changedAttributes)
    {

        parent::afterSave($insert, $changedAttributes);

        $id = $this->id;
        $topic = "smartmobile/loja/{$id}/save";


        $jsonAttributes = Json::encode($this->attributes);

        $mensagem= 'A loja foi criada ou modificada';

        HelperMosquitto::FazPublishNoMosquitto($topic,$jsonAttributes);
        HelperMosquitto::FazPublishNoMosquitto($topic,$mensagem);

    }
    public function afterDelete()
    {
        parent::afterDelete();

        $id = $this->id;
        $topic = "smartmobile/loja/{$id}/delete";

        // Concatenar o id à mensagem
        $mensagem = "Uma loja foi removida. ID da loja: {$id}";

        HelperMosquitto::FazPublishNoMosquitto($topic, $mensagem);
    }
}
