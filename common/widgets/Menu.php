<?php
namespace common\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\helpers\Url;

class Menu extends \yii\widgets\Menu
{

    final protected function renderItem($item)
    {
        $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
        if (isset($item['options']['icon'])) {
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

    protected function isItemActive($item)
    {
        if (isset($item['url']) && isset($item['url'][0])) {
            $route = is_array($item['url']) ? $item['url'][0] : $item['url'];
            $route = Yii::getAlias(str_replace(Yii::$app->request->hostInfo . Yii::$app->request->baseUrl, '', $route));
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }
            if (ltrim($route, '/') !== str_replace('/index', '', $this->route)) {
                return false;
            }
            if(is_array($item['url'])){
                unset($item['url']['#']);
                if (count($item['url']) > 1) {
                    $params = $item['url'];
                    unset($params[0]);
                    foreach ($params as $name => $value) {
                        if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                            return false;
                        }
                    }
                }
            }
            return true;
        }
        return false;
    }

}
