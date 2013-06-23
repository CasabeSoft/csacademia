var akdm = window.akdm || {};

ko.bindingHandlers.jqDatepicker = {
    init: function(element) {
        var currentYear = new Date().getFullYear();
        $(element).datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: (currentYear - 10) + ':' + (currentYear + 10)
        });
    }
};

akdm.GroupsViewModel = function() {
    var self = this;
    self._get = '/group/get';
    self._add = '/group/add';
    self._update = '/group/update';
    self._delete = '/group/delete/';
    self._GroupPrototype = akdm.model.Group;
    self._students_get = '/group/students_get/';
    var student_add = '/group/student_add';
    var student_update = '/group/student_update';
    var student_delete = '/group/student_delete/';

    self.studentList = ko.observableArray();
    self.currentStudent = ko.observable();

    self.selectStudent = function(student) {
        self.currentStudent(student);
    };

    self.newStudent = function() {
        var newStudent = new akdm.model.Student();
        self.currentStudent(newStudent);
    };

    self._strings = {
        group_created: 'Grupo creado satisfactoriamente.',
        group_updated: 'Grupo actualizado satisfactoriamente.',
        group_deleted: 'Grupo eliminado satisfactoriamente.',
        server_error: 'Error interno del servidor. Detalles: ',
        validation_error: 'Algún valor indicado no es correcto. Verifique los datos.'
    };

    self.groups = ko.observableArray();
    self.filter = ko.observable();
    self.filteredGroups = ko.computed(function() {
        return ko.utils.arrayFilter(self.groups(), function(group) {
            return self.filter() === undefined
                    || group.name().toLowerCase()
                    .indexOf(self.filter().toLowerCase()) >= 0;
        });
    });
    self.currentGroup = ko.observable();
    self.currentList = ko.observableArray();
    self.currentAssistance = ko.observableArray();

    self.setCurrentList = function(list) {
        self.currentList.removeAll();
        $(list).each(function(index, contact) {
            self.currentList.push(akdm.model.Contact.fromJSON(contact));
        });
    };

    self.setStudentList = function(studentList) {
        self.studentList.removeAll();
        $(studentList).each(function(index, student) {
            self.studentList.push(akdm.model.Student.fromJSON(student));
        });
    };

    self.selectGroup = function(group) {
        self.currentGroup(group);
        $.get('/contact/get').done(self.setCurrentList).fail(self._showError);
        // Cargar listado de estudiantes.
        self.currentStudent(new akdm.model.Student());
        //self.setStudentList([{first_name: 'Estudiante 1', picture: ''}]);
        $.get(self._students_get + group.id()).done(self.setStudentList).fail(self._showError);
    };

    self.newGroup = function() {
        var newGroup = new self._GroupPrototype();
        self.currentGroup(newGroup);
    };

    self.saveGroup = function() {
        if (!$('#frm').valid()) {
            akdm.ui.Feedback.show('#msgFeedback',
                    self._strings.validation_error,
                    akdm.ui.Feedback.ERROR, akdm.ui.Feedback.LONG);
            return;
        }
        var group = self.currentGroup();
        if (group.id())
            // Actualizar
            $.post(self._update, group.toJSON())
                    .done(function() {
                akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.group_updated + '</strong>',
                        akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
            })
                    .fail(self._showError);
        else {
            // Insertar
            $.post(self._add, group.toJSON())
                    .done(function(newId) {
                group.id(newId);
                self.groups.push(self.currentGroup());
                akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.group_created + '</strong>',
                        akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
            })
                    .fail(self._showError);
        }
    };

    self.removeGroup = function() {
        $.get(self._delete + self.currentGroup().id())
                .done(function() {
            self.groups.remove(self.currentGroup());
            self.currentGroup(new self._GroupPrototype());
            akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.group_deleted + '</strong>',
                    akdm.ui.Feedback.INFO, akdm.ui.Feedback.SHORT);
        })
                .fail(self._showError);
    };

    self.saveStudent = function() {
        // TODO: Implementar validación de datos del familiar.
        if (false || !$('#frm').valid()) {
            akdm.ui.Feedback.show('#msgFeedback',
                    self._strings.validation_error,
                    akdm.ui.Feedback.ERROR, akdm.ui.Feedback.LONG);
            return;
        }

        var student = self.currentStudent();
        student.group_id(self.currentGroup().id());
        $.post(student_add, student.toJSON())
                .done(function(newId) {
            student.contact_id(newId);
            self.studentList.push(self.currentStudent());
            akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.group_updated + '</strong>',
                    akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
        })
                .fail(self._showError);
        /*if (student.group_id()) {
            // Actualizar
            student.group_id(self.currentGroup().id());
            $.post(student_update, student.toJSON())
                    .done(function() {
                akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.group_updated + '</strong>',
                        akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
            })
                    .fail(self._showError);


        } else {
            // Insertar
            student.group_id(self.currentGroup().id());
            $.post(student_add, student.toJSON())
                    .done(function() {
                akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.group_updated + '</strong>',
                        akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
            })
                    .fail(self._showError);
        }*/
    };

    self.removeStudent = function() {
        var student = self.currentStudent();
        $.get(student_delete + student.contact_id())
                .done(function() {
            self.studentList.remove(self.currentStudent());
            self.currentStudent(new akdm.model.Student());
            akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.group_updated + '</strong>',
                    akdm.ui.Feedback.INFO, akdm.ui.Feedback.SHORT);
        })
                .fail(self._showError);
    };

    self.activateTab = function(vm, e) {
        e.preventDefault();
        $(e.target).tab('show');
    };

    self.setGroups = function(groups) {
        self.groups.removeAll();
        $(groups).each(function(index, group) {
            self.groups.push(self._GroupPrototype.fromJSON(group));
        });
    };

    self._showError = function(jqXHR, textStatus, errorThrown) {
        if (jqXHR.status === 500) {
            akdm.ui.Feedback.show('#msgFeedback',
                    self._strings.server_error + jqXHR.responseText,
                    akdm.ui.Feedback.ERROR);
        }
    };

    self.init = function(strings) {
        self.currentGroup(new self._GroupPrototype());
        $.get(self._get).done(self.setGroups).fail(self._showError);
        self._strings = $.extend(self._strings, strings);
        $("#frm").validate({
            ignore: '',
            highlight: function(element) {
                $(element).closest('div').addClass('error');
            },
            success: function(element) {
                element
                        .closest('div').removeClass('error');
            }
        });
        self.currentStudent(new akdm.model.Student());
    };
};
