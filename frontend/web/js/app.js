/**
 * Created by denis on 22.01.2019.
 */

Ext.application({
    name: 'Fiddle',
    launch: function () {
        var searchForm = Ext.create('Ext.form.Panel', {
            renderTo: 'search',
            title: false,
            height: 50,
            width: 370,
            bodyPadding: 10,
            background: false,
            items: [
                {
                    xtype: 'textfield',
                    fieldLabel: false,
                    name: 'title',
                    emptyText: 'Поиск задачи по заголовку (без учета регистра)',
                    width: 350,
                    onChange: function (value,lastValue) {
                        this.up("form").submit({
                            url:'/api/v1/task',
                            success: function(form, response) {
                                if (response.result.success === true) {
                                    tasksStore.proxy.setExtraParams({title:searchForm.getForm().getFields().items[0].value});
                                    tasksStore.loadPage(1);
                                }
                            }
                        })
                    }
                }
            ]
        });

        searchForm.body.setStyle('background','#f5f5f5');

        Ext.define('Task', {
            extend: 'Ext.data.Model',
            fields: ['id', 'title', 'date', 'author', 'status', 'description']
        });

        var tasksStore = Ext.create('Ext.data.Store', {
            storeId: 'tasksStore',
            model: 'Task',
            pageSize: 10,
            proxy: {
                type: 'ajax',
                url: '/api/v1/task',
                noCache: false,
                extraParams: {title:''},
                reader: {
                    type: 'json',
                    rootProperty: 'tasks',
                    totalProperty: 'totalCount'
                }
            },
            autoLoad: true
        });

        var tasksGrid = Ext.create('Ext.grid.Panel', {
            title: 'Задачи',
            store: Ext.data.StoreManager.lookup('tasksStore'),
            height: 400,
            width: 750,
            left: '50%',
            renderTo: 'grid',
            //pruneRemoved: false,
            columns: [
                {
                    header: 'Номер задачи',
                    dataIndex: 'id',
                    width: '130px',
                    sortable: false,
                    hideable: false,
                    flex: 1
                },
                {
                    header: 'Заголовок',
                    dataIndex: 'title',
                    width: '100px',
                    sortable: false,
                    hideable: false,
                    flex: 1
                },
                {
                    header: 'Дата выполнения',
                    dataIndex: 'date',
                    width: '210px',
                    sortable: false,
                    hideable: false,
                    flex: 1
                },
                {xtype:'actioncolumn',
                    width:40,
                    items:[{
                        getClass: function() {
                            return 'glyphicon glyphicon-eye-open';
                        },
                        handler:function (grid, rowIndex, colIndex) {
                            var id = grid.getStore().getAt(rowIndex).data['id'];
                            Ext.Ajax.request({
                                url: '/api/v1/task/'+id,
                                success: function(response){
                                    var data=Ext.decode(response.responseText);
                                    if(data.success){
                                        var record = data.tasks[0];
                                        var win = Ext.widget('taskwindow');
                                        win.setTitle("Информация о задаче №"+id);
                                        win.down("form").getForm().setValues(record);
                                    }
                                    else{
                                        Ext.Msg.alert('Ошибка','Задача не найдена');
                                    }
                                }
                            });
                        }
                    }]
                }
            ],
            dockedItems: [{
                xtype: 'pagingtoolbar',
                store: Ext.data.StoreManager.lookup('tasksStore'),
                dock: 'bottom',
                displayInfo: true,
                beforePageText: 'Страница',
                afterPageText: 'из {0}',
                displayMsg: 'Задачи {0} - {1} из {2}'
            }]
        });

        Ext.define('Task', {
            extend: 'Ext.window.Window',
            alias: 'widget.taskwindow',

            bodyPadding: 10,

            title: 'Информация о задаче №',
            layout: 'fit',
            autoShow: true,

            initComponent: function() {
                this.items = [{
                    xtype: 'form',
                    autoLoad: true,
                    items: [{
                        xtype: 'textfield',
                        name : 'title',
                        fieldLabel: 'Заголовок',
                        editable: false
                    },{
                        xtype: 'textfield',
                        name : 'date',
                        fieldLabel: 'Дата выполнения',
                        editable: false
                    },{
                        xtype: 'textfield',
                        name : 'author',
                        fieldLabel: 'Автор',
                        editable: false
                    },{
                        xtype: 'textfield',
                        name : 'status',
                        fieldLabel: 'Статус',
                        editable: false
                    },{
                        xtype: 'textfield',
                        name : 'description',
                        fieldLabel: 'Описание',
                        editable: false
                    }]
                }];
                this.buttons = [{
                    text: 'Закрыть',
                    scope: this,
                    handler:function (button) {
                        button.up('window').destroy();
                    }
                }];

                this.callParent(arguments);
            }
        });
    }
});