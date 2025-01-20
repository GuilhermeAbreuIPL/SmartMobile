<?php

namespace common\models;

use Yii;
use yii\helpers\Json;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "imagens".
 *
 * @property int $id
 * @property string|null $filename
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
            [['filename'], 'string', 'max' => 255],
            [['filename'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['filename'], 'required'],
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
    public function afterSave($insert, $changedAttributes)
    {

        parent::afterSave($insert, $changedAttributes);

        $id = $this->id;
        $topic = "smartmobile/imagem/{$id}/save";


        $jsonAttributes = Json::encode($this->attributes);

        $mensagem= 'A imagem foi criado ou modificado';

        HelperMosquitto::FazPublishNoMosquitto($topic,$jsonAttributes);
        HelperMosquitto::FazPublishNoMosquitto($topic,$mensagem);
    }
    public function afterDelete()
    {
        parent::afterDelete();

        $id = $this->id;
        $topic = "smartmobile/imagem/{$id}/delete";

        // Concatenar o id à mensagem
        $mensagem = "Uma imagem foi removida. ID da imagem: {$id}";

        HelperMosquitto::FazPublishNoMosquitto($topic, $mensagem);
    }
}
