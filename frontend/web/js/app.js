/**
 * Created by denis on 22.01.2019.
 */

Ext.application({
    name: 'Fiddle',
    launch: function () {
        Ext.define('Task', {
            extend: 'Ext.data.Model',
            fields: ['id', 'title', 'date', 'author', 'status', 'description']
        });

        var localFilesStore = Ext.create('Ext.data.Store', {
            storeId: 'taskStore',
            model: 'Task',
            proxy: {
                type: 'ajax',
                url: '/api/v1/task'
            },
            autoLoad: true
        });

        Ext.create('Ext.grid.Panel', {
            title: 'Задачи',
            store: Ext.data.StoreManager.lookup('taskStore'),
            height: 400,
            width: 650,
            left: '50%',
            renderTo: 'grid',
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
                            console.log(grid.getStore().getAt(rowIndex).data['file']);
                        }
                    }]
                }
            ],
            dockedItems: [{
                xtype: 'pagingtoolbar',
                store: Ext.data.StoreManager.lookup('taskStore'),
                dock: 'bottom',
                displayInfo: true
            }]
        });
    }
});