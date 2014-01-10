var akdm = window.akdm || {};

ko.bindingHandlers.jqDatepicker = {
    init: function(element) {
        var currentYear = new Date().getFullYear();
        $(element).datepicker({
            //inline: true,
            //showWeek: true,
            changeMonth: true,
            changeYear: true,
            yearRange: (currentYear - 10) + ':' + (currentYear + 10),
            autoSize: true
        });
    }
};

ko.bindingHandlers.jqDateTimePicker = {
    init: function(element, valueAccessor, allBindingsAccessor) {
        //initialize datetimepicker with some optional options
        var options = allBindingsAccessor().datetimepickerOptions || {};
        $(element).datetimepicker(options);

        //handle the field changing
        ko.utils.registerEventHandler(element, "change", function() {
            var observable = valueAccessor();
            observable($(element).datetimepicker("getDate"));
        });

        //handle disposal (if KO removes by the template binding)
        ko.utils.domNodeDisposal.addDisposeCallback(element, function() {
            $(element).datetimepicker("destroy");
        });

    },
    update: function(element, valueAccessor) {
        var value = ko.utils.unwrapObservable(valueAccessor());

        //handle date data coming via json from Microsoft
        if (String(value).indexOf('/Date(') == 0) {
            value = new Date(parseInt(value.replace(/\/Date\((.*?)\)\//gi, "$1")));
        }

        current = $(element).datetimepicker("getDate");

        if (value - current !== 0) {
            $(element).datetimepicker("setDate", value);
        }
    }
};

ko.bindingHandlers.timepicker1 = {
    init: function(element, valueAccessor, allBindingsAccessor) {
        //initialize timepicker with some optional options
        var options = allBindingsAccessor().timepickerOptions || {},
                input = $(element).timepicker(options);

        //handle the field changing
        ko.utils.registerEventHandler(element, "time-change", function(event, time) {
            var observable = valueAccessor(),
                    current = ko.utils.unwrapObservable(observable);

            if (current - time !== 0) {
                observable(time);
            }
        });

        //handle disposal (if KO removes by the template binding)
        ko.utils.domNodeDisposal.addDisposeCallback(element, function() {
            $(element).timepicker("destroy");
        });
    },
    update: function(element, valueAccessor) {
        var value = ko.utils.unwrapObservable(valueAccessor()),
                // calling timepicker() on an element already initialized will
                // return a TimePicker object
                instance = $(element).timepicker();

        if (value - instance.getTime() !== 0) {
            instance.setTime(value);
        }
    }
};

ko.bindingHandlers.timepicker3 = {
    init: function(element, valueAccessor, allBindingsAccessor) {
        //initialize timepicker with some optional options
        var options = allBindingsAccessor().timepickerOptions || {};
        $(element).timepicker(options);

        //handle the field changing
        ko.utils.registerEventHandler(element, "change", function() {
            var observable = valueAccessor();
            observable($(element).timepicker("getDate"));
        });

        //handle disposal (if KO removes by the template binding)
        ko.utils.domNodeDisposal.addDisposeCallback(element, function() {
            $(element).timepicker("destroy");
        });

    },
    //update the control when the view model changes
    update: function(element, valueAccessor) {

        var value = ko.utils.unwrapObservable(valueAccessor()),
                current = $(element).timepicker("getDate");

        if (value - current !== 0) {
            $(element).timepicker("setDate", value);
        }
    }
};

ko.bindingHandlers.timepicker = {
    init: function(element, valueAccessor, allBindingsAccessor) {
        //initialize datepicker with some optional options
        var options = allBindingsAccessor().timepickerOptions || {};
        $(element).timepicker(options);

        //handle the field changing
        ko.utils.registerEventHandler(element, "change", function() {
            var observable = valueAccessor();
            try {
                observable($(element).timepicker("getDate"));//****
            }
            catch (ex) {
            }
        });

        //handle disposal (if KO removes by the template binding)
        ko.utils.domNodeDisposal.addDisposeCallback(element, function() {
            $(element).timepicker("remove"); //destroy
        });

    },
    update: function(element, valueAccessor) {
        var value = ko.utils.unwrapObservable(valueAccessor()),
                current = $(element).timepicker("getTime");

        if (value - current !== 0) {
            $(element).timepicker("setTime", value);
        }
    }
};

ko.bindingHandlers.jqValidator = {
    init: function(element) {
        $(element).validate({
            ignore: '',
            highlight: function(element) {
                $(element).closest('div').addClass('error');
            },
            success: function(element) {
                element
                        .closest('div').removeClass('error');
            }
        });
    }
};

akdm.TasksViewModel = function() {
    var self = this;
    var lastDate = $.datepicker.formatDate(akdm.config.localeDateFormat, new Date());
    var report_tasks = '/task/tasks_report/';
    self._get = '/task/get';
    self._add = '/task/add';
    self._update = '/task/update';
    self._delete = '/task/delete/';
    self._TaskPrototype = akdm.model.Task;
    self._strings = {
        task_created: 'Tarea creada satisfactoriamente.',
        task_updated: 'Tarea actualizada satisfactoriamente.',
        task_deleted: 'Tarea eliminada satisfactoriamente.',
        server_error: 'Error interno del servidor. Detalles: ',
        validation_error: 'Algún valor indicado no es correcto. Verifique los datos.'
    };

    self.taskTypes = {};
    self.taskImportances = {};
    self.taskStates = {};
    self.users = {};
    self._currentUser = '';
    self.viewDaily = ko.observable(true);
    self.currentDate = ko.observable(lastDate);
    self.currentDateText = ko.observable('FECHA: ' + self.currentDate());
    self._filter = {"start_date": akdm.tools.locale2dbDateStr(self.currentDate()), "dialy": self.viewDaily()};
    self.tasks = ko.observableArray();
    self.filter = ko.observable();
    self.filteredTasks = ko.computed(function() {
        return ko.utils.arrayFilter(self.tasks(), function(task) {
            return self.filter() === undefined
                    || task.task().toLowerCase()
                    .indexOf(self.filter().toLowerCase()) >= 0;
        });
    });
    self.currentTask = ko.observable();

    self.selectTask = function(task) {
        self.currentTask(task);
        $('#dlgTasks').modal('show');
    };

    self.setViewDaily = function(viewDaily) {
        self.viewDaily(viewDaily);
        self._filter.dialy = viewDaily;
        self.setCurrentDateText(viewDaily);
        self.loadTasks();
    };

    self.setCurrentDateText = function(viewDaily) {
        if (viewDaily) {
            self.currentDateText('FECHA: ' + self.currentDate());
        } else {
            var months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", 
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
            var currDate = self.getCurrentDate();
            var currYear = currDate.getFullYear();
            var currMonth = months[currDate.getMonth()];
            self.currentDateText('MES: ' + currMonth + '/' + currYear);
        }
    };

    self.newTask = function() {
        var task = new self._TaskPrototype();
        task.start_date(self.currentDate());
        var currDate = new Date();
        var currTime = currDate.getHours() + ':' + currDate.getMinutes() + ':00';
        task.start_time(currTime);
        task.end_date(self.currentDate());
        task.end_time(currTime);
        task.login_id(self._currentUser);
        self.selectTask(task);
    };

    self.saveTask = function() {
        if (!$('#frm').valid()) {
            akdm.ui.Feedback.show('#msgFeedback',
                    self._strings.validation_error,
                    akdm.ui.Feedback.ERROR, akdm.ui.Feedback.LONG);
            return;
        }

        var task = self.currentTask();
        if (task.id())
            // Actualizar
            $.post(self._update, task.toJSON())
                    .done(function() {
                        if (self.currentDate() != self.currentTask().start_date())
                            self.tasks.remove(self.currentTask());
                        akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.task_updated + '</strong>',
                                akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
                    })
                    .fail(self._showError);
        else {
            // Insertar
            $.post(self._add, task.toJSON())
                    .done(function(newId) {
                        task.id(newId);
                        if (self.currentDate() == self.currentTask().start_date())
                            self.tasks.push(self.currentTask());
                        //self.tasks.splice(0,0,self.currentTask());
                        akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.task_created + '</strong>',
                                akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
                    })
                    .fail(self._showError);
        }
    };

    self.removeTask = function() {
        $.get(self._delete + self.currentTask().id())
                .done(function() {
                    self.tasks.remove(self.currentTask());
                    self.currentTask(new self._TaskPrototype());
                    akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.task_deleted + '</strong>',
                            akdm.ui.Feedback.INFO, akdm.ui.Feedback.SHORT);
                })
                .fail(self._showError);
    };

    self.setTasks = function(tasks) {
        var newTasks = [];
        self.tasks.removeAll();
        $(tasks).each(function(index, task) {
            newTasks.push(self._TaskPrototype.fromJSON(task));
        });
        self.tasks(newTasks);
    };

    self._showError = function(jqXHR, textStatus, errorThrown) {
        if (jqXHR.status === 500) {
            akdm.ui.Feedback.show('#msgFeedback',
                    self._strings.server_error + jqXHR.responseText,
                    akdm.ui.Feedback.ERROR);
        }
    };

    self.getCurrentDate = function() {
        return $.datepicker.parseDate(akdm.config.localeDateFormat, self.currentDate());
    };

    self.onCurrentDateChange = function() {
        lastDate = self.currentDate();
        self._filter.start_date = akdm.tools.locale2dbDateStr(self.currentDate());
        self.setCurrentDateText(self.viewDaily());
        self.loadTasks();
    };

    self.printTasks = function() {
        var myWindow = window.open(report_tasks + self._filter.start_date + '/' + self._filter.dialy, '_blank');
        myWindow.document.title = 'Tareas';
    };

    self.loadTasks = function() {
        $.post(self._get, self._filter).done(self.setTasks).fail(self._showError);
    };

    self.init = function(strings, current_user, taskTypes, taskImportances, taskStates, users) {
        self.loadTasks();
        self._strings = $.extend(self._strings, strings);
        self._currentUser = current_user;
        $(taskTypes).each(function(index, task) {
            self.taskTypes[task.id] = task.name;
        });
        $(taskImportances).each(function(index, task) {
            self.taskImportances[task.id] = task.name;
        });
        $(taskStates).each(function(index, task) {
            self.taskStates[task.id] = {'name': task.name, 'color': task.color};
        });
        $(users).each(function(index, user) {
            self.users[user.id] = user.email;
        });
    };
};
