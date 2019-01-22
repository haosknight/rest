/**
 * Created by denis on 22.01.2019.
 */

Ext.application({
    name: 'Fiddle',
    launch: function () {
        var localFilesStore = Ext.create('Ext.data.Store', {
            storeId: 'localFilesStore',
            fields:['id', 'title', 'date', 'author', 'status', 'description'],
            proxy: {
                type: 'ajax',
                url: '/api/v1/task'
            },
            autoLoad: true
        });

        Ext.create('Ext.grid.Panel', {
            title: 'Задачи',
            store: Ext.data.StoreManager.lookup('localFilesStore'),
            columns: [
                {header: 'Номер задачи', dataIndex: 'id'},
                {header: 'Заголовок', dataIndex: 'title'},
                {header: 'Дата выполнения', dataIndex: 'date'},
                {xtype:'actioncolumn',
                    width:40,
                    items:[{
                        getClass: function() {
                            return 'glyphicon glyphicon-remove';
                        },
                        handler:function (grid, rowIndex, colIndex) {
                            console.log(grid.getStore().getAt(rowIndex).data['file']);
                        }
                    }]
                }
            ],
            height: 400,
            width: 1200,
            renderTo: "grid"
        });
    }
});