<?php
namespace suhanda\AdminLte\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use suhanda\AdminLte\helpers\Html;
use yii\widgets\Menu;

/**
 * Class NavBarMenu
 * @package suhanda\AdminLte\widgets
 */
class NavBarMenu extends Menu
{
    /**
     * @var string
     */
    public $submenuTemplate = "\n<ul class=\"dropdown-menu\">\n{items}\n</ul>\n";

    /**
     * @var string
     */
    public $linkTemplate = '<a href="{url}">{label}</a>';

    /**
     * @var bool
     */
    public $encodeLabels = false;

    /**
     * @var string
     */
    public $labelTemplate = '{icon} <span class="{class}">{label}</span>';

    /**
     * @var string
     */
    public $iconTemplate = '<i class="fa fa-{icon}"></i>';


    /**
     * Renders the menu.
     */
    public function run()
    {
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }
        if ($this->params === null) {
            $this->params = Yii::$app->request->getQueryParams();
        }
        $items = $this->normalizeItems($this->items, $hasActiveChild);

        if (!empty($items)) {
            $options = $this->options;
            Html::addCssClass($options, ['nav', 'navbar-nav']);

            $tag = ArrayHelper::remove($options, 'tag', 'ul');
            echo Html::tag($tag, $this->renderItems($items), $options);
        }
    }

    /**
     * Recursively renders the menu items (without the container tag).
     *
     * @param array $items the menu items to be rendered recursively
     *
     * @return string the rendering result
     */
    protected function renderItems($items)
    {
        $n     = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            if ($item['isHeader']) {
                Html::addCssClass($options, 'header');
                $lines[] = Html::tag($tag, $this->renderItem($item), $options);
                continue;
            }

            if (isset($item['isFooter']) && $item['isFooter']) {
                Html::addCssClass($options, 'footer');
                $lines[] = Html::tag($tag, $this->renderItem($item), $options);
                continue;
            }

            $options  = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $hasChild = !empty($item['items']);

            $class = [];

            if ($hasChild) {
                $class[] = 'dropdown';
            }

            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }
            if (!empty($class)) {
                if (empty($options['class'])) {
                    $options['class'] = implode(' ', $class);
                } else {
                    $options['class'] .= ' ' . implode(' ', $class);
                }
            }
            $menu = $this->renderItem($item);
            if ($hasChild) {
                $submenuTemplate = $this->submenuTemplate;
                $menu .= strtr($submenuTemplate, [
                    '{items}' => $this->renderItems($item['items']),
                ]);
            }
            $lines[] = Html::tag($tag, $menu, $options);
        }

        return implode("\n", $lines);
    }

    /**
     * Renders the content of a menu item.
     * Note that the container and the sub-menus are not rendered here.
     *
     * @param array $item the menu item to be rendered. Please refer to [[items]] to see what data might be in the item.
     *
     * @return string the rendering result
     */
    protected function renderItem($item)
    {
        if ($item['isHeader'] || $item['isInnerMenu']) {
            return $this->renderLabel($item);
        }

        if (!isset($item['url'])) {
            $item['url'] = "#";
        }
        $options = [];

        if (isset($item['items'])) {
            $options = [
                'data-toggle' => 'dropdown',
                'class'       => 'dropdown-toggle'
            ];
        }

        return Html::a($this->renderLabel($item), $item['url'], $options);

    }

    /**
     * @param $item
     *
     * @return string
     */
    public function renderLabel($item)
    {
        if ($item['isInnerMenu']) {
            return $item['label'];
        }
        $labelTemplate = ArrayHelper::getValue($item, 'labelTemplate', $this->labelTemplate);
        $iconTemplate  = ArrayHelper::getValue($item, 'iconTemplate', $this->iconTemplate);
        $icon          = '';

        if (isset($item['icon'])) {
            $icon = strtr($iconTemplate, [
                '{icon}' => $item['icon']
            ]);
        }


        $label = strtr($labelTemplate, [
            '{icon}'  => $icon,
            '{label}' => $item['label'],
            '{class}' => ArrayHelper::getValue($item, 'labelClass', '')
        ]);

        return $label;
    }


    /**
     * Normalizes the [[items]] property to remove invisible items and activate certain items.
     *
     * @param array $items the items to be normalized.
     * @param boolean $active whether there is an active child menu item.
     *
     * @return array the normalized menu items
     */
    protected function normalizeItems($items, &$active)
    {
        foreach ($items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
            $items[$i]['isHeader']    = ArrayHelper::getValue($item, 'isHeader', false);
            $items[$i]['isFooter']    = ArrayHelper::getValue($item, 'isFooter', false);
            $items[$i]['isInnerMenu'] = ArrayHelper::getValue($item, 'isInnerMenu', false);

            $label              = ArrayHelper::getValue($item, 'label', '');
            $encodeLabel        = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $items[$i]['label'] = $encodeLabel ? Html::encode($label) : $label;
            $hasActiveChild     = false;

            if (isset($item['items']) && !$items[$i]['isInnerMenu']) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
                if (empty($items[$i]['items']) && $this->hideEmptyItems) {
                    unset($items[$i]['items']);
                    if (!isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }
        }

        return array_values($items);
    }
}