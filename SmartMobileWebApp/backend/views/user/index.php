<?php

use common\models\User;
use common\models\Userprofile;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;

// Guarda que este foi o ultimo url
Yii::$app->session->set('lastUrl', Yii::$app->request->url);

?>

<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['user/create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'userprofile.nome:text:Nome',
            'username',
            'email',
            'userprofile.nif:text:Nif',
            'userprofile.telemovel:text:Telemovel',
            'auth.item_name:text:Role',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'template' => '{view} {update} {delete} {addresses}',
                'buttons' => [
                    'addresses' => function ($url, $model) {
                        return Html::a(
                            '<i class="fas fa-map-marker-alt" style="color: dodgerblue; "></i>',
                            ['user/moradas', 'id' => $model->id],
                            [
                                'title' => 'Ver moradas',
                                'class' => 'btn btn-sm btn-primary',
                                'style' => 'background: none; border: none; padding: 0; box-shadow: none; margin-left: 4%;',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>


</div>
