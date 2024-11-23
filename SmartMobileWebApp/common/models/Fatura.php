<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "faturas".
 *
 * @property int $id
 * @property string|null $datafatura
 * @property float|null $total
 * @property string|null $statusorder
 * @property int|null $userprofile_id
 * @property int|null $metodopagamento_id
 * @property int|null $metodoentrega_id
 * @property int|null $moradaexpedicao_id
 *
 * @property Userprofile $id0
 * @property Linhafatura[] $linhafaturas
 * @property Metodoentrega $metodoentrega
 * @property MetodoPagamento $metodopagamento
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
            [['userprofile_id', 'metodopagamento_id', 'metodoentrega_id', 'moradaexpedicao_id'], 'integer'],
            [['statusorder'], 'string', 'max' => 45],
            [['metodopagamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Metodopagamento::class, 'targetAttribute' => ['metodopagamento_id' => 'id']],
            [['metodoentrega_id'], 'exist', 'skipOnError' => true, 'targetClass' => Metodoentrega::class, 'targetAttribute' => ['metodoentrega_id' => 'id']],
            [['moradaexpedicao_id'], 'exist', 'skipOnError' => true, 'targetClass' => Moradaexpedicao::class, 'targetAttribute' => ['moradaexpedicao_id' => 'id']],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Userprofile::class, 'targetAttribute' => ['id' => 'id']],
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
            'metodoentrega_id' => 'Metodoentrega ID',
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
     * Gets query for [[Metodoentrega]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMetodoentrega()
    {
        return $this->hasOne(Metodoentrega::class, ['id' => 'metodoentrega_id']);
    }

    /**
     * Gets query for [[Metodopagamento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMetodopagamento()
    {
        return $this->hasOne(MetodoPagamento::class, ['id' => 'metodopagamento_id']);
    }

    /**
     * Gets query for [[Moradaexpedicao]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMoradaexpedicao()
    {
        return $this->hasOne(MoradaExpedicao::class, ['id' => 'moradaexpedicao_id']);
    }
}
