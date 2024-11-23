<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "imagens".
 *
 * @property int $id
 * @property string|null $filename
 * @property string|null $fileextension
 * @property float|null $filesize
 *
 * @property Produto[] $produtos
 */
class Imagem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'imagens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['filesize'], 'number'],
            [['filename', 'fileextension'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Filename',
            'fileextension' => 'Fileextension',
            'filesize' => 'Filesize',
        ];
    }

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['imagem_id' => 'id']);
    }
}
