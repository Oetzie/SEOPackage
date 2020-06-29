<?php

/**
 * SEO Package
 *
 * Copyright 2020 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

require_once dirname(__DIR__) . '/index.class.php';

class SeoPackageHomeManagerController extends SeoPackageManagerController
{
    /**
     * @access public.
     */
    public function loadCustomCssJs()
    {
        $this->addJavascript($this->modx->seopackage->config['js_url'] . 'mgr/widgets/home.panel.js');

        $this->addJavascript($this->modx->seopackage->config['js_url'] . 'mgr/widgets/redirects.grid.js');
        $this->addJavascript($this->modx->seopackage->config['js_url'] . 'mgr/widgets/errors.grid.js');

        $this->addLastJavascript($this->modx->seopackage->config['js_url'] . 'mgr/sections/home.js');
    }

    /**
     * @access public.
     * @return String.
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('seopackage');
    }

    /**
     * @access public.
     * @return String.
     */
    public function getTemplateFile()
    {
        return $this->modx->seopackage->config['templates_path'] . 'home.tpl';
    }
}
