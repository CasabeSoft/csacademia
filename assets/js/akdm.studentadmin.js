var akdm = window.akdm || { };

akdm.StudentViewModel = function() {
    akdm.ContactsViewModel.call(this);
    var self = this;
    self._get = '/student/get';
    self._add = '/student/add';
    self._update = '/student/update';
    self._delete = '/student/delete/';
    self._ContactPrototype = akdm.model.Student;
};

akdm.StudentViewModel.prototype = new akdm.ContactsViewModel();
akdm.StudentViewModel.prototype.constructor = akdm.StudentViewModel;