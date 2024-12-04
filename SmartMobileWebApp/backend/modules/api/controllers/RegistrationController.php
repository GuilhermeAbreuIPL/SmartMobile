<?php

namespace backend\modules\api\controllers;

use yii\web\Controller;

/**
 * Controlador relativo ao registo dos utilizadores.
 */
class RegistrationController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Handles user registration.
     * Accepts user details and profile data via POST request,
     * validates and saves them to the database.
     *
     * @return array The response array with success status, message,
     * and any relevant data or validation errors.
     */
    public function actionRegister(){
        //TODO: Action register.

        return [];
    }
}