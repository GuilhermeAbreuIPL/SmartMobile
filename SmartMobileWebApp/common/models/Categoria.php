<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "categorias".
 *
 * @property int $id
 * @property string|null $nome
 * @property int|null $categoria_principal_id
 *
 * @property Categoria $categoriaPrincipal
 * @property Categoria[] $categorias
 * @property Produto[] $produtos
 */
class Categoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categorias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['categoria_principal_id'], 'integer'],
            [['nome'], 'string', 'max' => 45],
            [['categoria_principal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['categoria_principal_id' => 'id']],
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
            'categoria_principal_id' => 'Categoria Principal ID',
        ];
    }

    /**
     * Gets query for [[CategoriaPrincipal]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriaPrincipal()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria_principal_id']);
    }

    /**
     * Gets query for [[Categorias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategorias()
    {
        return $this->hasMany(Categoria::class, ['categoria_principal_id' => 'id']);
    }

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['categoria_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {

        parent::afterSave($insert, $changedAttributes);

        $id = $this->id;
        $topic = "smartmobile/categoria/{$id}/save";


        $jsonAttributes = Json::encode($this->attributes);

        $mensagem= 'O categoria foi criado ou modificado';

        HelperMosquitto::FazPublishNoMosquitto($topic,$jsonAttributes);
        HelperMosquitto::FazPublishNoMosquitto($topic,$mensagem);
    }
    public function afterDelete()
    {
        parent::afterDelete();

        $id = $this->id;
        $topic = "smartmobile/categoria/{$id}/delete";

        // Concatenar o id à mensagem
        $mensagem = "Uma categoria foi removida. ID da categoria: {$id}";

        HelperMosquitto::FazPublishNoMosquitto($topic, $mensagem);
    }
}

