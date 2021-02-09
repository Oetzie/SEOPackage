<?php

/**
 * SEO Package
 *
 * Copyright 2020 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

class SeoPackageIPsGetListProcessor extends modObjectGetListProcessor
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
    public $languageTopics = ['seopackage:default'];

    /**
     * @access public.
     * @var String.
     */
    public $defaultSortField = 'description';

    /**
     * @access public.
     * @var String.
     */
    public $defaultSortDirection = 'ASC';

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

        $this->setDefaultProperties([
            'dateFormat' => $this->modx->getOption('manager_date_format') . ', ' . $this->modx->getOption('manager_time_format'),
        ]);

        return parent::initialize();
    }

    /**
     * @access public.
     * @param xPDOQuery $criteria.
     * @return xPDOQuery.
     */
    public function prepareQueryBeforeCount(xPDOQuery $criteria)
    {
        $context = $this->getProperty('context');

        if (!empty($context)) {
            $criteria->where([
                'context:IN' => [$context, '']
            ]);
        }

        $query = $this->getProperty('query');

        if (!empty($query)) {
            $criteria->where([
                'ip:LIKE'               => '%' . $query . '%',
                'OR:description:LIKE'   => '%' . $query . '%'
            ]);
        }

        $type = $this->getProperty('type');

        if (!empty($type)) {
            $criteria->where([
                'type' => $type
            ]);
        }

        return $criteria;
    }

    /**
     * @access public.
     * @param xPDOObject $object.
     * @return Array.
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = $object->toArray();

        if (in_array($object->get('editedon'), ['-001-11-30 00:00:00', '-1-11-30 00:00:00', '0000-00-00 00:00:00', null], true)) {
            $array['editedon'] = '';
        } else {
            $array['editedon'] = date($this->getProperty('dateFormat'), strtotime($object->get('editedon')));
        }

        return $array;
    }
}

return 'SeoPackageIPsGetListProcessor';
