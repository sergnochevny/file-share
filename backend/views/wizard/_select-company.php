<?php
/** @var $this \yii\web\View */

$user = Yii::$app->getUser();
?>
<?php if ($user->can('admin')): ?>
<select id="demo-select2-1-3" class="form-control">
    <option value=""> - - -</option>
    <option value="">Stark Industries</option>
    <option value="">Stark Industries2</option>
    <option value="">Stark Industries</option>
    <option value="">Stark Industries2</option>
    <option value="">Stark Industries</option>
    <option value="">Stark Industries2</option>
    <option value="">Stark Industries</option>
    <option value="">Stark Industries2</option>
    <option value="">Stark Industries</option>
    <option value="">Stark Industries2</option>
    <option value="">Stark Industries</option>
    <option value="">Stark Industries2</option>
    <option value="">Stark Industries</option>
    <option value="">Stark Industries2</option>
    <option value="">Stark Industries</option>
    <option value="">Stark Industries2</option>
    <option value="">Stark Industries</option>
    <option value="">Stark Industries2</option>
    <option value="">Stark Industries</option>
    <option value="">Stark Industries2</option>
</select>
<span class="help-block">For convenience, use the quick search</span>
<?php elseif ($user->can('client')): ?>
there so company already selected
<?php endif ?>