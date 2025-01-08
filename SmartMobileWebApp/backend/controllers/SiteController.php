<?php

namespace backend\controllers;

use common\models\LoginForm;
use common\models\ProdutoPromocao;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'error', 'logout'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout', 'error'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['admin', 'gestor', 'funcionario'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->verificarPromocoesExpiradas();
        if (Yii::$app->user->can('viewbackend')) {
            // Quantidade de faturas concluídas
            $faturasConcluidas = \common\models\Fatura::find()->where(['statusorder' => 'Concluído'])->count();

            // Quantidade de faturas pendentes
            $faturasPendentes = \common\models\Fatura::find()->where(['statusorder' => 'Confirmação Pendente'])->orWhere(['statusorder' => 'Processamento'])->count();

            // Quantidade de clientes registados
            $clientesRegistados = \common\models\User::find()->count();

            //rendimento do mês atual
            $rendimentoMes = \common\models\Fatura::find()->where(['statusorder' => 'Concluído'])->andWhere(['MONTH(datafatura)' => date('m')])->sum('total');

            //rendimento total
            $rendimentoTotal = \common\models\Fatura::find()->where(['statusorder' => 'Concluído'])->sum('total');

            //produtos a venda
            $produtosVenda = \common\models\Produto::find()->count();

            //promoções ativas
            $promoAtivas = \common\models\ProdutoPromocao::find()->where(['>', 'datafim', date('Y-m-d H:i:s')])->count();

            if ($rendimentoMes == null) {
                $rendimentoMes = 0;
            }
            if ($rendimentoTotal == null) {
                $rendimentoTotal = 0;
            }

            return $this->render('index', [
                'faturasConcluidas' => $faturasConcluidas,
                'faturasPendentes' => $faturasPendentes,
                'clientesRegistados' => $clientesRegistados,
                'rendimentoMes' => $rendimentoMes,
                'rendimentoTotal' => $rendimentoTotal,
                'produtosVenda' => $produtosVenda,
                'promoAtivas' => $promoAtivas,
            ]);
        }
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->can('viewbackend'))
                return $this->goHome();

            else {

                Yii::$app->user->logout();
                Yii::$app->session->setFlash('error', 'O cliente não pode aceder a esta área!');

                return $this->refresh();
            }
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function verificarPromocoesExpiradas()
    {
        $promocoes = ProdutoPromocao::find()->all();

        foreach ($promocoes as $promocao) {
            if (strtotime($promocao->datafim) < time()) {
                try {
                    // Tenta apagar a promoção
                    if ($promocao->delete()) {
                        Yii::info("Promoção de produto ID {$promocao->produto_id} apagada com sucesso.", __METHOD__);
                    } else {
                        Yii::error("Erro ao tentar apagar a promoção de produto ID {$promocao->produto_id}.", __METHOD__);
                    }
                } catch (\Exception $e) {
                    Yii::error("Erro ao tentar apagar a promoção: " . $e->getMessage(), __METHOD__);
                }
            }
        }
    }
}
