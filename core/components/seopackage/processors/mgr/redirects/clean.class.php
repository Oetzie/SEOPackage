<?php

/**
 * SEO Package
 *
 * Copyright 2020 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

class SeoPackageRedirectsCleanProcessor extends modObjectProcessor
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

        return parent::initialize();
    }

    /**
     * @access public.
     * @return Mixed.
     */
    public function process()
    {
        $amount = 0;

        $criteria = $this->modx->newQuery($this->classKey);

        $criteria->where([
            'active'    => 2
        ]);

        $context    = $this->getProperty('context');
        $days       = (int) $this->getProperty('days', $this->modx->seopackage->getOption('clean_days'));
        $hits       = (int) $this->getProperty('hits', $this->modx->seopackage->getOption('clean_hits'));

        if (!empty($context)) {
            $criteria->where([
                'context' => $context
            ]);
        }

        if ($days > 0) {
            $criteria->where([
                'last_visit:<' => date('Y-m-d', strtotime('-' . $days .' days'))
            ]);
        }

        if ($hits > 0) {
            $criteria->where([
                'visits:<' => $hits
            ]);
        }

        foreach ($this->modx->getCollection($this->classKey, $criteria) as $object) {
            if ($object->remove()) {
                $amount++;
            }
        }

        return $this->success($this->modx->lexicon('seopackage.errors_clean_success', [
            'amount' => $amount
        ]));
    }
}

return 'SeoPackageRedirectsCleanProcessor';
