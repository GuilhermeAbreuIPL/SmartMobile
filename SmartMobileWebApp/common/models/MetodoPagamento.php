<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "metodopagamentos".
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $descricao
 *
 * @property Fatura[] $faturas
 */
class MetodoPagamento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'metodopagamentos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'descricao'], 'required'],
            [['descricao'], 'string'],
            [['nome'], 'string', 'max' => 45],
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
        ];
    }

    /**
     * Gets query for [[Faturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaturas()
    {
        return $this->hasMany(Fatura::class, ['metodopagamento_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {

        parent::afterSave($insert, $changedAttributes);

        $id = $this->id;
        $topic = "smartmobile/metodopagamento/{$id}/save";


        $jsonAttributes = Json::encode($this->attributes);

        $mensagem= 'O metodo de pagamento foi criado ou modificado';

        HelperMosquitto::FazPublishNoMosquitto($topic,$jsonAttributes);
        HelperMosquitto::FazPublishNoMosquitto($topic,$mensagem);
    }
    public function afterDelete()
    {
        parent::afterDelete();

        $id = $this->id;
        $topic = "smartmobile/metodopagamento/{$id}/delete";

        // Concatenar o id à mensagem
        $mensagem = "Um metodopagamento foi removida. ID do metodopagamento: {$id}";

        HelperMosquitto::FazPublishNoMosquitto($topic, $mensagem);
    }
}
