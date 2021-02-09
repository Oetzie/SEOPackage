<?php

/**
 * SEO Package
 *
 * Copyright 2020 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

class SeoPackageRedirectRemoveProcessor extends modObjectRemoveProcessor
{
    /**
     * @access public.
     * @var String.
     */
    public $classKey = 'SeoPackageIP';

    /**
     * @access public.
     * @var Array.
     */
    public $languageTopics = 'seopackage:default';

    /**
     * @access public.
     * @var String.
     */
    public $objectType = 'seopackage.ip';

    /**
     * @access public.
     * @return Mixed.
     */
    public function initialize()
    {
        $this->modx->getService('seopackage', 'SeoPackage', $this->modx->getOption('seopackage.core_path', null, $this->modx->getOption('core_path') . 'components/seopackage/') . 'model/seopackage/');

        return parent::initialize();
    }
}

return 'SeoPackageRedirectRemoveProcessor';
