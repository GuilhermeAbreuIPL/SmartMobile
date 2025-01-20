<?php

namespace common\models;


use Yii;
use yii\helpers\Json;
/**
 * This is the model class for table "faturas".
 *
 * @property int $id
 * @property string|null $datafatura
 * @property float|null $total
 * @property string|null $statusorder
 * @property int|null $userprofile_id
 * @property int|null $metodopagamento_id
 * @property string $tipoentrega
 * @property int|null $moradaexpedicao_id
 *
 * @property Userprofile $id0
 * @property Linhafatura[] $linhafaturas
 * @property Metodopagamento $metodopagamento
 * @property Moradaexpedicao $moradaexpedicao
 */
class Fatura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faturas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['datafatura'], 'safe'],
            [['total'], 'number'],
            [['userprofile_id', 'metodopagamento_id', 'moradaexpedicao_id'], 'integer'],
            [['tipoentrega'], 'required'],
            [['statusorder', 'tipoentrega'], 'string', 'max' => 45],
            [['metodopagamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Metodopagamento::class, 'targetAttribute' => ['metodopagamento_id' => 'id']],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Userprofile::class, 'targetAttribute' => ['id' => 'id']],
            [['moradaexpedicao_id'], 'exist', 'skipOnError' => true, 'targetClass' => Moradaexpedicao::class, 'targetAttribute' => ['moradaexpedicao_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'datafatura' => 'Datafatura',
            'total' => 'Total',
            'statusorder' => 'Statusorder',
            'userprofile_id' => 'Userprofile ID',
            'metodopagamento_id' => 'Metodopagamento ID',
            'tipoentrega' => 'Tipoentrega',
            'moradaexpedicao_id' => 'Moradaexpedicao ID',
        ];
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Userprofile::class, ['id' => 'id']);
    }

    /**
     * Gets query for [[Linhafaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhafaturas()
    {
        return $this->hasMany(Linhafatura::class, ['fatura_id' => 'id']);
    }

    /**
     * Gets query for [[Metodopagamento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMetodopagamento()
    {
        return $this->hasOne(Metodopagamento::class, ['id' => 'metodopagamento_id']);
    }

    /**
     * Gets query for [[Moradaexpedicao]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMoradaexpedicao()
    {
        return $this->hasOne(Moradaexpedicao::class, ['id' => 'moradaexpedicao_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {

        parent::afterSave($insert, $changedAttributes);

        $idFatura = $this->id;
        $topic = "smartmobile/faturas/{$idFatura}/save";


        $jsonAttributes = Json::encode($this->attributes);

        $mensagem= 'A fatura foi criada ou modificada';

        HelperMosquitto::FazPublishNoMosquitto($topic,$jsonAttributes);
        HelperMosquitto::FazPublishNoMosquitto($topic,$mensagem);
    }

    public function afterDelete()
    {
        parent::afterDelete();

        $id = $this->id;
        $topic = "smartmobile/fatura/{$id}/delete";

        // Concatenar o id à mensagem
        $mensagem = "Uma fatura foi removida. ID da fatura: {$id}";

        HelperMosquitto::FazPublishNoMosquitto($topic, $mensagem);
    }


}
