<?php

/** @var yii\web\View $this */

/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title                   = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="row">
        <div class="position-relative col-lg-6 top-20 mx-auto px-4 px-lg-0">
            <div class="card">
                <div class="card-header">
                    <strong>Please fill out the following fields to login:</strong>
                </div>
                <div class="card-body">
                    <?php
                    $form = ActiveForm::begin([
                        'id'          => 'login-form',
                        'fieldConfig' => [
                            'template'     => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                            'inputOptions' => ['class' => 'col-lg-3 form-control'],
                            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                        ],
                    ]);
                    ?>
                    <?=
                    $form->field($model, 'username', ['labelOptions' => ['class' => 'fw-bold']])
                        ->textInput(['autofocus' => true, 'placeholder' => 'douglas']);
                    ?>
                    <?=
                    $form->field($model, 'password', ['labelOptions' => ['class' => 'fw-bold']])
                        ->passwordInput(['placeholder' => '********']);
                    ?>
                    <div class="row">
                        <div class="col-12 text-end">
                            <?=
                            Html::submitButton(
                                'Login',
                                [
                                    'class' => 'btn btn-primary mt-2 py-2 px-5',
                                    'name'  => 'login-button',
                                    'id'    => 'btn_login'
                                ]
                            );
                            ?>
                        </div>
                        <div class="col-12 mt-2">
                            <img class="d-none w-100 px-4 mt-3" src="http://127.0.0.1:8000/images/loading.gif"
                                 alt="Ícone de carregamento" id="imagem_carregamento">
                            <span class="text-center mt-2" id="mensagem"></span>
                        </div>
                    </div>
                    <?php
                    ActiveForm::end();
                    ?>
                </div>
            </div>
            <div style="color:#999;">
                You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
                To modify the username/password, please check out the code <code>app\models\User::$users</code>.
            </div>
        </div>
    </div>
</div>
