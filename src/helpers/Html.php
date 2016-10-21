<?php
namespace suhanda\AdminLte\helpers;

use yii\bootstrap\Html as BootstrapHtml;
use yii\helpers\ArrayHelper;


/**
 * Class Html
 *
 * @package suhanda\AdminLte\helpers
 */
class Html extends BootstrapHtml
{
    /**
     * @param string $name
     * @param array  $options
     * @return string
     */
    public static function icon($name, $options = [])
    {
        $tag         = ArrayHelper::remove($options, 'tag', 'i');
        $classPrefix = ArrayHelper::remove($options, 'prefix', 'fa fa-');
        static::addCssClass($options, $classPrefix . $name);

        return static::tag($tag, '', $options);
    }
}