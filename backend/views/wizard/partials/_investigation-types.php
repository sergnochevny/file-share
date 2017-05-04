<?php
use common\helpers\Url;


/** @var $form \backend\widgets\ActiveForm */
/** @var $model \backend\models\Investigation */
/** @var $types array */
?>

<?php \yii\widgets\Pjax::begin([
    'id' => 'types-container',
    'enablePushState' => false,
    'timeout' => 0,
    'options' => [
        'data-url' => Url::to(['/wizard/update-types'])
    ]
]) ?>
<?= $form->field($model, 'investigationTypeIds')-> checkboxList($types + ['-1' => 'Other'], [
    'item' => function($index, $label, $name, $checked, $value) {
        $checked = $checked ? 'checked' : '';
        return '<label><input tabindex="' . (6 + $index) . '" type="checkbox" name="' . $name . '" value="' . $value . '" ' . $checked . '> ' . $label . '</label>';
    },
    'class' => 'investigation-types'
]) ?>
<?php \yii\widgets\Pjax::end() ?>
