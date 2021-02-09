SeoPackage.grid.Redirects = function(config) {
    config = config || {};

    config.tbar = [{
        text        : _('seopackage.redirect_create'),
        cls         : 'primary-button',
        handler     : this.createRedirect,
        scope       : this
    }, {
        text        : _('bulk_actions'),
        menu        : [{
            text        : '<i class="x-menu-item-icon icon icon-times"></i>' + _('seopackage.redirects_reset'),
            handler     : this.resetRedirects,
            scope       : this
        }]
    }, '->', {
        xtype       : 'textfield',
        name        : 'seopackage-filter-redirects-search',
        id          : 'seopackage-filter-redirects-search',
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
        id          : 'seopackage-filter-redirects-clear',
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
            header      : _('seopackage.label_old_url'),
            dataIndex   : 'old_url_formatted',
            sortable    : true,
            editable    : false,
            width       : 150,
            renderer    : this.renderUrl
        }, {
            header      : _('seopackage.label_new_url'),
            dataIndex   : 'new_url_formatted',
            sortable    : true,
            editable    : false,
            width       : 300,
            fixed       : true,
            renderer    : this.renderUrl
        }, {
            header      : _('seopackage.label_active'),
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
            header      : _('seopackage.label_visits'),
            dataIndex   : 'visits',
            sortable    : true,
            editable    : false,
            width       : 100,
            fixed       : true
        }, {
            header      : _('seopackage.label_last_visit'),
            dataIndex   : 'last_visit',
            sortable    : true,
            editable    : false,
            fixed       : true,
            width       : 200,
            renderer    : this.renderDate
        }]
    });
    
    Ext.applyIf(config, {
        cm          : columns,
        id          : 'seopackage-grid-redirects',
        url         : SeoPackage.config.connector_url,
        baseParams  : {
            action      : 'mgr/redirects/getlist',
            context     : MODx.request.context || '',
            type        : 'redirects'
        },
        autosave    : true,
        save_action : 'mgr/redirects/updatefromgrid',
        fields      : ['id', 'context', 'old_url', 'new_url', 'redirect_type', 'visits', 'last_visit', 'active', 'editedon', 'old_url_formatted', 'new_url_formatted'],
        paging      : true,
        pageSize    : MODx.config.default_per_page > 30 ? MODx.config.default_per_page : 30,
        sortBy      : 'visits',
        refreshGrid : []
    });

    SeoPackage.grid.Redirects.superclass.constructor.call(this, config);
};

Ext.extend(SeoPackage.grid.Redirects, MODx.grid.Grid, {
    filterSearch: function(tf, nv, ov) {
        this.getStore().baseParams.query = tf.getValue();
        
        this.getBottomToolbar().changePage(1);
    },
    clearFilter: function() {
        this.getStore().baseParams.query = '';

        Ext.getCmp('seopackage-filter-redirects-search').reset();

        this.getBottomToolbar().changePage(1);
    },
    getMenu: function() {
        return [{
            text    : '<i class="x-menu-item-icon icon icon-pencil"></i>' + _('seopackage.redirect_update'),
            handler : this.updateRedirect,
            scope   : this
        }, '-', {
            text    : '<i class="x-menu-item-icon icon icon-times"></i>' + _('seopackage.redirect_remove'),
            handler : this.removeRedirect,
            scope   : this
        }];
    },
    refreshGrids: function() {
        if (typeof this.config.refreshGrid === 'string') {
            Ext.getCmp(this.config.refreshGrid).refresh();
        } else {
            for (var i = 0; i < this.config.refreshGrid.length; i++) {
                Ext.getCmp(this.config.refreshGrid[i]).refresh();
            }
        }
    },
    createRedirect: function(btn, e) {
        if (this.createRedirectWindow) {
            this.createRedirectWindow.destroy();
        }
        
        this.createRedirectWindow = MODx.load({
            xtype       : 'seopackage-window-redirect-create',
            closeAction : 'close',
            listeners   : {
                'success'   : {
                    fn          : function() {
                        this.refreshGrids();
                        this.refresh();
                    },
                    scope       : this
                }
            }
        });

        this.createRedirectWindow.show(e.target);
    },
    updateRedirect: function(btn, e) {
        if (this.updateRedirectWindow) {
            this.updateRedirectWindow.destroy();
        }

        this.updateRedirectWindow = MODx.load({
            xtype       : 'seopackage-window-redirect-update',
            record      : this.menu.record,
            closeAction : 'close',
            listeners   : {
                'success'   : {
                    fn          : function() {
                        this.refreshGrids();
                        this.refresh();
                    },
                    scope       : this
                }
            }
        });

        this.updateRedirectWindow.setValues(this.menu.record);
        this.updateRedirectWindow.show(e.target);
    },
    removeRedirect: function(btn, e) {
        MODx.msg.confirm({
            title       : _('seopackage.redirect_remove'),
            text        : _('seopackage.redirect_remove_confirm'),
            url         : SeoPackage.config.connector_url,
            params      : {
                action      : 'mgr/redirects/remove',
                id          : this.menu.record.id
            },
            listeners   : {
                'success'   : {
                    fn          : function() {
                        this.refreshGrids();
                        this.refresh();
                    },
                    scope       : this
                }
            }
        });
    },
    resetRedirects: function(btn, e) {
        MODx.msg.confirm({
            title       : _('seopackage.redirects_reset'),
            text        : _('seopackage.redirects_reset_confirm'),
            url         : SeoPackage.config.connector_url,
            params      : {
                action      : 'mgr/redirects/reset',
                context     : MODx.request.context || '',
                type        : 'redirects'
            },
            listeners   : {
                'success'   : {
                    fn          : function() {
                        this.refreshGrids();
                        this.refresh();
                    },
                    scope       : this
                }
            }
        });
    },
    renderUrl: function(d, c, e) {
        if (d.domain) {
            return '<span class="x-grid-domain">' + d.domain + '</span>' + d.path;
        }

        return d.path;
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

Ext.reg('seopackage-grid-redirects', SeoPackage.grid.Redirects);

SeoPackage.window.CreateRedirect = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        width       : 400,
        autoHeight  : true,
        title       : _('seopackage.redirect_create'),
        url         : SeoPackage.config.connector_url,
        baseParams  : {
            action      : 'mgr/redirects/create'
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
                    fieldLabel  : _('seopackage.label_old_url'),
                    description : MODx.expandHelp ? '' : _('seopackage.label_old_url_desc'),
                    name        : 'old_url',
                    anchor      : '100%',
                    allowBlank  : false
                }, {
                    xtype       : MODx.expandHelp ? 'label' : 'hidden',
                    html        : _('seopackage.label_old_url_desc'),
                    cls         : 'desc-under'
                }]
            }, {
                columnWidth : .15,
                items       : [{
                    xtype       : 'checkbox',
                    fieldLabel  : _('seopackage.label_active'),
                    description : MODx.expandHelp ? '' : _('seopackage.label_active_desc'),
                    name        : 'active',
                    inputValue  : 1,
                    checked     : true
                }, {
                    xtype       : MODx.expandHelp ? 'label' : 'hidden',
                    html        : _('seopackage.label_active_desc'),
                    cls         : 'desc-under'
                }]
            }]
        }, {
            xtype       : 'textfield',
            fieldLabel  : _('seopackage.label_new_url'),
            description : MODx.expandHelp ? '' : _('seopackage.label_new_url_desc'),
            name        : 'new_url',
            anchor      : '100%',
            allowBlank  : false
        }, {
            xtype       : MODx.expandHelp ? 'label' : 'hidden',
            html        : _('seopackage.label_new_url_desc'),
            cls         : 'desc-under'
        }, {
            xtype       : 'seopackage-combo-redirect-type',
            fieldLabel  : _('seopackage.label_redirect_type'),
            description : MODx.expandHelp ? '' : _('seopackage.label_redirect_type_desc'),
            name        : 'redirect_type',
            anchor      : '100%',
            allowBlank  : false
        }, {
            xtype       : MODx.expandHelp ? 'label' : 'hidden',
            html        : _('seopackage.label_redirect_type_desc'),
            cls         : 'desc-under'
        }, {
            layout      : 'form',
            labelSeparator : '',
            hidden      : SeoPackage.config.context,
            items       : [{
                xtype       : 'seopackage-combo-context',
                fieldLabel  : _('seopackage.label_context'),
                description : MODx.expandHelp ? '' : _('seopackage.label_context_desc'),
                name        : 'context',
                anchor      : '100%',
                value       : MODx.request.context || ''
            }, {
                xtype       : MODx.expandHelp ? 'label' : 'hidden',
                html        : _('seopackage.label_context_desc'),
                cls         : 'desc-under'
            }]
        }]
    });

    SeoPackage.window.CreateRedirect.superclass.constructor.call(this, config);
};

Ext.extend(SeoPackage.window.CreateRedirect, MODx.Window);

Ext.reg('seopackage-window-redirect-create', SeoPackage.window.CreateRedirect);

SeoPackage.window.UpdateRedirect = function(config) {
    config = config || {};
    
    Ext.applyIf(config, {
        width       : 400,
        autoHeight  : true,
        title       : _('seopackage.redirect_update'),
        url         : SeoPackage.config.connector_url,
        baseParams  : {
            action      : 'mgr/redirects/update'
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
                    xtype       : 'statictextfield',
                    fieldLabel  : _('seopackage.label_old_url'),
                    description : MODx.expandHelp ? '' : _('seopackage.label_old_url_desc'),
                    name        : 'old_url',
                    anchor      : '100%',
                    allowBlank  : false
                }, {
                    xtype       : MODx.expandHelp ? 'label' : 'hidden',
                    html        : _('seopackage.label_old_url_desc'),
                    cls         : 'desc-under'
                }]
            }, {
                columnWidth : .15,
                items       : [{
                    xtype       : 'checkbox',
                    fieldLabel  : _('seopackage.label_active'),
                    description : MODx.expandHelp ? '' : _('seopackage.label_active_desc'),
                    name        : 'active',
                    inputValue  : 1,
                    checked     : true
                }, {
                    xtype       : MODx.expandHelp ? 'label' : 'hidden',
                    html        : _('seopackage.label_active_desc'),
                    cls         : 'desc-under'
                }]
            }]
        }, {
            xtype       : 'textfield',
            fieldLabel  : _('seopackage.label_new_url'),
            description : MODx.expandHelp ? '' : _('seopackage.label_new_url_desc'),
            name        : 'new_url',
            anchor      : '100%',
            allowBlank  : false
        }, {
            xtype       : MODx.expandHelp ? 'label' : 'hidden',
            html        : _('seopackage.label_new_url_desc'),
            cls         : 'desc-under'
        }, {
            xtype       : 'seopackage-combo-redirect-type',
            fieldLabel  : _('seopackage.label_redirect_type'),
            description : MODx.expandHelp ? '' : _('seopackage.label_redirect_type_desc'),
            name        : 'redirect_type',
            anchor      : '100%',
            allowBlank  : false
        }, {
            xtype       : MODx.expandHelp ? 'label' : 'hidden',
            html        : _('seopackage.label_redirect_type_desc'),
            cls         : 'desc-under'
        }, {
            layout      : 'form',
            labelSeparator : '',
            hidden      : SeoPackage.config.context,
            items       : [{
                xtype       : 'seopackage-combo-context',
                fieldLabel  : _('seopackage.label_context'),
                description : MODx.expandHelp ? '' : _('seopackage.label_context_desc'),
                name        : 'context',
                anchor      : '100%',
                value       : MODx.request.context || ''
            }, {
                xtype       : MODx.expandHelp ? 'label' : 'hidden',
                html        : _('seopackage.label_context_desc'),
                cls         : 'desc-under'
            }]
        }]
    });
    
    SeoPackage.window.UpdateRedirect.superclass.constructor.call(this, config);
};

Ext.extend(SeoPackage.window.UpdateRedirect, MODx.Window);

Ext.reg('seopackage-window-redirect-update', SeoPackage.window.UpdateRedirect);