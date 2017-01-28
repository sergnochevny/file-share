<?php
namespace common\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class Menu extends \yii\widgets\Menu
{

    final protected function renderItem($item)
    {
        $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
        if(isset($item['options']['icon'])){
            $template = strtr($template, [
                '{icon}' => Html::encode(Url::to($item['options']['icon'])),
            ]);
        }
        if (isset($item['url'])) {
            $template = strtr($template, [
                '{url}' => Html::encode(Url::to($item['url'])),
            ]);
        } else {
            $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);
        }

        return strtr($template, [
            '{label}' => $item['label'],
        ]);
    }

}
