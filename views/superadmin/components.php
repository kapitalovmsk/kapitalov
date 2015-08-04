<?php
/**
 * @var array $newItems
 * @var array $gridViewOptions
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
$this->title = 'Компоненты';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('/js/pages/superadmin/components.js', ['depends' => ['yii\grid\GridViewAsset']]);

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (count($newItems['dataProvider']->allModels) > 0){ ?>
        <h2>Новые компоненты</h2>
        <?php
        echo GridView::widget($newItems);
        ?>
    <?php } ?>
    <h2>Установленные компоненты</h2>
    <?php
    echo GridView::widget($gridViewOptions);
    ?>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Конфигурация компонента</h4>
            </div>
            <div class="modal-body">
                Конфигурация:<br>
                <textarea id="configText" rows="20" cols="60"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </div>
</div>


