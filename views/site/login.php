<?php

//  @var yii\web\View $this;
//  @var yii\bootstrap4\ActiveForm $form;
//  @var app\models\LoginForm $model; 

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Login Form</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>


            <div class="btn-group ">
                <?= Html::submitButton('Add', ['class' => 'btn btn-primary mr-2 rounded', 'name' => 'add-button', 'id' => 'add']) ?>
                <?= Html::submitButton('Check', ['class' => 'btn btn-secondary ml-2 rounded', 'name' => 'check-button', 'id' => 'check']) ?>
            </div>






    <?php ActiveForm::end(); ?>

    <div class="offset-lg-1" style="color:#999;">
        Username must be <strong>unique</strong> .<br>
      Password must be <strong>unique</strong> .<br>
    </div>

    <script type="text/javascript">
        
        form = document.getElementById('login-form')
        
          const addButton = document.getElementById('add');
          const checkButton = document.getElementById('check');

        function preventSubmission(e) {
            e.preventDefault();
        }

       
        
        function addUser() { 
        const username = $("#loginform-username").val();
        const password = $("#loginform-password").val();
    $.ajax({
        url: "index.php?r=site%2Flogin",  
        type: "POST",
        data: { "username": username, "password": password},
        datatype: "json",
        })
        .done (function ( response ) {
         alert(response);
        })
        .fail (function( status, error) 
        {
            alert(error);
        })
}

    function checkUser() {
        const username = $("#loginform-username").val();
        const password = $("#loginform-password").val();
        $.ajax({
        url: "index.php?r=site%2Flogin",  
        type: "POST",
        data: { "username": username, "password": password},
        datatype: "json",
        })
        .done (function ( response ) {
         alert(response);
        })
        .fail (function( status, error) 
        {
            alert(error);
        })
    }
         

              
             
            form.addEventListener("submit", preventSubmission);
            addButton.addEventListener("click", addUser);
            checkButton.addEventListener("click", checkUser);
 







   


  

      
      
      
            
    
      


        




    

      

        </script>
</div>
