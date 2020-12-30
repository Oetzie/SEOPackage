<?php

/**
 * SEO Package
 *
 * Copyright 2020 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

class SeoPackageResourcesMetaProcessor extends modProcessor
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
    public $objectType = 'seopackage.meta';

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
        $this->modx->switchContext($this->getProperty('context_key', $this->modx->getOption('default_context')));

        $output = array_merge($this->getProperties(), [
            'domain'    => '',
            'secure'    => false,
            'favicon'   => '',
            'url'       => '',
            'counters'  => []
        ]);

        $resource = $this->modx->newObject('modResource', $this->getProperties());

        if ($resource) {
            $scheme     = $this->modx->getOption('link_tag_scheme');
            $basePath   = '';

            $output['domain'] = trim(str_replace(['http://', 'https://'], '', $this->modx->getOption('site_url')), '/');

            if ($scheme === 'http' || (int) $scheme === 0) {
                $output['secure'] = false;
            } else if ($scheme === 'https' || (int) $scheme === 1) {
                $output['secure'] = true;
            } else {
                $output['secure'] = strpos($this->modx->getOption('site_url'), 'https') === 0;
            }

            if ((int) $this->modx->getOption('friendly_urls') === 1) {
                if ((int) $this->modx->getOption('site_start') !== (int) $this->getProperty('id')) {
                    $basePath = $resource->getAliasPath($resource->get('alias'), $this->getProperties());
                }
            } else {
                $basePath = $this->modx->getOption('request_controller') . '?' . $this->modx->getOption('request_param_id') . '=' . $this->getProperty('id');
            }

            $output['url'] = trim($basePath, '/');
        }

        $title                  = $this->modx->seopackage->getSeoMeta('title', $this->getProperties());
        $description            = $this->modx->seopackage->getSeoMeta('description', $this->getProperties());

        $output['title']        = $title['processed'];
        $output['description']  = $description['processed'];
        $output['favicon']      = '//www.google.com/s2/favicons?domain=' . $output['domain'];

        $output['counters']     = [
            'longtitle'             => strlen($title['unprocessed']),
            'description'           => strlen($description['unprocessed'])
        ];

        if (empty($output['description'])) {
            $output['description'] = $this->modx->lexicon('seopackage.seo_preview_desc');
        }

        if (isset($this->modx->seopackage->config['seo_fields'])) {
            foreach ((array) $this->modx->seopackage->config['seo_fields'] as $field => $property) {
                if (isset($output[$field])) {
                    if (strlen($output[$field]) > (int) $property['max']) {
                        $output[$field] = substr($output[$field], 0, (int) $property['max']) . '...';
                    }
                }
            }
        }

        return $this->success('', $output);
    }
}

return 'SeoPackageResourcesMetaProcessor';
