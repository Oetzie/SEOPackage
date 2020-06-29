<?php

/**
 * SEO Package
 *
 * Copyright 2020 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

abstract class SeoPackageManagerController extends modExtraManagerController
{
    /**
     * @access public.
     * @return Mixed.
     */
    public function initialize()
    {
        $this->modx->getService('seopackage', 'SeoPackage', $this->modx->getOption('seopackage.core_path', null, $this->modx->getOption('core_path') . 'components/seopackage/') . 'model/seopackage/');

        $this->addCss($this->modx->seopackage->config['css_url'] . 'mgr/seopackage.css');

        $this->addJavascript($this->modx->seopackage->config['js_url'] . 'mgr/seopackage.js');

        $this->addJavascript($this->modx->seopackage->config['js_url'] . 'mgr/extras/extras.js');

        $this->addHtml('<script type="text/javascript">
            Ext.onReady(function() {
                MODx.config.help_url = "' . $this->modx->seopackage->getHelpUrl() . '";
                
                SeoPackage.config = ' . $this->modx->toJSON(array_merge($this->modx->seopackage->config, [
                    'branding_url'          => $this->modx->seopackage->getBrandingUrl(),
                    'branding_url_help'     => $this->modx->seopackage->getHelpUrl()
                ])) . ';
            });
        </script>');

        return parent::initialize();
    }

    /**
     * @access public.
     * @return Array.
     */
    public function getLanguageTopics()
    {
        return $this->modx->seopackage->config['lexicons'];
    }

    /**
     * @access public.
     * @returns Boolean.
     */
    public function checkPermissions()
    {
        return $this->modx->hasPermission('seopackage');
    }
}

class IndexManagerController extends SeoPackageManagerController
{
    /**
     * @access public.
     * @return String.
     */
    public static function getDefaultController()
    {
        return 'home';
    }
}
