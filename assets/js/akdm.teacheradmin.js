window.akdm = window.akdm || { };

akdm.TeachersViewModel = function() {
    ContactsViewModel.call(this);
    var self = this;
    self.teachers = ko.observableArray();
    self.currentContact = ko.observable(new akdm.model.Teacher());

    self.selectContact = function (contact) {
        self.currentContact(contact);
        //self.currentTeacher()
    };

    function setTeachers(teachers) {
        self.contacts.removeAll();
        $(teachers).each(function (index, teacher) {
            self.contacts.push(akdm.model.Teacher.fromJSON(teacher));
        });
    }

    self.init = function () {
        $.get('/teacher/get').done(setTeachers).fail(self._showError);
    };
};

akdm.TeachersViewModel.prototype = new ContactsViewModel();
akdm.TeachersViewModel.prototype.constructor = akdm.TeachersViewModel;