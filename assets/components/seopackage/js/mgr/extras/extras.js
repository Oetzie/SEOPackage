SeoPackage.combo.Context = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        url         : SeoPackage.config.connector_url,
        baseParams  : {
            action      : 'mgr/contexts/getlist',
            exclude     : SeoPackage.config.exclude_contexts.join(',')
        },
        displayField : 'name',
        tpl         : new Ext.XTemplate('<tpl for=".">' +
            '<div class="x-combo-list-item">' +
                '<span style="font-weight: bold">{name:htmlEncode}</span>' +
                '<tpl if="key !== \'\'">' +
                    '<span style="font-style: italic; font-size: small;"> ({key:htmlEncode})</span>' +
                '</tpl>' +
            '</div>' +
        '</tpl>')
    });

    SeoPackage.combo.Context.superclass.constructor.call(this, config);
};

Ext.extend(SeoPackage.combo.Context, MODx.combo.Context);

Ext.reg('seopackage-combo-context', SeoPackage.combo.Context);

SeoPackage.combo.RedirectType = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        store       : new Ext.data.ArrayStore({
            mode        : 'local',
            fields      : ['type', 'label'],
            data        : [
                ['301', 'HTTP/1.1 301 Moved Permanently'],
                ['302', 'HTTP/1.1 302 Found'],
                ['303', 'HTTP/1.1 303 See Other']
            ]
        }),
        remoteSort  : ['label', 'asc'],
        hiddenName  : 'redirect_type',
        valueField  : 'label',
        displayField : 'label',
        mode        : 'local',
        value       : 'HTTP/1.1 301 Moved Permanently'
    });

    SeoPackage.combo.RedirectType.superclass.constructor.call(this, config);
};

Ext.extend(SeoPackage.combo.RedirectType, MODx.combo.ComboBox);

Ext.reg('seopackage-combo-redirect-type', SeoPackage.combo.RedirectType);

SeoPackage.combo.IPType = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        store       : new Ext.data.ArrayStore({
            mode        : 'local',
            fields      : ['type', 'label'],
            data        : [
                ['allow', _('seopackage.ip_allow')],
                ['deny', _('seopackage.ip_deny')]
            ]
        }),
        remoteSort  : ['label', 'asc'],
        hiddenName  : 'type',
        valueField  : 'type',
        displayField : 'label',
        mode        : 'local',
        value       : 'allow'
    });

    SeoPackage.combo.IPType.superclass.constructor.call(this, config);
};

Ext.extend(SeoPackage.combo.IPType, MODx.combo.ComboBox);

Ext.reg('seopackage-combo-ip-type', SeoPackage.combo.IPType);