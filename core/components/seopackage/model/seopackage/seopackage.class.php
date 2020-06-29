<?php

/**
 * SEO Package
 *
 * Copyright 2020 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

class SeoPackage
{
    /**
     * @access public.
     * @var modX.
     */
    public $modx;

    /**
     * @access public.
     * @var Array.
     */
    public $config = [];

    /**
     * @access public.
     * @param modX $modx.
     * @param Array $config.
     */
    public function __construct(modX &$modx, array $config = [])
    {
        $this->modx =& $modx;

        $corePath   = $this->modx->getOption('seopackage.core_path', $config, $this->modx->getOption('core_path') . 'components/seopackage/');
        $assetsUrl  = $this->modx->getOption('seopackage.assets_url', $config, $this->modx->getOption('assets_url') . 'components/seopackage/');
        $assetsPath = $this->modx->getOption('seopackage.assets_path', $config, $this->modx->getOption('assets_path') . 'components/seopackage/');

        $this->config = array_merge([
            'namespace'             => 'seopackage',
            'lexicons'              => ['seopackage:default'],
            'base_path'             => $corePath,
            'core_path'             => $corePath,
            'model_path'            => $corePath . 'model/',
            'processors_path'       => $corePath . 'processors/',
            'elements_path'         => $corePath . 'elements/',
            'chunks_path'           => $corePath . 'elements/chunks/',
            'plugins_path'          => $corePath . 'elements/plugins/',
            'snippets_path'         => $corePath . 'elements/snippets/',
            'templates_path'        => $corePath . 'templates/',
            'assets_path'           => $assetsPath,
            'js_url'                => $assetsUrl . 'js/',
            'css_url'               => $assetsUrl . 'css/',
            'assets_url'            => $assetsUrl,
            'connector_url'         => $assetsUrl . 'connector.php',
            'version'               => '1.0.0',
            'branding_url'          => $this->modx->getOption('seopackage.branding_url', null, ''),
            'branding_help_url'     => $this->modx->getOption('seopackage.branding_url_help', null, ''),
            'context'               => $this->getContexts(),
            'exclude_contexts'      => array_merge(['mgr'], explode(',', $this->modx->getOption('seopackage.exclude_contexts', null, ''))),
            'migrate'               => (bool) $this->modx->getOption('seopackage.migrate', null, false),
            'clean_days'            => (int) $this->modx->getOption('seopackage.clean_days', null, 30),
            'seo_fields'            => $this->getSeoFields(),
            'seo_fields_style'      => $this->modx->getOption('seopackage.seo_fields_style', null, 'bar'),
            'seo_title_format'      => $this->modx->getOption('seopackage.seo_title_format', null, '[[+title]] - [[+site_name]]'),
            'preview_search_engine' => $this->modx->getOption('seopackage.preview_search_engine', null, 'google'),
            'seo_index'             => (bool) $this->modx->getOption('seopackage.seo_index', null, true),
            'seo_follow'            => (bool) $this->modx->getOption('seopackage.seo_follow', null, true),
            'seo_searchable'        => (bool) $this->modx->getOption('seopackage.seo_searchable', null, true),
            'seo_sitemap'           => (bool) $this->modx->getOption('seopackage.seo_sitemap', null, true),
            'seo_sitemap_prio'      => $this->modx->getOption('seopackage.seo_sitemap_prio', null, '0.5'),
            'seo_sitemap_freq'      => $this->modx->getOption('seopackage.seo_sitemap_freq', null, 'weekly'),
        ], $config);

        $this->modx->addPackage('seopackage', $this->config['model_path']);

        if (is_array($this->config['lexicons'])) {
            foreach ($this->config['lexicons'] as $lexicon) {
                $this->modx->lexicon->load($lexicon);
            }
        } else {
            $this->modx->lexicon->load($this->config['lexicons']);
        }
    }

    /**
     * @access public.
     * @return String|Boolean.
     */
    public function getHelpUrl()
    {
        if (!empty($this->config['branding_help_url'])) {
            return $this->config['branding_help_url'] . '?v=' . $this->config['version'];
        }

        return false;
    }

    /**
     * @access public.
     * @return String|Boolean.
     */
    public function getBrandingUrl()
    {
        if (!empty($this->config['branding_url'])) {
            return $this->config['branding_url'];
        }

        return false;
    }

    /**
     * @access public.
     * @param String $key.
     * @param Array $options.
     * @param Mixed $default.
     * @return Mixed.
     */
    public function getOption($key, array $options = [], $default = null)
    {
        if (isset($options[$key])) {
            return $options[$key];
        }

        if (isset($this->config[$key])) {
            return $this->config[$key];
        }

        return $this->modx->getOption($this->config['namespace'] . '.' . $key, $options, $default);
    }

    /**
     * @access private.
     * @return Boolean.
     */
    private function getContexts()
    {
        return $this->modx->getCount('modContext', [
            'key:NOT IN' => array_merge(['mgr'], explode(',', $this->modx->getOption('seopackage.exclude_contexts', null, '')))
        ]) === 1;
    }

    /**
     * @access public.
     * @param String|Array $context.
     * @return Array.
     */
    public function getRedirects($context = [])
    {
        if (is_string($context)) {
            $context = explode(',', $context);
        }

        return $this->modx->getCollection('SeoPackageRedirect', [
            'context:IN'    => $context + [$this->modx->context->get('key'), ''],
            'active'        => 1
        ]);
    }

    /**
     * @access public.
     * @return Array.
     */
    public function getSeoFields()
    {
        $output = [];
        $data   = json_decode($this->modx->getOption('seopackage.seo_fields'), true);

        if ($data) {
            foreach ((array) $data as $type => $fields) {
                if ($type === $this->modx->getOption('seopackage.seo_search_engine', null, 'google')) {
                    foreach ((array) $fields as $field => $properties) {
                        if (strpos($properties, '|')) {
                            $output[$field] = [
                                'min' => substr($properties, 0, strrpos($properties, '|')),
                                'max' => substr($properties, strrpos($properties, '|') + 1, strlen($properties))
                            ];
                        } else {
                            $output[$field] = [
                                'min' => 0,
                                'max' => $properties
                            ];
                        }
                    }
                }
            }
        }

        if (!isset($output['title'])) {
            if (isset($output['longtitle'])) {
                $output['title'] = $output['longtitle'];
            } else if (isset($output['pagetitle'])) {
                $output['title'] = $output['pagetitle'];
            }
        }

        return $output;
    }

    /**
     * @access public.
     * @param Array $properties.
     * @return String.
     */
    public function getSeoTitle(array $properties = [])
    {
        $title = $this->config['seo_title_format'];

        if (!$this->modx->resource) {
            $this->modx->resource = $this->modx->newObject('modResource', $properties);
        }

        $maxIterations = (int) $this->modx->getOption('parser_max_iterations', null, 10);

        $this->modx->parser->processElementTags('', $title, true, false, '[[', ']]', array(), $maxIterations);
        $this->modx->parser->processElementTags('', $title, true, true, '[[', ']]', array(), $maxIterations);

        return $title;
    }

    /**
     * @access public.
     * @param Array $data.
     * @return Array.
     */
    public function getSeoDefaults(array $data = [])
    {
        foreach (['index', 'follow', 'searchable', 'sitemap', 'sitemap_prio', 'sitemap_freq'] as $key) {
            if (isset($this->config['seo_' . $key]) && (!isset($data[$key]) || $data[$key] === '')) {
                $data[$key] = $this->config['seo_' . $key];
            }
        }

        return $data;
    }
}
