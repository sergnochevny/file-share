<?php

namespace backend\widgets;

use yii\grid\CheckboxColumn;

class CustomCheckboxColumn extends CheckboxColumn
{
    public $templateHeader = '{input}';

    public $templateContent = '{input}';

    /**
     * Renders the header cell content.
     * The default implementation simply renders [[header]].
     * This method may be overridden to customize the rendering of the header cell.
     * @return string the rendering result
     */
    protected function renderHeaderCellContent()
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) {
            $name = $matches[1];

            $content = '';
            if ($name == 'input') {
                $content = parent::renderHeaderCellContent();
            }
            return $content;
        }, $this->templateHeader);
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index) {
            $name = $matches[1];

            $content = '';
            if ($name == 'input') {
                $content = parent::renderDataCellContent($model, $key, $index);
            }
            return $content;
        }, $this->templateContent);
    }
}
