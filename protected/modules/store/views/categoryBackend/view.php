<?php
$this->breadcrumbs = array(
    Yii::t('StoreModule.category', 'Categories') => array('index'),
    $model->name,
);

$this->pageTitle = Yii::t('StoreModule.category', 'Categories - show');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('StoreModule.category', 'Category manage'), 'url' => array('/store/categoryBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('StoreModule.category', 'Create category'), 'url' => array('/store/categoryBackend/create')),
    array('label' => Yii::t('StoreModule.category', 'Category') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array(
        'icon' => 'glyphicon glyphicon-pencil',
        'label' => Yii::t('StoreModule.category', 'Change category'),
        'url' => array(
            '/store/categoryBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'glyphicon glyphicon-eye-open',
        'label' => Yii::t('StoreModule.category', 'View category'),
        'url' => array(
            '/store/categoryBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'glyphicon glyphicon-trash',
        'label' => Yii::t('StoreModule.category', 'Remove category'),
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('/store/categoryBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('StoreModule.category', 'Do you really want to remove the category?'),
            'csrf' => true,
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.category', 'Show category'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data' => $model,
        'attributes' => array(
            'id',
            array(
                'name' => 'parent_id',
                'value' => $model->getParentName(),
            ),
            'name',
            'alias',
            array(
                'name' => 'image',
                'type' => 'raw',
                'value' => $model->image ? CHtml::image($model->getImageUrl(200, 200), $model->name) : '---',
            ),
            array(
                'name' => 'description',
                'type' => 'raw'
            ),
            array(
                'name' => 'short_description',
                'type' => 'raw'
            ),
            array(
                'name' => 'status',
                'value' => $model->getStatus(),
            ),
        ),
    )
); ?>
