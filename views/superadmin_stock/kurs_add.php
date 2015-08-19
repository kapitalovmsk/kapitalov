<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model cs\base\BaseForm */

$this->title = 'Добавить курс';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Успешно добавлено.
        </div>

    <?php else: ?>


        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin([
                    'id'      => 'contact-form',
                    'options' => ['enctype' => 'multipart/form-data']
                ]); ?>
                <?php for ($i = 1; $i <= 10; $i++) { ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <?= $model->field($form, 'date' . $i) ?>
                        </div>
                        <div class="col-lg-6">
                            <?= $model->field($form, 'kurs' . $i) ?>
                        </div>
                    </div>
                <?php } ?>

                <input type="hidden" value="<?= $stock_id ?>" name="<?= $model->formName()  ?>[stock_id]"/>

                <div class="form-group">
                    <hr>
                    <?= Html::submitButton('Добавить', [
                        'class' => 'btn btn-default',
                        'name'  => 'contact-button',
                        'style' => 'width:100%',
                    ]) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

    <?php endif; ?>
</div>
