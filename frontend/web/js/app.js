/**
 * Набор элементов пользовательского интерфейса
 * Создан 22.01.2019.
 */

Ext.application({
    name: 'Fiddle',
    launch: function () {
        // Панель с заголовком
        Ext.create('Ext.panel.Panel', {
            title: 'Перечень задач. Работа с веб-сервисом',
            margin: '0 0 0 0',
            renderTo: 'panel'
        });

        // Форма поиска
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
                        tasksStore.proxy.setExtraParams({title:searchForm.getForm().getFields().items[0].value});
                        tasksStore.loadPage(1);
                    }
                }
            ]
        });

        // Устанавливаем цвет фона панели под цвет фона страницы
        searchForm.body.setStyle('background','#f5f5f5');

        // Модель задач
        Ext.define('Task', {
            extend: 'Ext.data.Model',
            fields: ['id', 'title', 'date', 'author', 'status', 'description']
        });

        // Хранилище задач
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

        // Таблица для вывода перечня задач
        var tasksGrid = Ext.create('Ext.grid.Panel', {
            title: 'Задачи',
            store: Ext.data.StoreManager.lookup('tasksStore'),
            height: 400,
            width: 750,
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
                    // Кнопка с отправкой запроса на веб-сервис для вывода одной задачи в модальном окне
                    items:[{
                        getClass: function() {
                            return 'glyphicon glyphicon-eye-open';
                        },
                        handler:function (grid, rowIndex, colIndex) {
                            var id = grid.getStore().getAt(rowIndex).data['id'];
                            var savedTask = Ext.util.Cookies.get("task"+id);
                            if (savedTask === null) {
                                //При отсутствии записи в cookie формируем запрос к веб-сервису
                                Ext.Ajax.request({
                                    url: '/api/v1/task/'+id,
                                    success: function(response){
                                        var data=Ext.decode(response.responseText);
                                        if(data.success){
                                            // При успешно выполненом запросе получаем данные задачи в JSON
                                            var record = data.tasks[0];
                                            // Вызываем модальное окно
                                            var win = Ext.widget('taskwindow');
                                            // Устанавливаем заголовок модального окна
                                            win.setTitle("Информация о задаче №"+id);
                                            // Заполняем форму в модальном окне данными задачи
                                            win.down("form").getForm().setValues(record);
                                            // Сохраняем в cookie полученные данные о задаче на 59 минут
                                            var now = new Date();
                                            var expiry = new Date(now.getTime() + 59 * 60 * 1000);
                                            Ext.util.Cookies.set("task"+id, JSON.stringify(record), expiry);
                                        }
                                        else{
                                            Ext.Msg.alert('Ошибка','Задача не найдена');
                                        }
                                    }
                                });
                            } else {
                                // При наличии в cookies нужной записи вызываем модальное окно
                                var win = Ext.widget('taskwindow');
                                // Устанавливаем заголовок модального окна
                                win.setTitle("Информация о задаче №"+id);
                                // Заполняем форму в модальном окне данными задачи
                                win.down("form").getForm().setValues(JSON.parse(savedTask));
                            }
                        }
                    }]
                }
            ],
            // Панель пагинации
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

        // Объявляем элемент модального окна с настройками
        Ext.define('Task', {
            extend: 'Ext.window.Window',
            alias: 'widget.taskwindow',

            bodyPadding: 10,

            title: 'Информация о задаче №',
            layout: 'fit',
            autoShow: true,

            // Форма внутри модального окна для вывода информации о задаче
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