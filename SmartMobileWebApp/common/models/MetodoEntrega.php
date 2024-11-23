<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "metodoentrega".
 *
 * @property int $id
 * @property string|null $nome
 *
 * @property Fatura[] $faturas
 */
class MetodoEntrega extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'metodoentrega';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
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
        ];
    }

    /**
     * Gets query for [[Faturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaturas()
    {
        return $this->hasMany(Fatura::class, ['metodoentrega_id' => 'id']);
    }
}
