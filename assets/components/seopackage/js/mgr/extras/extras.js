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