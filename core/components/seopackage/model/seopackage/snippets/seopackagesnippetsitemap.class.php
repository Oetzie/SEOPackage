<?php

/**
 * SEO Package
 *
 * Copyright 2020 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

require_once dirname(__DIR__) . '/seopackagesnippets.class.php';

class SeoPackageSnippetSitemap extends SeoPackageSnippets
{
    /**
     * @access public.
     * @var Array.
     */
    public $properties = [
        'tpl'                   => '@FILE elements/chunks/item.chunk.tpl',
        'tplWrapper'            => '@FILE elements/chunks/wrapper.chunk.tpl',
        'tplWrapperEmpty'       => '',

        'usePdoTools'           => false,
        'usePdoElementsPath'    => false
    ];

    /**
     * @access public.
     * @param Array $properties.
     * @return String.
     */
    public function run(array $properties = [])
    {
        $this->setProperties($properties);

        $output = [];

        $criteria = $this->modx->newQuery('modResource');

        $criteria->select($this->modx->getSelectColumns('modResource', 'modResource'));
        $criteria->select($this->modx->getSelectColumns('SeoPackageResource', 'SeoPackageResource', 'seo_'));

        $criteria->leftJoin('SeoPackageResource', 'SeoPackageResource', 'SeoPackageResource.resource_id = modResource.id');

        $criteria->where([
            'modResource.context_key'   => $this->modx->context->get('key'),
            'modResource.published'     => 1,
            'modResource.deleted'       => 0
        ]);

        if ($this->config['seo_sitemap'] === 0) {
            $criteria->where([
                'SeoPackageResource.index = 1'
            ]);
        } else {
            $criteria->where([
                '`SeoPackageResource`.`index` = 1 OR `SeoPackageResource`.`index` IS NULL'
            ]);
        }

        if ($this->config['seo_sitemap'] === 0) {
            $criteria->where([
                'SeoPackageResource.sitemap = 1'
            ]);
        } else {
            $criteria->where([
                '`SeoPackageResource`.`sitemap` = 1 OR `SeoPackageResource`.`sitemap` IS NULL'
            ]);
        }

        $criteria->groupby('modResource.id');

        foreach ($this->modx->getCollection('modResource', $criteria) as $resource) {
            $output[] = $this->getChunk($this->getProperty('tpl'), [
                'url'           => $this->modx->makeUrl($resource->get('id'), '', '', 'full'),
                'lastmod'       => date('c', strtotime((($resource->get('editedon') > 0) ? $resource->get('editedon') : $resource->get('createdon')))),
                'changefreq'    => $resource->get('seo_sitemap_freq') ?: $this->config['seo_sitemap_freq'],
                'priority'      => $resource->get('seo_sitemap_prio') ?: $this->config['seo_sitemap_prio']
            ]);
        }

        if (!empty($output)) {
            $tplWrapper = $this->getProperty('tplWrapper');

            if (!empty($tplWrapper)) {
                return $this->getChunk($tplWrapper, [
                    'output' => implode(PHP_EOL, $output)
                ]);
            }

            return implode(PHP_EOL, $output);
        }

        $tplWrapperEmpty = $this->getProperty('tplWrapperEmpty');

        if (!empty($tplWrapperEmpty)) {
            return $this->getChunk($tplWrapperEmpty);
        }

        return '';
    }
}
