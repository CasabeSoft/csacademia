var akdm = window.akdm || { };

ko.bindingHandlers.jqDatepicker = {
    init: function(element) {
       var currentYear = new Date().getFullYear();
       $(element).datepicker({
           changeMonth: true, 
           changeYear: true, 
           yearRange: (currentYear - 90) + ':' + (currentYear + 10)
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
    self._string = {
        group_created: 'Grupo creado satisfactoriamente.',
        group_updated: 'Grupo actualizado satisfactoriamente.',
        group_deleted: 'Grupo eliminado satisfactoriamente.',
        server_error: 'Error interno del servidor. Detalles: '
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

    self.selectGroup = function (group) {
        self.currentGroup(group);
    };   

    self.newGroup = function () {
        var newGroup = new self._GroupPrototype();
        self.currentGroup(newGroup);
    };

    self.saveGroup = function() {
        var group = self.currentGroup();
        if (group.id())
            // Actualizar
            $.post(self._update, group.toJSON())
                .done(function () {
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

    self.activateTab = function (vm, e) {
        e.preventDefault();
        $(e.target).tab('show');
    };
    
    self.setGroups = function (groups) {
        self.groups.removeAll();
        $(groups).each(function (index, group) {
            self.groups.push(self._GroupPrototype.fromJSON(group));
        });
    };

    self._showError = function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.status === 500) {
            akdm.ui.Feedback.show('#msgFeedback', 
                self._strings.server_error + jqXHR.responseText, 
                akdm.ui.Feedback.ERROR);
        }
    };
    
    self.init = function (strings) {
        self.currentGroup(new self._GroupPrototype());
        $.get(self._get).done(self.setGroups).fail(self._showError);
        self._strings = $.extend(self._strings, strings);
    };
};
