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
        $output = array_merge($this->getProperties(), [
            'domain'    => '',
            'secure'    => false,
            'favicon'   => '',
            'title'     => $this->modx->seopackage->getSeoTitle($this->getProperties()),
            'url'       => ''
        ]);

        $resource = $this->modx->newObject('modResource', $this->getProperties());

        if ($resource) {
            $context = $this->modx->getObject('modContext', [
                'key' => $this->getProperty('context_key')
            ]);

            if ($context && $context->prepare()) {
                $scheme     = $context->getOption('link_tag_scheme');
                $baseUrl    = trim($context->getOption('base_url'), '/');
                $basePath   = '';

                $output['domain'] = trim(str_replace(['http://', 'https://'], '', $context->getOption('site_url')), '/');

                if ($scheme === 'http' || (int) $scheme === 0) {
                    $output['secure'] = false;
                } else if ($scheme === 'https' || (int) $scheme === 1) {
                    $output['secure'] = true;
                } else {
                    $output['secure'] = strpos($context->getOption('site_url'), 'https') === 0;
                }

                if ((int) $context->getOption('friendly_urls') === 1) {
                    if ((int) $context->getOption('site_start') !== (int) $this->getProperty('id')) {
                        $basePath = $resource->getAliasPath($resource->get('alias'), $this->getProperties());
                    }
                } else {
                    $basePath = $context->getOption('request_controller') . '?' . $context->getOption('request_param_id') . '=' . $this->getProperty('id');
                }

                $output['url'] = trim($baseUrl . '/' . $basePath, '/');
            }
        }

        $output['favicon'] = '//www.google.com/s2/favicons?domain=' . $output['domain'];

        if (empty($output['description'])) {
            $output['description'] = $this->modx->lexicon('seopackage.seo_preview_desc');
        }

        if (isset($this->modx->seopackage->config['seo_fields'])) {
            foreach ((array) $this->modx->seopackage->config['seo_fields'] as $field => $property) {
                if (isset($output[$field])) {
                    if (strlen($output[$field]) >= (int) $property['max']) {
                        $output[$field] = substr($output[$field], 0, (int) $property['max']) . '...';
                    }
                }
            }
        }

        return $this->success('', $output);
    }
}

return 'SeoPackageResourcesMetaProcessor';
