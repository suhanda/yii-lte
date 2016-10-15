<?php
namespace yii\lte\widgets;


use Yii;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Menu;

/**
 * Class SideBarMenu
 *
 * * Menu displays a multi-level menu using nested HTML lists.
 *
 * The main property of Menu is [[items]], which specifies the possible items in the menu.
 * A menu item can contain sub-items which specify the sub-menu under that menu item.
 *
 * Menu checks the current route and request parameters to toggle certain menu items
 * with active state.
 *
 * Note that Menu only renders the HTML tags about the menu. It does do any styling.
 * You are responsible to provide CSS styles to make it look like a real menu.
 *
 * The following example shows how to use Menu:
 *
 * ```php
 * echo Menu::widget([
 *     'items' => [
 *         // Important: you need to specify url as 'controller/action',
 *         // not just as 'controller' even if default action is used.
 *         ['label' => 'Home', 'url' => ['site/index']],
 *         // you can add header section with string
 *         "Product"
 *         // 'Products' menu item will be selected as long as the route is 'product/index'
 *         ['label' => 'Products', 'url' => ['product/index'], 'items' => [
 *             ['label' => 'New Arrivals', 'icon'=>'user', 'url' => ['product/index', 'tag' => 'new']],
 *             ['label' => 'Most Popular', 'url' => ['product/index', 'tag' => 'popular']],
 *         ]],
 *         ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
 *     ],
 * ]);
 * ```
 *
 * @package yii\lte\widgets
 * @author  Dedi Suhanda <dedi.suhanda@gmail.com>
 */
class SideBarMenu extends Menu
{

    public $hasChildTemplate = '<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>';

    public $submenuTemplate = "\n<ul class=\"treeview-menu\">\n{items}\n</ul>\n";

    public $linkTemplate = '<a href="{url}">{label}</a>';

    public $encodeLabels = false;

    public $activateParents = true;

    public $labelTemplate = '{icon}<span>{label}</span>{hasChild}';

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
            Html::addCssClass($options, 'sidebar-menu');

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

        $lines = [];
        foreach ($items as $i => $item) {
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            if ($item['isHeader']) {
                Html::addCssClass($options, 'header');
                $lines[] = Html::tag($tag, $this->renderItem($item), $options);
                continue;
            }
            $options  = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $hasChild = !empty($item['items']);


            if (!empty($class)) {
                if (empty($options['class'])) {
                    $options['class'] = implode(' ', $class);
                } else {
                    $options['class'] .= ' ' . implode(' ', $class);
                }
            }
            $menu = $this->renderItem($item);
            if ($hasChild) {
                $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $this->submenuTemplate);
                $menu .= strtr($submenuTemplate, [
                    '{items}' => $this->renderItems($item['items']),
                ]);
            }
            $lines[] = Html::tag($tag, $menu, $options);
        }

        return implode("\n", $lines);
    }


    protected function generateItemClass($items, $index)
    {
        $last = count($items) - 1;
        $item = $items[$index];

        $hasChild = !empty($item['items']);
        $class    = [];

        if ($hasChild) {
            $class[] = 'treeview';
        }
        if ($item['active']) {
            $class[] = $this->activeCssClass;
        }
        if ($index === 0 && $this->firstItemCssClass !== null) {
            $class[] = $this->firstItemCssClass;
        }
        if ($index === $last && $this->lastItemCssClass !== null) {
            $class[] = $this->lastItemCssClass;
        }

        if (isset($item['url'])) {
            $class[] = 'header';
        }

        return $class;
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
        if ($item['isHeader']) {
            return $this->renderLabel($item);
        }

        if (!isset($item['url'])) {
            $item['url'] = "#";
        }

        $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);

        return strtr($template, [
            '{url}'   => Html::encode(Url::to($item['url'])),
            '{label}' => $this->renderLabel($item),
        ]);

    }

    public function renderLabel($item)
    {
        $hasChild      = !empty($item['items']);
        $labelTemplate = ArrayHelper::getValue($item, 'labelTemplate', $this->labelTemplate);
        $iconTemplate  = ArrayHelper::getValue($item, 'iconTemplate', $this->iconTemplate);
        $icon          = '';

        if (isset($item['icon'])) {
            $icon = strtr($iconTemplate, [
                '{icon}' => $item['icon']
            ]);
        }

        if (isset($item['badges'])) {
            $side = $this->renderBadges($item);
        } else {
            $side = $hasChild ? $this->hasChildTemplate : "";
        }

        $label = strtr($labelTemplate, [
            '{icon}'     => $icon,
            '{label}'    => $item['label'],
            '{hasChild}' => $side
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
            if (is_string($item)) {
                $items[$i] = ['label' => $item, 'isHeader' => true];
                continue;
            }

            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }

            $items[$i]['isHeader'] = ArrayHelper::getValue($item, 'isHeader', false);
            $label                 = ArrayHelper::getValue($item, 'label', '');
            $encodeLabel           = ArrayHelper::getValue($item, 'encode', $this->encodeLabels);
            $items[$i]['label']    = $encodeLabel ? Html::encode($label) : $label;
            $hasActiveChild        = false;

            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
                if (empty($items[$i]['items']) && $this->hideEmptyItems) {
                    unset($items[$i]['items']);
                    if (!isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }
            if (!isset($item['active'])) {
                if ($this->activateParents && $hasActiveChild || $this->activateItems && $this->isItemActive($item)) {
                    $active = $items[$i]['active'] = true;
                } else {
                    $items[$i]['active'] = false;
                }
            } elseif ($item['active']) {
                $active = true;
            }
        }

        return array_values($items);
    }


    /**
     * @param $item
     *
     * @return string
     */
    protected function renderBadges($item)
    {
        $template = '<span class="pull-right-container">{items}</span>';

        $colors   = [];
        $contents = [];
        foreach ($item['badges'] as $badge) {
            $explode    = explode('#', $badge);
            $contents[] = $explode[0];
            $colors[]   = isset($explode[1]) ? $explode[1] : 'blue';
        }

        $items = array_map(function ($color, $content) {
            $tpl = '<small class="label pull-right bg-{color}">{content}</small>';

            return strtr($tpl, [
                '{color}'   => $color,
                '{content}' => $content
            ]);
        }, $colors, $contents);

        return strtr($template, [
            '{items}' => implode("\n", $items)
        ]);

    }
}