<?php

/**
 * SEO Package
 *
 * Copyright 2020 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

require_once dirname(__DIR__, 5) . '/model/modx/processors/context/getlist.class.php';

class SeoPackageContextGetListProcessor extends modContextGetListProcessor
{
    /**
     * @access public.
     * @return Mixed.
     */
    public function initialize()
    {
        $this->modx->getService('seopackage', 'SeoPackage', $this->modx->getOption('seopackage.core_path', null, $this->modx->getOption('core_path') . 'components/seopackage/') . 'model/seopackage/');

        return parent::initialize();
    }

    /**
     * @access public.
     * @param Array $list.
     * @return Array.
     */
    public function afterIteration(array $list)
    {
        array_unshift($list,[
            'key'   => '',
            'name'  => $this->modx->lexicon('seopackage.empty_context')
        ]);

        return $list;
    }
}

return 'SeoPackageContextGetListProcessor';
