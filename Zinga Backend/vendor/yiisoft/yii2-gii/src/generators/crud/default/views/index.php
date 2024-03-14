<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="configuration">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4 class="form-section" style="margin-bottom: 0px"><?= "<?= " ?>$this->title; ?></h4>
					<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
					<div class="heading-elements">
							<ul class="list-inline mb-0">
								<!-- <li><a data-action="collapse"><i class="ft-minus"></i></a></li> -->
								<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
								<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
								<!-- <li><a data-action="close"><i class="ft-x"></i></a></li> -->
							</ul>
					</div>
				</div>
				<div class="card-content collapse show">
					<div class="card-body card-dashboard">
						<div>
                            <?= "<?= " ?>(isset($rights->create) && $rights->create == 1) ? Html::a('<i class="ft-plus"></i> Add', ['create'], ['class' => 'btn btn-primary mr-1']) : '' ?>	
						</div>

                        <?= $generator->enablePjax ? "    <?php Pjax::begin(); ?>\n" : '' ?>
                        <?php if(!empty($generator->searchModelClass)): ?>
                        <?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
                        <?php endif; ?>

<?php if ($generator->indexWidgetType === 'grid'): ?>
                        <?= "<?= " ?>GridView::widget([
                            'dataProvider' => $dataProvider,
                            'layout' => '{items}',
                            'tableOptions' => [
                                'class' => 'custom-table table-striped table-bordered zero-configuration',
                            ],
                            <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'headerOptions' => ['width' => '5%'],
                                ],

                                <?php
                                    $count = 0;
                                    if (($tableSchema = $generator->getTableSchema()) === false) {
                                        foreach ($generator->getColumnNames() as $name) {
                                            if (++$count < 6) {
                                                echo "                                '" . $name . "',\n";
                                            } else {
                                                echo "                                //'" . $name . "',\n";
                                            }
                                        }
                                    } else {
                                        foreach ($tableSchema->columns as $column) {
                                            $format = $generator->generateColumnFormat($column);
                                            if (++$count < 6) {
                                                echo "                                 '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                                            } else {
                                                echo "                                //'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                                            }
                                        }
                                    }
                                ?>
                                [
									'attribute' => 'createdTime',
									'format' => ['date', 'php:d/m/Y h:i a'],
									'headerOptions' => ['width' => '17%'],
								],
								[
									'label' => 'Created By',
									'attribute' => 'user.fullName',
									'headerOptions' => ['width' => '15%'],
								],

                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
                                    'template' => '{view} {delete}',
                                    'buttons' => [
                                        'view' => function ($url, $model) use ($rights) {
                                            return (isset($rights->view) && $rights->view ==1) ? Html::a('<i class="ft-eye"></i> View', ['view', 'id' => $model-><?= $generator->getNameAttribute() ?>], ['class' => 'btn-sm btn-primary']) : '';
                                        },
                                        'delete' => function ($url, $model) use ($rights) {
                                            return (isset($rights->delete) && $rights->delete ==1) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model-><?= $generator->getNameAttribute() ?>], [
                                                'class' => 'btn-sm btn-danger btn-xs',
                                                'data' => [
                                                    'confirm' => 'Are you absolutely sure ? You will lose all the information with this action.',
                                                    'method' => 'post',
                                                ],
                                            ]) : '';
                                        },
                                    ],
                                ],
                            ],
                        ]); ?>

                        <?php else: ?>
                            <?= "<?= " ?>ListView::widget([
                                'dataProvider' => $dataProvider,
                                'itemOptions' => ['class' => 'item'],
                                'itemView' => function ($model, $key, $index, $widget) {
                                    return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
                                },
                            ]) ?>
                        <?php endif; ?>

                        <?= $generator->enablePjax ? "    <?php Pjax::end(); ?>\n" : '' ?>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>