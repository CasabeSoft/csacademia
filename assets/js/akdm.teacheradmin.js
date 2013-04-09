var TeachersViewModel = function() {
    ContactsViewModel.call(this);
    var self = this;
    self.teachers = ko.observableArray();
    self.currentTeacher = ko.observable(new akdm.model.Teacher());

    self.selectContact = function (contact) {
        self.currentContact(contact);
        //self.currentTeacher()
    };

    function setTeachers(teachers) {
        self.contacts.removeAll();
        $(teachers).each(function (index, teacher) {
            self.contacts.push(akdm.model.Contact.fromJSON(teacher));
        });
    }

    self.init = function () {
        $.get('/teacher/get').done(setTeachers).fail(self._showError);
    };
};

TeachersViewModel.prototype = new ContactsViewModel();
TeachersViewModel.prototype.constructor = TeachersViewModel;