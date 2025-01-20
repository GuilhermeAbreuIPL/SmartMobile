<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "moradaexpedicao".
 *
 * @property int $id
 * @property int $rua
 * @property string|null $localidade
 * @property string|null $codpostal
 *
 * @property Fatura[] $faturas
 */
class MoradaExpedicao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'moradaexpedicao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rua', 'localidade', 'codpostal'], 'required'],
            [['rua'], 'string', 'max' => 255],
            [['localidade'], 'string', 'max' => 100],
            [['codpostal'], 'string', 'max' => 8],
            [['codpostal'], 'match', 'pattern' => '/^\d{4}-\d{3}$/', 'message' => 'Formato de código postal inválido.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rua' => 'Rua',
            'localidade' => 'Localidade',
            'codpostal' => 'Codpostal',
        ];
    }

    /**
     * Gets query for [[Faturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaturas()
    {
        return $this->hasOne(Fatura::class, ['moradaexpedicao_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {

        parent::afterSave($insert, $changedAttributes);

        $id = $this->id;
        $topic = "smartmobile/moradaexpedicao/{$id}/save";


        $jsonAttributes = Json::encode($this->attributes);

        $mensagem= 'A morada expedicao foi criado ou modificado';

        HelperMosquitto::FazPublishNoMosquitto($topic,$jsonAttributes);
        HelperMosquitto::FazPublishNoMosquitto($topic,$mensagem);
    }
    public function afterDelete()
    {
        parent::afterDelete();

        $id = $this->id;
        $topic = "smartmobile/moradaexpedicao/{$id}/delete";

        // Concatenar o id à mensagem
        $mensagem = "Uma moradaexpedicao foi removida. ID da moradaexpedicao: {$id}";

        HelperMosquitto::FazPublishNoMosquitto($topic, $mensagem);
    }
}
