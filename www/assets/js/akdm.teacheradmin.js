var akdm = window.akdm || { };

akdm.TeachersViewModel = function() {
    akdm.ContactsViewModel.call(this);
    var self = this;
    self._get = '/teacher/get';
    self._add = '/teacher/add';
    self._update = '/teacher/update';
    self._delete = '/teacher/delete/';
    self._ContactPrototype = akdm.model.Teacher;    
};

akdm.TeachersViewModel.prototype = new akdm.ContactsViewModel();
akdm.TeachersViewModel.prototype.constructor = akdm.TeachersViewModel;