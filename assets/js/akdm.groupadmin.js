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
    var student_add = '/group/student_add/';
    var student_update = '/group/student_update/';
    var student_delete = '/group/student_delete/';
    var get_attendance_for_month = '/group/get_attendance_for_month/';
    var add_student_attendance = '/group/add_student_attendance/';
    var delete_student_attendance = '/group/delete_student_attendance/';
    var dayLetter = [];
    var lastDate = $.datepicker.formatDate(akdm.config.localeDateFormat, new Date());
    var empty_classroom = {"id": 0, "name": "", "capacity": 0};
    self._get = '/group/get';
    self._add = '/group/add';
    self._update = '/group/update';
    self._delete = '/group/delete/';
    self._GroupPrototype = akdm.model.Group;
    self._students_get = '/group/students_get/';
    self._strings = {
        group_created: 'Grupo creado satisfactoriamente.',
        group_updated: 'Grupo actualizado satisfactoriamente.',
        group_deleted: 'Grupo eliminado satisfactoriamente.',
        server_error: 'Error interno del servidor. Detalles: ',
        validation_error: 'Algún valor indicado no es correcto. Verifique los datos.',
        day_short_names: 'Lu,Ma,Mi,Ju,Vi,Sa'
    };
    self._filter = { "academicPeriod": null };
    self.classrooms = {};
    self.studentList = ko.observableArray();
    self.currentStudent = ko.observable();
    self.viewStudentsAsList = ko.observable(false);
    self.viewDailyAttendance = ko.observable(true);
    self.currentDate = ko.observable(lastDate);
    self.groups = ko.observableArray();
    self.filter = ko.observable();
    self.currentGroup = ko.observable();
    self.currentAssistance = ko.observableArray();
    self.filteredGroups = ko.computed(function() {
        return ko.utils.arrayFilter(self.groups(), function(group) {
            return self.filter() === undefined
                    || group.name().toLowerCase()
                    .indexOf(self.filter().toLowerCase()) >= 0;
        });
    });
    self.attendanceDays = ko.observableArray();
    self.attendance = ko.observable();
    self.canAddMoreStudents = ko.computed({
        read: function () {
            return self.currentGroup() && self.classrooms[self.currentGroup().classroom_id()] &&
                    Number(self.classrooms[self.currentGroup().classroom_id()].capacity) > self.studentList().length;
        }
    });
    self.overbooking = ko.computed({
        read: function () {
            return self.currentGroup() && self.classrooms[self.currentGroup().classroom_id()] &&
                    Number(self.classrooms[self.currentGroup().classroom_id()].capacity) < self.studentList().length;
        }
    });
    self.filterByAcademicPeriod = ko.computed({
        read: function () {
            return self._filter.academicPeriod;
        },
        write: function (data) {
            self._filter.academicPeriod = data;
            loadGroups();
        }
    });
    
    var setAttendance = function(attendanceList) {
        var currDate = self.getCurrentDate();
        var currYear = currDate.getFullYear();
        var currMonth = currDate.getMonth();
        var weekDays = ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
        var teachingDays = [];
        var attendance = {};
        var newAttendanceDays = [];
        $(self.studentList()).each(function (index, student) {
            attendance[student.contact_id()] = [];
        });
        $(attendanceList).each(function(index, att) {
            // Adicionar solo los datos de asistencia de los estudiantes de la lista de estudiantes actual
            if (attendance.hasOwnProperty(att.student_id))
                attendance[att.student_id].push(akdm.tools.db2LocaleDateStr(att.date));
        });
        self.attendance(attendance);
        $(weekDays).each(function (index, day) {
            if (self.currentGroup()[day]() === "1")
                teachingDays.push(index);
        });
        self.attendanceDays.removeAll();
        for (var day = 1; day <= Date.getDaysInMonth(currYear, currMonth); day++) {
            var teachingDayIndex = teachingDays.indexOf(new Date(currYear, currMonth, day).getDay() - 1);
            if (teachingDayIndex >= 0)
                newAttendanceDays.push({number: day, name: dayLetter[teachingDays[teachingDayIndex]]});
        }
        self.attendanceDays(newAttendanceDays);
    };
    
    self.updateAttendanceDays = function () {
        if (! self.currentGroup()) return [];
        var group = self.currentGroup().id();
        var currDate = self.getCurrentDate();
        var currYear = currDate.getFullYear();
        var currMonth = currDate.getMonth();
        $.get(get_attendance_for_month + group + '/' + currYear + '/' + (currMonth + 1))
                .done(setAttendance)
                .fail(self._showError);
    };
    
    self.attended = function (student_id, date) {
        if (! self.attendance()) return false;
        var attendance = self.attendance()[student_id];
        return $.isArray(attendance) && $.inArray(date, attendance) >= 0;
    };
   
    self.genAttendanceDate = function (day) {
        var currDate = self.getCurrentDate();
        var currYear = currDate.getFullYear();
        var currMonth = currDate.getMonth();
        return akdm.tools.db2LocaleDateStr(currYear + '-' + (currMonth + 1) + '-' + day);
    };
    
    self.getCurrentDate = function() {
        return $.datepicker.parseDate(akdm.config.localeDateFormat, self.currentDate());
    };
    
    self.getCurrentMonth = function () {
        return $.datepicker.formatDate("MM / yy", self.getCurrentDate());
    };

    self.selectStudent = function(student) {
        self.currentStudent(student);
    };

    self.newStudent = function() {
        var newStudent = new akdm.model.Student();
        self.currentStudent(newStudent);
    };

    self.setViewStudentsAsList = function (viewAsList, event) {
        self.updateAttendanceDays();
        self.viewStudentsAsList(viewAsList);
    };
    
    self.setViewDailyAttendance = function (viewDaily) {
        self.updateAttendanceDays();
        self.viewDailyAttendance(viewDaily);
    };

    self.setStudentList = function(studentList) {
        var newStudentList = [];
        self.studentList.removeAll();
        $(studentList).each(function(index, student) {
            newStudentList.push(akdm.model.Student.fromJSON(student));
        });
        self.studentList(newStudentList);
    };

    self.selectGroup = function(group) {
        self.currentGroup(group);
        // Cargar listado de estudiantes.
        self.currentStudent(new akdm.model.Student());
        //self.setStudentList([{first_name: 'Estudiante 1', picture: ''}]);
        $.get(self._students_get + group.id()).done(self.setStudentList).fail(self._showError);
        self.updateAttendanceDays();
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
            $.post(self._update, group.toJSON()).done(function() {
                akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.group_updated + '</strong>',
                        akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
            }).fail(self._showError);
        else {
            // Insertar
            $.post(self._add, group.toJSON()).done(function(newId) {
                group.id(newId);
                self.groups.push(self.currentGroup());
                akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.group_created + '</strong>',
                        akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
            }).fail(self._showError);
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
        if (false || !$('#frm').valid()) {
            akdm.ui.Feedback.show('#msgFeedback',
                    self._strings.validation_error,
                    akdm.ui.Feedback.ERROR, akdm.ui.Feedback.LONG);
            return;
        }

        var student = self.currentStudent();
        //student.group_id(self.currentGroup().id());
        console.log('Estudiante id grupo: ' + student.group_id());
        if (student.group_id())
            // Actualizar
            $.get(student_update + student.contact_id() + '/' + self.currentGroup().id())
                    .done(function() {
                student.group_id(self.currentGroup().id());
                akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.student_updated + '</strong>',
                        akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
            })
                    .fail(self._showError);
        else {
            // Insertar
            $.get(student_add + student.contact_id() + '/' + self.currentGroup().id()).done(function(newId) {
                student.group_id(self.currentGroup().id());
                self.studentList.push(self.currentStudent());
                akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.student_created + '</strong>',
                        akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
            }).fail(self._showError);
        }
        
        
    };

    self.removeStudent = function() {
        var student = self.currentStudent();
        $.get(student_delete + student.contact_id())
                .done(function() {
                    self.studentList.remove(self.currentStudent());
                    self.currentStudent(new akdm.model.Student());
                    akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.student_deleted + '</strong>',
                            akdm.ui.Feedback.INFO, akdm.ui.Feedback.SHORT);
                })
                .fail(self._showError);
    };

    self.activateTab = function(vm, e) {
        e.preventDefault();
        $(e.target).tab('show');
        if (e.target.hash === '#groupAssistance') 
            self.updateAttendanceDays(); // Recalcular los días de asistencia
    };

    self.setGroups = function(groups) {
        var newGroups = [];
        self.groups.removeAll();
        $(groups).each(function(index, group) {
            newGroups.push(self._GroupPrototype.fromJSON(group));
        });
        self.groups(newGroups);
    };

    self._showError = function(jqXHR, textStatus, errorThrown) {
        if (jqXHR.status === 500) {
            akdm.ui.Feedback.show('#msgFeedback',
                    self._strings.server_error + jqXHR.responseText,
                    akdm.ui.Feedback.ERROR);
        }
    };
    
    self.onCurrentDateChange = function () {
        if (self.getCurrentMonth(lastDate) !== self.getCurrentMonth(self.currentDate()))
            self.updateAttendanceDays();
        lastDate = self.currentDate();
    };
    
    self.onAttendanceDayChange = function (id, date, event) {
        var updateUrl = $(event.target).prop('checked')
                            ? add_student_attendance 
                            : delete_student_attendance;
        $.get(updateUrl + id + '/' + akdm.tools.locale2dbDateStr(date))
                .done(function() {
                    akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.group_updated + '</strong>',
                            akdm.ui.Feedback.INFO, akdm.ui.Feedback.SHORT);
                })
                .fail(self._showError);
        if ($(event.target).prop('checked'))
            self.attendance()[id].push(date);
        else {
            var index = $.inArray(date, self.attendance()[id]);
            if (index >= 0)
                delete self.attendance()[id][index];
        }
    };
    
    var loadGroups = function () {
        self.newGroup();
        $.post(self._get, self._filter).done(self.setGroups).fail(self._showError);
    };
    
    self.init = function(strings, classrooms) {
        loadGroups();
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
        dayLetter = self._strings.day_short_names.split(',');
        $(classrooms).each(function (index, classroom) {
            self.classrooms[classroom.id] = classroom;
        });
    };
};
