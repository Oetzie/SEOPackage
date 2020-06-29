SeoPackage.panel.Home = function(config) {
    config = config || {};

    Ext.apply(config, {
        id          : 'seopackage-panel-home',
        cls         : 'container',
        items       : [{
            html        : '<h2>' + _('seopackage') + '</h2>',
            cls         : 'modx-page-header'
        }, {
            xtype       : 'modx-tabs',
            items       : [{
                layout      : 'form',
                title       : _('seopackage.errors'),
                items       : [{
                    html            : '<p>' + _('seopackage.errors_desc') + '</p>',
                    bodyCssClass    : 'panel-desc'
                }, {
                    xtype           : 'seopackage-grid-errors',
                    cls             : 'main-wrapper',
                    preventRender   : true,
                    refreshGrid     : 'seopackage-grid-redirects'
                }]
            }, {
                layout      : 'form',
                title       : _('seopackage.redirects'),
                items       : [{
                    html            : '<p>' + _('seopackage.redirects_desc') + '</p>',
                    bodyCssClass    : 'panel-desc'
                }, {
                    xtype           : 'seopackage-grid-redirects',
                    cls             : 'main-wrapper',
                    preventRender   : true,
                    refreshGrid     : 'seopackage-grid-errors'
                }]
            }]
        }]
    });

    SeoPackage.panel.Home.superclass.constructor.call(this, config);
};

Ext.extend(SeoPackage.panel.Home, MODx.FormPanel);

Ext.reg('seopackage-panel-home', SeoPackage.panel.Home);