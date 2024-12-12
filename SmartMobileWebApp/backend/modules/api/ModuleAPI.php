<?php

namespace backend\modules\api;

use Yii;
use yii\web\Response;

/**
 * api module definition class
 */
class ModuleAPI extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\api\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {

        parent::init();


        // custom initialization code goes here
        /*Este código faz com que todos os pedidos façam parse para json*/
        Yii::$app->set('request', [
            'class' => '\yii\web\Request',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ]);
    }
}
