<?php

/**
 * SEO Package
 *
 * Copyright 2020 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

class SeoPackageRedirectsResetProcessor extends modObjectProcessor
{
    /**
     * @access public.
     * @var String.
     */
    public $classKey = 'SeoPackageRedirect';

    /**
     * @access public.
     * @var Array.
     */
    public $languageTopics = ['seopackage:default'];

    /**
     * @access public.
     * @var String.
     */
    public $objectType = 'seopackage.redirect';

    /**
     * @access public.
     * @return Mixed.
     */
    public function initialize()
    {
        $this->modx->getService('seopackage', 'SeoPackage', $this->modx->getOption('seopackage.core_path', null, $this->modx->getOption('core_path') . 'components/seopackage/') . 'model/seopackage/');

        $this->setDefaultProperties([
            'type' => 'redirect'
        ]);

        return parent::initialize();
    }

    /**
     * @access public.
     * @return Mixed.
     */
    public function process()
    {
        if ($this->getProperty('type') === 'error') {
            $this->modx->removeCollection($this->classKey, [
                'context:IN'    => [$this->getProperty('context'), ''],
                'active'        => 2
            ]);
        } else {
            $this->modx->removeCollection($this->classKey, [
                'context:IN'    => [$this->getProperty('context'), ''],
                'active:!='     => 2
            ]);
        }

        return $this->outputArray([]);
    }
}

return 'SeoPackageRedirectsResetProcessor';
