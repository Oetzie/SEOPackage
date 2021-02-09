SeoPackage.grid.IPs = function(config) {
    config = config || {};

    config.tbar = [{
        text        : _('seopackage.ip_create'),
        cls         : 'primary-button',
        handler     : this.createIP,
        scope       : this
    }, '->', {
        xtype       : 'textfield',
        name        : 'seopackage-filter-ips-search',
        id          : 'seopackage-filter-ips-search',
        emptyText   : _('search') + '...',
        listeners   : {
            'change'    : {
                fn          : this.filterSearch,
                scope       : this
            },
            'render'    : {
                fn          : function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key     : Ext.EventObject.ENTER,
                        fn      : this.blur,
                        scope   : cmp
                    });
                },
                scope       : this
            }
        }
    }, {
        xtype       : 'button',
        cls         : 'x-form-filter-clear',
        id          : 'seopackage-filter-ips-clear',
        text        : _('filter_clear'),
        listeners   : {
            'click'     : {
                fn          : this.clearFilter,
                scope       : this
            }
        }
    }];
    
    var columns = new Ext.grid.ColumnModel({
        columns     : [{
            header      : _('seopackage.label_ip_description'),
            dataIndex   : 'description',
            sortable    : true,
            editable    : false,
            width       : 150
        }, {
            header      : _('seopackage.label_ip_ip'),
            dataIndex   : 'ip',
            sortable    : true,
            editable    : false,
            width       : 150,
            fixed       : true
        }, {
            header      : _('seopackage.label_ip_type'),
            dataIndex   : 'type',
            sortable    : true,
            editable    : true,
            width       : 150,
            fixed       : true,
            renderer    : this.renderType,
            editor      : {
                xtype       : 'seopackage-combo-ip-type'
            }
        }, {
            header      : _('seopackage.label_ip_active'),
            dataIndex   : 'active',
            sortable    : true,
            editable    : true,
            width       : 100,
            fixed       : true,
            renderer    : this.renderBoolean,
            editor      : {
                xtype       : 'modx-combo-boolean'
            }
        }, {
            header      : _('last_modified'),
            dataIndex   : 'editedon',
            sortable    : true,
            editable    : false,
            fixed       : true,
            width       : 200,
            renderer    : this.renderDate
        }]
    });
    
    Ext.applyIf(config, {
        cm          : columns,
        id          : 'seopackage-grid-ips',
        url         : SeoPackage.config.connector_url,
        baseParams  : {
            action      : 'mgr/ips/getlist',
            context     : MODx.request.context || ''
        },
        autosave    : true,
        save_action : 'mgr/ips/updatefromgrid',
        fields      : ['id', 'context', 'type', 'ip', 'useragent', 'description', 'active', 'editedon'],
        paging      : true,
        pageSize    : MODx.config.default_per_page > 30 ? MODx.config.default_per_page : 30,
        sortBy      : 'description'
    });

    SeoPackage.grid.IPs.superclass.constructor.call(this, config);
};

Ext.extend(SeoPackage.grid.IPs, MODx.grid.Grid, {
    filterSearch: function(tf, nv, ov) {
        this.getStore().baseParams.query = tf.getValue();
        
        this.getBottomToolbar().changePage(1);
    },
    clearFilter: function() {
        this.getStore().baseParams.query = '';

        Ext.getCmp('seopackage-filter-ips-search').reset();

        this.getBottomToolbar().changePage(1);
    },
    getMenu: function() {
        return [{
            text    : '<i class="x-menu-item-icon icon icon-pencil"></i>' + _('seopackage.ip_update'),
            handler : this.updateIP,
            scope   : this
        }, '-', {
            text    : '<i class="x-menu-item-icon icon icon-times"></i>' + _('seopackage.ip_remove'),
            handler : this.removeIP,
            scope   : this
        }];
    },
    createIP: function(btn, e) {
        if (this.createIPWindow) {
            this.createIPWindow.destroy();
        }
        
        this.createIPWindow = MODx.load({
            xtype       : 'seopackage-window-ip-create',
            closeAction : 'close',
            listeners   : {
                'success'   : {
                    fn          : this.refresh,
                    scope       : this
                }
            }
        });

        this.createIPWindow.show(e.target);
    },
    updateIP: function(btn, e) {
        if (this.updateIPWindow) {
            this.updateIPWindow.destroy();
        }

        this.updateIPWindow = MODx.load({
            xtype       : 'seopackage-window-ip-update',
            record      : this.menu.record,
            closeAction : 'close',
            listeners   : {
                'success'   : {
                    fn          : this.refresh,
                    scope       : this
                }
            }
        });

        this.updateIPWindow.setValues(this.menu.record);
        this.updateIPWindow.show(e.target);
    },
    removeIP: function(btn, e) {
        MODx.msg.confirm({
            title       : _('seopackage.ip_remove'),
            text        : _('seopackage.ip_remove_confirm'),
            url         : SeoPackage.config.connector_url,
            params      : {
                action      : 'mgr/ips/remove',
                id          : this.menu.record.id
            },
            listeners   : {
                'success'   : {
                    fn          : this.refresh,
                    scope       : this
                }
            }
        });
    },
    renderType: function(d, c) {
        c.css = d === 'allow' ? 'green' : 'red';

        return d === 'allow' ? _('seopackage.ip_allow') : _('seopackage.ip_deny');
    },
    renderBoolean: function(d, c) {
        c.css = parseInt(d) === 1 || d ? 'green' : 'red';

        return parseInt(d) === 1 || d ? _('yes') : _('no');
    },
    renderDate: function(a) {
        if (Ext.isEmpty(a)) {
            return '—';
        }

        return a;
    }
});

Ext.reg('seopackage-grid-ips', SeoPackage.grid.IPs);

SeoPackage.window.CreateIP = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        width       : 400,
        autoHeight  : true,
        title       : _('seopackage.ip_create'),
        url         : SeoPackage.config.connector_url,
        baseParams  : {
            action      : 'mgr/ips/create'
        },
        fields      : [{
            layout      : 'column',
            defaults    : {
                layout      : 'form',
                labelSeparator : ''
            },
            items       : [{
                columnWidth : .85,
                items       : [{
                    xtype       : 'textfield',
                    fieldLabel  : _('seopackage.label_ip_description'),
                    description : MODx.expandHelp ? '' : _('seopackage.label_ip_description_desc'),
                    name        : 'description',
                    anchor      : '100%',
                    allowBlank  : false
                }, {
                    xtype       : MODx.expandHelp ? 'label' : 'hidden',
                    html        : _('seopackage.label_ip_description_desc'),
                    cls         : 'desc-under'
                }]
            }, {
                columnWidth : .15,
                items       : [{
                    xtype       : 'checkbox',
                    fieldLabel  : _('seopackage.label_ip_active'),
                    description : MODx.expandHelp ? '' : _('seopackage.label_ip_active_desc'),
                    name        : 'active',
                    inputValue  : 1,
                    checked     : true
                }, {
                    xtype       : MODx.expandHelp ? 'label' : 'hidden',
                    html        : _('seopackage.label_ip_active_desc'),
                    cls         : 'desc-under'
                }]
            }]
        }, {
            xtype       : 'textfield',
            fieldLabel  : _('seopackage.label_ip_ip'),
            description : MODx.expandHelp ? '' : _('seopackage.label_ip_ip_desc'),
            name        : 'ip',
            anchor      : '100%',
            allowBlank  : false
        }, {
            xtype       : MODx.expandHelp ? 'label' : 'hidden',
            html        : _('seopackage.label_ip_ip_desc'),
            cls         : 'desc-under'
        }, {
            xtype       : 'seopackage-combo-ip-type',
            fieldLabel  : _('seopackage.label_ip_type'),
            description : MODx.expandHelp ? '' : _('seopackage.label_ip_type_desc'),
            name        : 'type',
            anchor      : '100%',
            allowBlank  : false
        }, {
            xtype       : MODx.expandHelp ? 'label' : 'hidden',
            html        : _('seopackage.label_ip_type_desc'),
            cls         : 'desc-under'
        }, {
            layout      : 'form',
            labelSeparator : '',
            hidden      : SeoPackage.config.context,
            items       : [{
                xtype       : 'seopackage-combo-context',
                fieldLabel  : _('seopackage.label_ip_context'),
                description : MODx.expandHelp ? '' : _('seopackage.label_ip_context_desc'),
                name        : 'context',
                anchor      : '100%',
                value       : MODx.request.context || ''
            }, {
                xtype       : MODx.expandHelp ? 'label' : 'hidden',
                html        : _('seopackage.label_ip_context_desc'),
                cls         : 'desc-under'
            }]
        }]
    });

    SeoPackage.window.CreateIP.superclass.constructor.call(this, config);
};

Ext.extend(SeoPackage.window.CreateIP, MODx.Window);

Ext.reg('seopackage-window-ip-create', SeoPackage.window.CreateIP);

SeoPackage.window.UpdateIP = function(config) {
    config = config || {};
    
    Ext.applyIf(config, {
        width       : 400,
        autoHeight  : true,
        title       : _('seopackage.ip_update'),
        url         : SeoPackage.config.connector_url,
        baseParams  : {
            action      : 'mgr/ips/update'
        },
        fields      : [{
            xtype       : 'hidden',
            name        : 'id'
        }, {
            layout      : 'column',
            defaults    : {
                layout      : 'form',
                labelSeparator : ''
            },
            items       : [{
                columnWidth : .85,
                items       : [{
                    xtype       : 'textfield',
                    fieldLabel  : _('seopackage.label_ip_description'),
                    description : MODx.expandHelp ? '' : _('seopackage.label_ip_description_desc'),
                    name        : 'description',
                    anchor      : '100%',
                    allowBlank  : false
                }, {
                    xtype       : MODx.expandHelp ? 'label' : 'hidden',
                    html        : _('seopackage.label_ip_description_desc'),
                    cls         : 'desc-under'
                }]
            }, {
                columnWidth : .15,
                items       : [{
                    xtype       : 'checkbox',
                    fieldLabel  : _('seopackage.label_ip_active'),
                    description : MODx.expandHelp ? '' : _('seopackage.label_ip_active_desc'),
                    name        : 'active',
                    inputValue  : 1,
                    checked     : true
                }, {
                    xtype       : MODx.expandHelp ? 'label' : 'hidden',
                    html        : _('seopackage.label_ip_active_desc'),
                    cls         : 'desc-under'
                }]
            }]
        }, {
            xtype       : 'textfield',
            fieldLabel  : _('seopackage.label_ip_ip'),
            description : MODx.expandHelp ? '' : _('seopackage.label_ip_ip_desc'),
            name        : 'ip',
            anchor      : '100%',
            allowBlank  : false
        }, {
            xtype       : MODx.expandHelp ? 'label' : 'hidden',
            html        : _('seopackage.label_ip_ip_desc'),
            cls         : 'desc-under'
        }, {
            xtype       : 'seopackage-combo-ip-type',
            fieldLabel  : _('seopackage.label_ip_type'),
            description : MODx.expandHelp ? '' : _('seopackage.label_ip_type_desc'),
            name        : 'type',
            anchor      : '100%',
            allowBlank  : false
        }, {
            xtype       : MODx.expandHelp ? 'label' : 'hidden',
            html        : _('seopackage.label_ip_type_desc'),
            cls         : 'desc-under'
        }, {
            layout      : 'form',
            labelSeparator : '',
            hidden      : SeoPackage.config.context,
            items       : [{
                xtype       : 'seopackage-combo-context',
                fieldLabel  : _('seopackage.label_ip_context'),
                description : MODx.expandHelp ? '' : _('seopackage.label_ip_context_desc'),
                name        : 'context',
                anchor      : '100%',
                value       : MODx.request.context || ''
            }, {
                xtype       : MODx.expandHelp ? 'label' : 'hidden',
                html        : _('seopackage.label_ip_context_desc'),
                cls         : 'desc-under'
            }]
        }]
    });
    
    SeoPackage.window.UpdateIP.superclass.constructor.call(this, config);
};

Ext.extend(SeoPackage.window.UpdateIP, MODx.Window);

Ext.reg('seopackage-window-ip-update', SeoPackage.window.UpdateIP);