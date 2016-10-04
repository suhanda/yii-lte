<?php
namespace yii\lte\assets;

use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\web\YiiAsset;

/**
 * Class AdminLteAssets
 *
 * @package yii\lte\assets
 * @author  Dedi Suhanda <dedi.suhanda@gmail.com>
 */
class AdminLteAssets extends AssetBundle
{
    public function init()
    {
        $this->setSourcePath('@vendor/almasaeed2010/adminlte/dist');
        $this->setupAssets('css', [
            "css/AdminLTE",
            "css/skins/_all-skins"
        ]);
        $this->setupAssets('js', [
            'js/app'
        ]);
        $this->addDependency(YiiAsset::class);
        $this->addDependency(BootstrapAsset::class);
        $this->addDependency(BootstrapPluginAsset::class);

        parent::init();
    }
}