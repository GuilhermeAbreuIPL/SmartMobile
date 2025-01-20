<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "moradas".
 *
 * @property int $id
 * @property string $rua
 * @property string|null $localidade
 * @property string|null $codpostal
 * @property int|null $user_id
 *
 * @property User $user
 */
class Morada extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'moradas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rua', 'localidade', 'codpostal', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['rua'], 'string', 'max' => 85],
            [['localidade'], 'string', 'max' => 100],
            [['codpostal'], 'string', 'max' => 8],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {

        parent::afterSave($insert, $changedAttributes);

        $id = $this->id;
        $topic = "smartmobile/morada/{$id}/save";


        $jsonAttributes = Json::encode($this->attributes);

        $mensagem= 'A morada foi criada ou modificada';

        HelperMosquitto::FazPublishNoMosquitto($topic,$jsonAttributes);
        HelperMosquitto::FazPublishNoMosquitto($topic,$mensagem);
    }

    public function afterDelete()
    {
        parent::afterDelete();

        $id = $this->id;
        $topic = "smartmobile/morada/{$id}/delete";

        // Concatenar o id à mensagem
        $mensagem = "Uma morada foi removida. ID da morada: {$id}";

        HelperMosquitto::FazPublishNoMosquitto($topic, $mensagem);
    }


}
