var akdm = window.akdm || { };

ko.bindingHandlers.jqDatepicker = {
    init: function(element) {
       var currentYear = new Date().getFullYear();
       $(element).datepicker({
           inline: true,
           //showWeek: true,
           changeMonth: true, 
           changeYear: true, 
           yearRange: (currentYear - 10) + ':' + (currentYear + 10)
       });
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
    self.taskStates = {};   
    self.currentDate = ko.observable(lastDate);
    self._filter = {"start_date": akdm.tools.locale2dbDateStr(self.currentDate())};
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
    
    self.filterByState = function (value, event) {
        self._filter.isActive = value;
        self.loadTasks();
    };

    self.selectTask = function (task) {
        self.currentTask(task);
        $('#dlgTasks').modal('show');
    };

    self.newTask = function () {
        var task = new self._TaskPrototype();
        task.start_date(self.currentDate());
        task.end_date(self.currentDate());
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
                .done(function () {
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
    
    self.setTasks = function (tasks) {
        var newTasks = [];
        self.tasks.removeAll();
        $(tasks).each(function (index, task) {
            newTasks.push(self._TaskPrototype.fromJSON(task));
        });
        self.tasks(newTasks);
    };

    self._showError = function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.status === 500) {
            akdm.ui.Feedback.show('#msgFeedback', 
                self._strings.server_error + jqXHR.responseText, 
                akdm.ui.Feedback.ERROR);
        }
    };
    
    self.getCurrentDate = function() {
        return $.datepicker.parseDate(akdm.config.localeDateFormat, self.currentDate());
    };
    
    self.onCurrentDateChange = function () {      
        lastDate = self.currentDate();
        self._filter.start_date = akdm.tools.locale2dbDateStr(self.currentDate());
        self.loadTasks();
    };
    
    self.printTasks = function () {
        var myWindow = window.open(report_tasks, '_blank');
        myWindow.document.title = 'Tareas';
    };
    
    self.loadTasks = function () {
        $.post(self._get, self._filter).done(self.setTasks).fail(self._showError);
    };
    
    self.init = function (strings, taskTypes, taskStates) {
        self.loadTasks();
        self._strings = $.extend(self._strings, strings);
        $(taskTypes).each(function (index, task) {
            self.taskTypes[task.id] = task.name;
        });
        $(taskStates).each(function (index, task) {
            self.taskStates[task.id] = task.name;
        });
    };
};
