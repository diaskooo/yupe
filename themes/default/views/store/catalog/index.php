<?php
/* @var $category Category */

$this->pageTitle = $category ? ($category->meta_title ?: $category->name) : Yii::t('StoreModule.catalog', 'Products');
$this->breadcrumbs = array(Yii::t("StoreModule.catalog", "Каталог") => array('/store/catalog/index'));
$this->description = $category ? $category->meta_description : "";
$this->keywords = $category ? $category->meta_keywords : "";

if ($category) {
    $this->breadcrumbs = array_merge(
        $this->breadcrumbs,
        $category->getBreadcrumbs(true)
    );
}

?>

<div class="row">
    <div class="col-xs-12">
        <h2><?php echo Yii::t("StoreModule.catalog", "Каталог продукции"); ?></h2>
    </div>
</div>

<div class="row">
    <section class="catalog-filter col-sm-12">
        <form action="">
            <div class="input-group">
                <?php
                $this->widget(
                    'zii.widgets.jui.CJuiAutoComplete',
                    array(
                        'name' => 'q',
                        'value' => Yii::app()->getRequest()->getParam('q'),
                        'source' => $this->createUrl('/store/catalog/autocomplete'),
                        // additional javascript options for the autocomplete plugin
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 3,
                        ),
                        'htmlOptions' => array(
                            'class' => 'form-control',
                        ),
                    )
                );
                ?>
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default"><?php echo Yii::t("StoreModule.catalog", "поиск"); ?> <i class="glyphicon glyphicon-search"></i></button>
                </span>
            </div>
        </form>
    </section>
</div>
<div class="row">
    <div class="col-sm-3">
        <h3>
            <span><?php echo Yii::t("StoreModule.catalog", "Категории"); ?></span>
        </h3>
        <div class="category-tree">
            <?php
            $cat = new StoreCategory();
            $tree = $cat->getMenuList(5);
            $this->widget('zii.widgets.CMenu', array('items' => $tree,));
            ?>
        </div>
    </div>
    <div class="col-sm-9">
        <section>
            <div class="sub-categories">
                <?php $subCats = isset($category) ? $category->getMenuList() : null; ?>
                <?php if ($subCats): ?>
                    <p><?php echo Yii::t("StoreModule.catalog", "Подкатегории"); ?>:</p>
                    <?php $this->widget('zii.widgets.CMenu', array('items' => $subCats)); ?>
                <?php endif; ?>
            </div>
            <div class="grid">
                <?php $this->widget(
                    'zii.widgets.CListView',
                    array(
                        'dataProvider' => $dataProvider,
                        'itemView' => '_view',
                        'summaryText' => '',
                        'enableHistory' => true,
                        'cssFile' => false,
                        'pager' => array(
                            'cssFile' => false,
                            'htmlOptions' => array('class' => 'pagination'),
                            'header' => '',
                            'firstPageLabel' => '&lt;&lt;',
                            'lastPageLabel' => '&gt;&gt;',
                            'nextPageLabel' => '&gt;',
                            'prevPageLabel' => '&lt;',
                        ),
                        'sortableAttributes' => array(
                            'sku',
                            'name',
                        ),
                    )
                ); ?>
            </div>
        </section>
    </div>
</div>

