<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "moradas".
 *
 * @property int $id
 * @property string|null $localidade
 * @property string|null $codpostal
 * @property int|null $userprofile_id
 *
 * @property Userprofile $id0
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
            [['userprofile_id'], 'integer'],
            [['localidade'], 'string', 'max' => 100],
            [['codpostal'], 'string', 'max' => 8],
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
            'localidade' => 'Localidade',
            'codpostal' => 'Codpostal',
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
}
