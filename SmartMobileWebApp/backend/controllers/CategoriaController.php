<?php

namespace backend\controllers;

use common\models\Categoria;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoriaController implements the CRUD actions for Categoria model.
 */
class CategoriaController extends Controller
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
                            'actions' => ['update', 'delete', 'create', 'view', 'index'],
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
     * Lists all Categoria models.
     *
     * @return string
     */
    public function actionIndex($categoriaprincipalid = null)
    {
        // Procurar categorias com relação para a categoria principal
        $categorias = Categoria::find()->where(['categoria_principal_id' => $categoriaprincipalid])->all();

        // Quando existe categoria principal, vamos encontrar as relacionadas dessa
        $categoriaPrincipal = $categoriaprincipalid ? Categoria::findOne($categoriaprincipalid) : null;

        // Criar o caminho das categorias como se fosse um filtro
        $breadcrumbs = $this->getCategoryBreadcrumbs($categoriaprincipalid);

        // Sempre colocar "Categoria Principal" no início dos breadcrumbs
        array_unshift($breadcrumbs, new Categoria([
            'id' => 0,  // ID fictício para o link de "Categoria Principal" para depois ser reconhecio no index
            'nome' => 'Categoria Principal', // Nome do link
        ]));

        return $this->render('index', [
            'categorias' => $categorias,
            'categoriaPrincipal' => $categoriaPrincipal,
            'breadcrumbs' => $breadcrumbs, // Passar titulo para a view
        ]);
    }

    /**
     * Função para construir o caminho das categorias (breadcrumbs)
     */
    private function getCategoryBreadcrumbs($categoryId)
    {
        $breadcrumbs = [];
        while ($categoryId) {
            $category = Categoria::findOne($categoryId);
            if ($category) {
                $breadcrumbs[] = $category; // Adicionar categoria ao caminho
                $categoryId = $category->categoria_principal_id; // Move para a categoria principal da atual
            } else {
                break;
            }
        }
        return array_reverse($breadcrumbs); // Reverter para mostrar da categoria principal até a subcategoria
    }

    /**
     * Displays a single Categoria model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Categoria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($categoriaprincipalid)
    {
        $model = new Categoria();

        //adicionar o id da categoria principal
        if ($categoriaprincipalid != 0)
            $model->categoria_principal_id = $categoriaprincipalid;
        else {
            $model->categoria_principal_id = null;
        }

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index', 'categoriaprincipalid' => $model->categoria_principal_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionSubcategories($id)
    {
        $subcategorias = Categoria::find()->where(['categoria_principal_id' => $id])->all();
        return $this->renderPartial('_subcategories', [
            'subcategorias' => $subcategorias,
        ]);
    }



    /**
     * Updates an existing Categoria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Categoria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Categoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Categoria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categoria::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
