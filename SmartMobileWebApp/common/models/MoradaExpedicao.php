<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "moradaexpedicao".
 *
 * @property int $id
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
            [['localidade'], 'string', 'max' => 100],
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
        return $this->hasMany(Fatura::class, ['moradaexpedicao_id' => 'id']);
    }
}
