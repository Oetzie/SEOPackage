Ext.onReady(function() {
    MODx.load({
        xtype : 'seopackage-page-home'
    });
});

SeoPackage.page.Home = function(config) {
    config = config || {};

    config.buttons = [];

    if (SeoPackage.config.branding_url) {
        config.buttons.push({
            text        : 'SEO Package ' + SeoPackage.config.version,
            cls         : 'x-btn-branding',
            handler     : this.loadBranding
        });
    }

    config.buttons.push({
        xtype       : 'seopackage-combo-context',
        hidden      : SeoPackage.config.context,
        value       : MODx.request.context || '',
        name        : 'seopackage-filter-context',
        emptyText   : _('seopackage.filter_context'),
        listeners   : {
            'select'    : {
                fn          : this.filterContext,
                scope       : this
            }
        }
    });

    if (!SeoPackage.config.migrate) {
        config.buttons.push({
            text        : _('seopackage.migrate_redirections'),
            cls         : 'x-btn-migrate',
            handler     : this.migrateRedirections
        });
    }

    if (SeoPackage.config.branding_url_help) {
        config.buttons.push({
            text        : _('help_ex'),
            handler     : MODx.loadHelpPane,
            scope       : this
        });
    }

    Ext.applyIf(config, {
        components  : [{
            xtype       : 'seopackage-panel-home',
            renderTo    : 'seopackage-panel-home-div'
        }]
    });

    SeoPackage.page.Home.superclass.constructor.call(this, config);
};

Ext.extend(SeoPackage.page.Home, MODx.Component, {
    loadBranding: function(btn) {
        window.open(SeoPackage.config.branding_url);
    },
    filterContext : function(tf) {
        MODx.loadPage('home', 'namespace=' + MODx.request.namespace + '&context=' + tf.getValue());
    },
    migrateRedirections: function(btn) {
        MODx.msg.confirm({
            title       : _('seopackage.migrate_redirections'),
            text        : _('seopackage.migrate_redirections_confirm'),
            url         : SeoPackage.config.connector_url,
            params      : {
                action      : 'mgr/migrate'
            },
            listeners   : {
                'success'   : {
                    fn          : function(record) {
                        MODx.msg.status({
                            title   : _('success'),
                            message : record.message,
                            delay   : 4
                        });

                        window.location.reload();
                    },
                    scope       : this
                },
            }
        });
    }
});

Ext.reg('seopackage-page-home', SeoPackage.page.Home);