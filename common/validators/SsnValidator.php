<?php


namespace common\validators;


use yii\validators\StringValidator;
use yii\validators\ValidationAsset;

class SsnValidator extends StringValidator
{
    /***
     * Removes spaces before js validation
     *
     * @param \yii\base\Model $model
     * @param string $attribute
     * @param \yii\web\View $view
     * @return string
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        ValidationAsset::register($view);
        $options = $this->getClientOptions($model, $attribute);

        //remove special chars from masked input
        return 'yii.validation.string(value.replace(/[-_]/g, ""), messages, ' . json_encode($options,
                JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ');';
    }
}