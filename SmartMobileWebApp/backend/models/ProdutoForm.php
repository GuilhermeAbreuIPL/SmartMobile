<?php

namespace backend\models;

use Yii;
use common\models\Imagem;
use common\models\Produto;
use common\models\Categoria;
use yii\base\Model;

class ProdutoForm extends Model
{
    // Campos do produto
    public $id;
    public $nome;
    public $preco;
    public $descricao;
    public $categoria_id;

    // Campos do upload de imagem
    public $filename;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'preco', 'descricao', 'categoria_id'], 'required'],
            [['preco'], 'number'],
            [['descricao'], 'string'],
            [['categoria_id'], 'integer'],
            [['nome'], 'string', 'max' => 45],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['categoria_id' => 'id']],
            [['filename'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['filename'], 'safe'],
        ];
    }

    /**
     * Criação do produto com upload de imagem.
     *
     * @return bool
     */
    public function create()
    {
        if (!$this->validate()) {
            return false;
        }

        // Garantir que o diretório de upload existe
        $uploadPath = Yii::getAlias('@webroot/uploads');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Guarda o arquivo no servidor
        if (!$this->filename->saveAs($uploadPath . '/' . $this->filename->baseName . '.' . $this->filename->extension)) {
            return false; // Falha ao salvar o arquivo
        }

        // Guarda os dados da imagem na base de dados
        $imagem = new Imagem();
        // Salvar inicialmente o nome original do arquivo para que a imagem seja salva
        $imagem->filename = $this->filename->baseName . '.' . $this->filename->extension;

        if (!$imagem->save()) {
            return false; // Falha ao salvar a imagem
        }

        // Agora que a imagem tem um ID, altera o nome do arquivo para o formato desejado
        $newFilename = 'imagem_produto_' . $imagem->id . '.' . $this->filename->extension;
        $newFilePath = $uploadPath . '/' . $newFilename;

        // Renomear o arquivo
        if (!rename($uploadPath . '/' . $imagem->filename, $newFilePath)) {
            return false; // Falha ao renomear o arquivo
        }

        // Atualiza o nome do arquivo na base de dados
        $imagem->filename = $newFilename;
        if (!$imagem->save()) {
            unlink($newFilePath); // Apaga o arquivo renomeado se a imagem não for salva
            return false;
        }

        // Salvar os dados do produto na base de dados
        $produto = new Produto();
        $produto->nome = $this->nome;
        $produto->preco = $this->preco;
        $produto->descricao = $this->descricao;
        $produto->categoria_id = $this->categoria_id;
        $produto->imagem_id = $imagem->id;

        if (!$produto->save()) {
            unlink($newFilePath); // Apaga o arquivo se o produto não for salvo
            $imagem->delete(); // Apaga o registro da imagem
            return false;
        }

        return true; // Tudo foi guardado corretamente
    }



}
