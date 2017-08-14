<?php

namespace common\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\helpers\Url;

class Menu extends \yii\widgets\Menu
{

    /**
     * @var callable a PHP callable that returns true|false or null to handle by standart.
     * The signature of the callable should be `function ($widget, $item)`.
     */
    public $activeItem;

    /**
     * Auth model. add visible parameters to items on url based method.
     * @param array $items the items to be normalized.
     * @return array the prepared menu items
     */
    protected function prepareItems($items)
    {
        foreach ($items as $i => $item) {
            if (isset($item['visible'])) {
                if (isset($item['url'])) {
                    $permission = str_replace('/', '.', ltrim(\yii\helpers\Url::to($item['url']), ['/']));
                    $item['visible'] = $item['visible'] && \Yii::$app->user->can($permission);
                }
            }
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->prepareItems($item['items']);
            }
        }

        return array_values($items);
    }


    /**
     * @inheritdoc
     */
    final protected function renderItem($item)
    {
        $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
        if (isset($item['options']['icon'])) {
            $template = strtr($template, [
                '{icon}' => Html::encode($item['options']['icon']),
            ]);
        } else {
            $template = strtr($template, ['{icon}' => null,]);
        }
        if (isset($item['badges'])) {
            $badges = $item['badges'];
            if ($badges instanceof \Closure) {
                $badges = call_user_func($badges);
            }
            $template = strtr($template, ['{badges}' => $badges,]);
        } else {
            $template = strtr($template, [
                '{badges}' => null,
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

    /**
     * @inheritdoc
     */
    protected function isItemActive($item)
    {
        if (isset($this->activeItem) && ($this->activeItem instanceof \Closure)) {
            $res = call_user_func($this->activeItem, $this, $item);
            if (isset($res)) {
                return $res;
            }
        }
        if (isset($item['url']) && isset($item['url'][0])) {
            $route = is_array($item['url']) ? $item['url'][0] : $item['url'];
            $route = Yii::getAlias(str_replace(Yii::$app->request->hostInfo . Yii::$app->request->baseUrl, '', $route));
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }
            if (
                (ltrim($route, '/') !== str_replace('/index', '', $this->route)) &&
                (ltrim($route, '/') !== $this->route)
            ) {
                return false;
            }
            if (is_array($item['url'])) {
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
