Ext.onReady(function() {
    MODx.load({
        xtype : 'seopackage-panel-meta'
    });

    MODx.load({
        xtype : 'seopackage-panel-settings'
    });
});

SeoPackage.panel.Meta = function(config) {
    config = config || {};

    Ext.apply(config, {
        renderTo    : 'modx-resource-main-left',
        listeners   : {
            'afterrender' : {
                fn          : this.onAfterRender,
                scope       : this
            }
        }
    });

    SeoPackage.panel.Meta.superclass.constructor.call(this, config);
};

Ext.extend(SeoPackage.panel.Meta, MODx.Panel, {
    onAfterRender: function() {
        var panel = Ext.getCmp(this.renderTo);

        if (panel) {
            panel.add({
                xtype       : 'textfield',
                fieldLabel  : _('seopackage.resource_keywords'),
                description : '<b>[[*keywords]]</b><br />' + _('seopackage.resource_keywords_desc'),
                name        : 'keywords',
                anchor      : '100%',
                value       : SeoPackage.record.keywords,
                id          : 'seopackage-panel-keywords',
                enableKeyEvents : true
            }, {
                id          : 'seopackage-panel-meta',
                fieldLabel  : _('seopackage.seo_preview', { type : SeoPackage.config.preview_search_engine.charAt(0).toUpperCase() + SeoPackage.config.preview_search_engine.slice(1) }),
                type        : SeoPackage.config.preview_search_engine,
                html        : '<div class="x-field-seo-meta x-field-seo-meta-' + SeoPackage.config.preview_search_engine + '">' +
                    '<div class="x-field-seo-meta-data">' +
                        '<div class="x-field-seo-meta-title"></div>' +
                        '<div class="x-field-seo-meta-url">' +
                            '<img src="//www.google.com/s2/favicons?domain=localhost" class="x-field-seo-meta-favicon" />' +
                            '<span class="x-field-seo-meta-secure"><i class="icon icon-lock"></i></span>' +
                            '<span class="x-field-seo-meta-domain"></span>' +
                        '</div>' +
                        '<div class="x-field-seo-meta-description"></div>' +
                    '</div>' +
                    '<div class="x-field-seo-meta-message">' + _('seopackage.seo_preview_not_allowed') + '</div>' +
                '</div>',
                listeners   : {
                    'afterrender' : {
                        fn          : this.onHandleMeta,
                        scope       : this
                    }
                }
            });

            Ext.iterate(SeoPackage.config.seo_fields, (function(key, value) {
                var field = Ext.getCmp('modx-resource-' + key);

                if (field) {
                    field.counter = value;

                    if (SeoPackage.config.seo_fields_style === 'bar') {
                        field.container.addClass('x-field-seo-bar-field');

                        field.container.createChild({
                            tag     : 'div',
                            class   : 'x-field-seo-bar',
                            html    : '<span class="x-field-seo-bar-current">0</span>'
                        });
                    } else {
                        field.container.addClass('x-field-seo-counter-field');

                        field.container.createChild({
                            tag     : 'div',
                            class   : 'x-field-seo-counter',
                            html    : '<strong>' + _('seopackage.resource_allowed_chars') + ': </strong><span class="x-field-seo-counter-current">0</span>/<span class="x-field-seo-counter-total">' + value.max + '</span>'
                        });
                    }

                    field.on('keyup', (function(field) {
                        this.onHandleCounter(field);
                    }).bind(this));

                    this.onHandleCounter(field);
                }
            }).bind(this));

            var keywordsField = Ext.getCmp('seopackage-panel-keywords');

            if (keywordsField) {
                keywordsField.on('keyup', (function() {
                    Ext.iterate(['pagetitle', 'longtitle', 'description', 'alias'], (function(key) {
                        var field = Ext.getCmp('modx-resource-' + key);

                        if (field) {
                            this.onHandleKeywords(field, keywordsField);
                        }
                    }).bind(this));
                }).bind(this));

                Ext.iterate(['pagetitle', 'longtitle', 'description', 'alias'], (function(key) {
                    var field = Ext.getCmp('modx-resource-' + key);

                    if (field) {
                        field.container.addClass('x-field-seo-keyword-field');

                        field.container.createChild({
                            tag     : 'div',
                            class   : 'x-field-seo-keyword',
                            html    : '<strong>' + _('seopackage.resource_allowed_keywords') + ': </strong><span class="x-field-seo-keyword-current">0</span>'
                        });

                        field.on('keyup', (function(field) {
                            this.onHandleKeywords(field, keywordsField);
                        }).bind(this));

                        this.onHandleKeywords(field, keywordsField);
                    }
                }).bind(this));
            }

            Ext.iterate(['pagetitle', 'longtitle', 'description', 'alias', 'uri', 'parent'], (function(key) {
                var field = Ext.getCmp('modx-resource-' + key);

                if (field) {
                    var panel = Ext.getCmp('seopackage-panel-meta');

                    if (key === 'parent') {
                        field.on('change', (function() {
                            this.onHandleMeta(panel);
                        }).bind(this));
                    } else {
                        field.on('keyup', (function() {
                            this.onHandleMeta(panel);
                        }).bind(this));
                    }
                }
            }).bind(this));

            panel.doLayout();
        }
    },
    onHandleCounter: function(field) {
        var chars   = field.getValue().length;
        var state   = 'green';
        var counter = Ext.get(field.container.query('.x-field-seo-counter')[0]);
        var bar     = Ext.get(field.container.query('.x-field-seo-bar')[0]);

        if (chars < parseInt(field.counter.min)) {
            state = 'orange';
        } else if (chars > parseInt(field.counter.max)) {
            state = 'red';
        }

        if (counter) {
            var current = Ext.get(counter.query('.x-field-seo-counter-current')[0]);

            counter.removeClass('orange').removeClass('green').removeClass('red').addClass(state);

            if (current) {
                current.dom.innerHTML = chars;
            }
        }

        if (bar) {
            var current = Ext.get(bar.query('.x-field-seo-bar-current')[0]);

            bar.removeClass('orange').removeClass('green').removeClass('red').addClass(state);

            if (current) {
                current.dom.innerHTML = chars;

                current.setWidth(Math.ceil(chars / (parseInt(field.counter.max) / 100)) + '%');
            }
        }
    },
    onHandleKeywords: function(field, keywordsField) {
        var counter     = Ext.get(field.container.query('.x-field-seo-keyword')[0]);
        var totalCount  = 0;

        if (keywordsField.getValue()) {
            Ext.iterate(keywordsField.getValue().split(','), function(keyword) {
                keyword = keyword.replace(/^\s+/, '').toLowerCase();

                if (!Ext.isEmpty(keyword)) {
                    var count = field.getValue().toLowerCase().match(new RegExp("(^|[ \s\n\r\t\.,'\(\"\+;!?:\-])" + keyword + "($|[ \s\n\r\t.,'\)\"\+!?:;\-])", 'gim'));

                    if (count) {
                        totalCount += count.length;
                    }
                }
            });
        }

        if (counter) {
            counter.removeClass('green');

            if (totalCount >= 1) {
                counter.addClass('green');
            }

            var current = Ext.get(counter.query('.x-field-seo-keyword-current')[0]);

            if (current) {
                current.dom.innerHTML = totalCount;
            }
        }
    },
    onHandleMeta: function(field) {
        var panel = Ext.getCmp('modx-panel-resource');

        if (panel) {
            setTimeout(function() {
                var record = panel.getForm().getValues();

                MODx.Ajax.request({
                    url             : SeoPackage.config.connector_url,
                    params          : {
                        action          : 'mgr/resources/meta',
                        id              : record.id,
                        parent          : record.parent,
                        pagetitle       : record.pagetitle,
                        longtitle       : record.longtitle,
                        description     : record.description,
                        alias           : record.alias,
                        context_key     : record.context_key,
                        uri             : record.uri,
                        uri_override    : record.uri_override,
                        type            : field.type
                    },
                    listeners       : {
                        'success'       : {
                            fn              : function(data) {
                                var container = Ext.get(field.container.query('.x-field-seo-meta')[0]);

                                if (container) {
                                    if (parseInt(record.index) === 0) {
                                        container.addClass('disabled');
                                    } else {
                                        container.removeClass('disabled');
                                    }
                                }

                                Ext.iterate(['title', 'description', 'domain', 'favicon', 'secure', 'url'], function(key) {
                                    var placeholder = Ext.get(field.container.query('.x-field-seo-meta-' + key)[0]);

                                    if (placeholder) {
                                        if (key === 'favicon') {
                                            placeholder.dom.src = data.object[key];
                                        } else if (key === 'secure') {
                                            placeholder.enableDisplayMode('block');

                                            if (data.object[key]) {
                                                placeholder.show();
                                            } else {
                                                placeholder.hide();
                                            }
                                        } else if (key === 'url') {
                                            Ext.iterate(placeholder.query('.x-field-seo-meta-path'), function(segment) {
                                                segment.remove();
                                            });

                                            Ext.iterate(data.object[key].split('/'), function(segment) {
                                                if (!Ext.isEmpty(segment)) {
                                                    placeholder.createChild({
                                                        tag     : 'span',
                                                        class   : 'x-field-seo-meta-path',
                                                        html    : segment
                                                    });
                                                }
                                            });
                                        } else {
                                            placeholder.dom.innerHTML = data.object[key];
                                        }
                                    }
                                });
                            },
                            scope           : this
                        }
                    }
                });
            }, 500);
        }
    }
});

Ext.reg('seopackage-panel-meta', SeoPackage.panel.Meta);

SeoPackage.panel.Settings = function(config) {
    config = config || {};

    Ext.apply(config, {
        renderTo    : 'modx-page-settings-right',
        listeners   : {
            'afterrender' : {
                fn          : this.onAfterRender,
                scope       : this
            }
        }
    });

    SeoPackage.panel.Settings.superclass.constructor.call(this, config);
};

Ext.extend(SeoPackage.panel.Settings, MODx.Panel, {
    onAfterRender: function() {
        var panel = Ext.getCmp(this.renderTo);

        if (panel) {
            panel.add({
                xtype       : 'fieldset',
                items       : [{
                    xtype       : 'xcheckbox',
                    hideLabel   : true,
                    boxLabel    : _('seopackage.resource_index'),
                    description : '<b>[[*seopackage.index]]</b><br />' + _('seopackage.resource_index_desc'),
                    name        : 'index',
                    inputValue  : 1,
                    checked     : SeoPackage.record.index,
                    listeners   : {
                        'check'     : {
                            fn          : this.onHandleIndex,
                            scope       : this
                        }
                    }
                }, {
                    xtype       : 'xcheckbox',
                    hideLabel   : true,
                    boxLabel    : _('seopackage.resource_follow'),
                    description : '<b>[[*seopackage.follow]]</b><br />' + _('seopackage.resource_follow_desc'),
                    name        : 'follow',
                    inputValue  : 1,
                    checked     : SeoPackage.record.follow
                }, {
                    xtype       : 'xcheckbox',
                    hideLabel   : true,
                    boxLabel    : _('seopackage.resource_searchable'),
                    description : '<b>[[*seopackage.searchable]]</b><br />' + _('seopackage.resource_searchable_desc'),
                    name        : 'searchable',
                    inputValue  : 1,
                    checked     : SeoPackage.record.searchable,
                    listeners   : {
                        'check'     : {
                            fn          : this.onHandleSearchable,
                            scope       : this
                        },
                        'afterrender' : {
                            fn          : this.onHandleSearchable,
                            scope       : this
                        }
                    }
                }, {
                    xtype       : 'xcheckbox',
                    hideLabel   : true,
                    boxLabel    : _('seopackage.resource_sitemap'),
                    description : '<b>[[*seopackage.follow]]</b><br />' + _('seopackage.resource_sitemap_desc'),
                    name        : 'sitemap',
                    inputValue  : 1,
                    checked     : SeoPackage.record.sitemap,
                    listeners   : {
                        'check'     : {
                            fn          : this.onHandleSitemap,
                            scope       : this
                        },
                        'afterrender' : {
                            fn          : this.onHandleSitemap,
                            scope       : this
                        }
                    }
                }, {
                    layout      : 'form',
                    id          : 'seopackage-panel-sitemap',
                    labelAlign  : 'top',
                    labelSeparator  : '',
                    items       : [{
                        xtype       : 'seopackage-combo-sitemap-prio',
                        fieldLabel  : _('seopackage.resource_sitemap_prio'),
                        description : '<b>[[*seopackage.sitemap_prio]]</b><br />' + _('seopackage.resource_sitemap_prio_desc'),
                        name        : 'sitemap_prio',
                        anchor      : '100%',
                        value       : SeoPackage.record.sitemap_prio
                    }, {
                        xtype       : 'seopackage-combo-sitemap-freq',
                        fieldLabel  : _('seopackage.resource_sitemap_freq'),
                        description : '<b>[[*seopackage.sitemap_freq]]</b><br />' + _('seopackage.resource_sitemap_freq_desc'),
                        name        : 'sitemap_freq',
                        anchor      : '100%',
                        value       : SeoPackage.record.sitemap_freq
                    }]
                }]
            });

            panel.doLayout();

            var hiddenSearchableField = Ext.getCmp('modx-resource-searchable');

            if (hiddenSearchableField) {
                hiddenSearchableField.hide();
            }
        }
    },
    onHandleIndex: function(field) {
        var titleField = Ext.getCmp('modx-resource-pagetitle');

        if (titleField) {
            titleField.fireEvent('keyup', titleField);
        }
    },
    onHandleSearchable: function(field) {
        var hiddenSearchableField = Ext.getCmp('modx-resource-searchable');

        if (hiddenSearchableField) {
            hiddenSearchableField.setValue(field.getValue());
        }
    },
    onHandleSitemap: function(field) {
        var panel = Ext.getCmp('seopackage-panel-sitemap');

        if (panel) {
            if (field.getValue()) {
                panel.show();
            } else {
                panel.hide();
            }
        }
    }
});

Ext.reg('seopackage-panel-settings', SeoPackage.panel.Settings);

SeoPackage.combo.SitemapPrio = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        store       : new Ext.data.ArrayStore({
            mode        : 'local',
            fields      : ['value', 'label'],
            data        : [
                [1, _('seopackage.seo_sitemap_prio_high')],
                [0.5, _('seopackage.seo_sitemap_prio_normal')],
                [0.25, _('seopackage.seo_sitemap_prio_low')]
            ]
        }),
        hiddenName  : 'sitemap_prio',
        valueField  : 'value',
        displayField : 'label',
        mode        : 'local'
    });

    SeoPackage.combo.SitemapPrio.superclass.constructor.call(this, config);
};

Ext.extend(SeoPackage.combo.SitemapPrio, MODx.combo.ComboBox);

Ext.reg('seopackage-combo-sitemap-prio', SeoPackage.combo.SitemapPrio);

SeoPackage.combo.SitemapFreq = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        store       : new Ext.data.ArrayStore({
            mode        : 'local',
            fields      : ['value', 'label'],
            data        : [
                ['always', _('seopackage.seo_sitemap_freq_always')],
                ['hourly', _('seopackage.seo_sitemap_freq_hourly')],
                ['daily', _('seopackage.seo_sitemap_freq_daily')],
                ['weekly', _('seopackage.seo_sitemap_freq_weekly')],
                ['monthly', _('seopackage.seo_sitemap_freq_monthly')],
                ['yearly', _('seopackage.seo_sitemap_freq_yearly')],
                ['never', _('seopackage.seo_sitemap_freq_never')]
            ]
        }),
        hiddenName  : 'sitemap_freq',
        valueField  : 'value',
        displayField : 'label',
        mode        : 'local'
    });

    SeoPackage.combo.SitemapFreq.superclass.constructor.call(this, config);
};

Ext.extend(SeoPackage.combo.SitemapFreq, MODx.combo.ComboBox);

Ext.reg('seopackage-combo-sitemap-freq', SeoPackage.combo.SitemapFreq);