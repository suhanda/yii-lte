<?php
namespace suhanda\AdminLte\assets;


/**
 * Class ChartJsAssets
 *
 * @package suhanda\AdminLte\assets
 */
class ChartJsAssets extends AssetBundle
{
    public function init()
    {
        $this->setSourcePath('@vendor/bower/chart.js/dist');
        $this->setupAssets('js', [
            "Chart",
        ]);

        parent::init();
    }
}