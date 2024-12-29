<?php

// Configuração do Yii2 Advanced
$config = require __DIR__ . '/../../common/config/test.php';
Yii::setAlias('@common', dirname(__DIR__) . '/../../common');
Yii::setAlias('@console', dirname(__DIR__) . '/../../console');
Yii::setAlias('@frontend', dirname(__DIR__) . '/../../frontend');
Yii::setAlias('@backend', dirname(__DIR__) . '/../../backend');

// Carregar o Yii2
require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';

// Configuração do ambiente de teste
Yii::$app = Yii::createWebApplication($config);