<?php

namespace backend\controllers;

use backend\models\ProdutoForm;
use common\models\Categoria;
use common\models\Imagem;
use common\models\Produto;
use common\models\ProdutoLoja;
use common\models\ProdutoPromocao;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\db\Exception;
/**
 * ProdutoController implements the CRUD actions for Produto model.
 */
class ProdutoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['update', 'delete', 'create', 'index', 'changeimage'],
                            'roles' => ['gestor'],
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        throw new ForbiddenHttpException('Não tem permissão para ver esta página.');
                    },
                ],

                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }


    /**
     * Lists all Produto models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Produto::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Produto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ProdutoForm();
        $categorias = Categoria::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->filename = UploadedFile::getInstance($model, 'filename');

            if ($model->create()) {
                Yii::$app->session->setFlash('success', 'Produto criado com sucesso!');
                return $this->redirect(['index']);
            }

            Yii::$app->session->setFlash('error', 'Erro ao criar o produto.');
        }

        return $this->render('create', ['model' => $model, 'categorias' => $categorias]);
    }


    /**
     * Updates an existing Produto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionUpdate($id)
    {
        $model = Produto::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException("Produto não encontrado.");
        }

        $categorias = Categoria::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->update($model)) {
                Yii::$app->session->setFlash('success', 'Produto alterado com sucesso');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'categorias' => $categorias,
        ]);
    }


    public function actionChangeimage($id)
    {
        $model = Imagem::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Imagem não encontrada');
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($model->load(Yii::$app->request->post())) {
                $model->filename = UploadedFile::getInstance($model, 'filename');

                if ($model->filename) {
                    $uploadPath = Yii::getAlias('@webroot/uploads');

                    $baseName = 'imagem_produto_' . $model->id;

                    //apaga todos os ficehiros das extenções permitidas
                    foreach (['jpg', 'jpeg', 'png'] as $extencao) {
                        $oldImagePath = $uploadPath . '/' . $baseName . '.' . $extencao;
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }

                    //o strtolower serve apenas para vir tudo em minúsculas
                    $extension = strtolower($model->filename->extension);
                    if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
                        throw new Exception('A extensão do arquivo não é permitida. Apenas JPG e PNG são aceitos.');
                    }

                    // Novo nome do arquivo baseado no ID da imagem
                    $newFilename = $baseName . '.' . $extension;
                    $newImagePath = $uploadPath . '/' . $newFilename;

                    if ($model->filename->saveAs($newImagePath)) {

                        // Atualiza o modelo com o novo nome do arquivo
                        $model->filename = $newFilename;

                        // Salva as alterações no modelo de imagem
                        if ($model->save()) {

                            $produto = Produto::findOne(['imagem_id' => $model->id]);


                            if ($produto) {
                                $produto->imagem_id = $model->id;
                                $produto->save();
                            }

                            $transaction->commit();
                            Yii::$app->session->setFlash('success', 'Imagem alterada com sucesso!');
                            return $this->redirect(['index']);
                        } else {
                            throw new Exception('Erro ao salvar as alterações no modelo.');
                        }
                    } else {
                        throw new Exception('Erro ao salvar a nova imagem.');
                    }
                }
            }

            return $this->render('changeimage', [
                'model' => $model,
            ]);
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Erro ao alterar a imagem: ' . $e->getMessage());

            return $this->render('changeimage', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Produto model along with its image.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = Produto::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException("Produto não encontrado");
        }

        $imagem = Imagem::findOne($model->imagem_id);

        // Inicia uma transação para garantir consistência no banco de dados
        $transaction = Yii::$app->db->beginTransaction();

        try {
            //remove todas as promoções e produtos em loja associados ao produto
            ProdutoPromocao::deleteAll(['produto_id' => $id]);
            $protecaopromocoes = ProdutoPromocao::find()->where(['produto_id' => $id])->count();
            ProdutoLoja::deleteAll(['produto_id' => $id]);
            $protecaoprodutosloja = ProdutoLoja::find()->where(['produto_id' => $id])->count();

            // Verifica se todas as promoções e produtos em loja foram removidas
            if ($protecaopromocoes > 0 || $protecaoprodutosloja > 0) {
                throw new Exception("Nem todas as promoções ou produtos em loja foram removidas");
            }


            // Apaga o produto
            if (!$model->delete()) {
                throw new Exception("Erro ao remover o produto da base de dados");
            }

            // Localiza e apaga o arquivo de imagem associado (se existir)
            if ($imagem) {
                $uploadPath = Yii::getAlias('@webroot/uploads');
                $imagePath = $uploadPath . '/' . $imagem->filename;

                if (!empty($imagem->filename) && file_exists($imagePath)) {
                    unlink($imagePath);
                }

                // Apaga o registro da imagem da base de dados
                if (!$imagem->delete()) {
                    throw new Exception("Erro ao remover a imagem da base de dados");
                }
            }

            $transaction->commit();
            Yii::$app->session->setFlash('success', 'Produto removido com sucesso!');
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Erro ao remover o produto: ' . $e->getMessage());
        }

        return $this->redirect(['index']);
    }



}
