Ext.require([
    'Ext.form.*',
    'Ext.layout.container.Column',
    'Ext.window.MessageBox',
    'Ext.fx.target.Element'
]);

Ext.onReady(function(){

    Ext.create('Ext.data.Store', {
        fields : ['boxLabel', 'name', 'inputValue'],
        proxy : {
            type : 'ajax',
            url : '/site/getUser',
            reader : {
                type : 'json',
                root : 'data'
            }
        },
        autoLoad : true,
        listeners: {
            load: function(store, records) {
                usersName.removeAll();
                usersName.add(Ext.Array.map(records, function(record) {
                    return {
                        boxLabel: record.get('boxLabel'),
                        inputValue: record.get('inputValue'),
                        name: record.get('name')
                    };
                }));
            }
        }
    });

    Ext.create('Ext.data.Store', {
        fields : ['boxLabel', 'name', 'inputValue'],
        proxy : {
            type : 'ajax',
            url : '/site/geteducation',
            reader : {
                type : 'json',
                root : 'data'
            }
        },
        autoLoad : true,
        listeners: {
            load: function(store, records) {
                educationTitle.removeAll();

                educationTitle.add(Ext.Array.map(records, function(record) {
                    return {
                        boxLabel: record.get('boxLabel'),
                        inputValue: record.get('inputValue'),
                        name: record.get('name')
                    };
                }));
            }
        }
    });

    Ext.create('Ext.data.Store', {
        fields : ['boxLabel', 'name', 'inputValue'],
        proxy : {
            type : 'ajax',
            url : '/site/getcities',
            reader : {
                type : 'json',
                root : 'data'
            }
        },
        autoLoad : true,
        listeners: {
            load: function(store, records) {
                citiesTitle.removeAll();

                citiesTitle.add(Ext.Array.map(records, function(record) {
                    return {
                        boxLabel: record.get('boxLabel'),
                        inputValue: record.get('inputValue'),
                        name: record.get('name')
                    };
                }));
            }
        }
    });

    var usersName = Ext.create('Ext.form.CheckboxGroup', {
        fieldLabel: 'Имена',
        componentCls : 'checkboxGroup'
    });

    var educationTitle = Ext.create('Ext.form.CheckboxGroup', {
        fieldLabel: 'Образования',
        componentCls : 'checkboxGroup'
    });

    var citiesTitle = Ext.create('Ext.form.CheckboxGroup', {
        fieldLabel: 'Города',
        componentCls : 'checkboxGroup'
    });

    var fp = Ext.create('Ext.FormPanel', {
        title: 'Задание для тестов',
        frame: true,
        fieldDefaults: {
            labelWidth: 110
        },
        width: 900,
        renderTo:'formCheckbox',
        bodyPadding: 10,
        vertical: true,
        items: [
            usersName,
            educationTitle,
            citiesTitle
        ],
        buttons: [{
            text: 'Обновить список',
            handler: function() {
                var form = this.up('form').getForm().getValues();
                store.proxy.extraParams = { data : Ext.JSON.encode(form)};
                store.load();
            }
        }]
    });


    Ext.define('myModel', {
        extend: 'Ext.data.Model',
        fields: ['name','educationTitle','cityTitle']
    });

    var store = Ext.create('Ext.data.Store', {
        model: 'myModel',
        proxy: {
            type: 'ajax',
            url: '/site/getdata',
            reader: {
                type: 'json',
                root: 'data'
            }
        },
        autoLoad: true
    });

    var grid =Ext.create('Ext.grid.Panel', {
        title: 'Пользователи',
        height: 500,
        width: 900,
        store: store,
        columns: [{
            header: 'Имя пользователя',
            dataIndex: 'name',
            flex: 3
        },{
            header: 'Образование',
            dataIndex: 'educationTitle',
            flex: 3
        },{
            header: 'Город',
            dataIndex: 'cityTitle',
            flex: 3
        }],
        renderTo: 'tableGrid'
    });

});
