<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "carrinhos".
 *
 * @property int $id
 * @property string|null $datacriacao
 * @property int|null $userprofile_id
 *
 * @property Userprofile $id0
 * @property Linhacarrinho[] $linhacarrinhos
 */
class Carrinho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrinhos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['datacriacao'], 'safe'],
            [['userprofile_id'], 'integer'],
            [['userprofile_id'], 'required'],
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
            'datacriacao' => 'Datacriacao',
            'userprofile_id' => 'Userprofile ID',
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
     * Gets query for [[Linhacarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhacarrinhos()
    {
        return $this->hasMany(LinhaCarrinho::class, ['carrinho_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {

        parent::afterSave($insert, $changedAttributes);

        $idCarrinho = $this->id;
        $topic = "smartmobile/carrinho/{$idCarrinho}/save";


        $jsonAttributes = Json::encode($this->attributes);

        $mensagem= 'O carrinho foi criado ou modificado';

        HelperMosquitto::FazPublishNoMosquitto($topic,$jsonAttributes);
        HelperMosquitto::FazPublishNoMosquitto($topic,$mensagem);
    }

    public function afterDelete()
    {
        parent::afterDelete();

        $id = $this->id;
        $topic = "smartmobile/carrinho/{$id}/delete";

        // Concatenar o id à mensagem
        $mensagem = "Uma carrinho foi removida. ID da carrinho: {$id}";

        HelperMosquitto::FazPublishNoMosquitto($topic, $mensagem);
    }
}
