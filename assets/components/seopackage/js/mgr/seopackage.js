var SeoPackage = function(config) {
    config = config || {};

    SeoPackage.superclass.constructor.call(this, config);
};

Ext.extend(SeoPackage, Ext.Component, {
    page    : {},
    window  : {},
    grid    : {},
    tree    : {},
    panel   : {},
    combo   : {},
    config  : {}
});

Ext.reg('seopackage', SeoPackage);

SeoPackage = new SeoPackage();