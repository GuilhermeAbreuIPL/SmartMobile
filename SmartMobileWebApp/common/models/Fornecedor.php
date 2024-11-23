<?php

namespace common\models;

use Yii;
use backend\models\CompraLoja;

/**
 * This is the model class for table "fornecedor".
 *
 * @property int $id
 * @property string|null $empresa
 * @property string|null $contacto
 *
 * @property Compraloja[] $compralojas
 */
class Fornecedor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fornecedor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa', 'contacto'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'empresa' => 'Empresa',
            'contacto' => 'Contacto',
        ];
    }

    /**
     * Gets query for [[Compralojas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompralojas()
    {
        return $this->hasMany(CompraLoja::class, ['fornecedor_id' => 'id']);
    }
}
