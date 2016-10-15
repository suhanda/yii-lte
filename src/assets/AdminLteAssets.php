<?php
namespace suhanda\AdminLte\assets;

use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\web\YiiAsset;

/**
 * Class AdminLteAssets
 *
 * @package suhanda\AdminLte\assets
 * @author  Dedi Suhanda <dedi.suhanda@gmail.com>
 */
class AdminLteAssets extends AssetBundle
{
    /**
     *
     * @var string
     */
    public static $skin   = 'skin-black';

    public static $layout = 'layout-boxed';

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
        $this->addDependency(FontAwesomeAssets::class);
        $this->addDependency(BootstrapAsset::class);
        $this->addDependency(BootstrapPluginAsset::class);

        parent::init();
    }
}