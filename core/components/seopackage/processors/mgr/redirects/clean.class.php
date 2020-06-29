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
            'context:IN'    => [$this->getProperty('context'), ''],
            'active'        => 2,
            'last_visit:<'  => date('Y-m-d', strtotime('-' . $this->getProperty('days', $this->modx->seopackage->getOption('clean_days')) .' days'))
        ]);

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
