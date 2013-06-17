var akdm = window.akdm || { };

akdm.StudentViewModel = function() {
    akdm.ContactsViewModel.call(this);
    var self = this;
    self._get = '/student/get';
    self._add = '/student/add';
    self._update = '/student/update';
    self._delete = '/student/delete/';
    self._ContactPrototype = akdm.model.Student;
    self._family_get = '/student/family_get/';
    var family_add = '/student/family_add';
    var family_update = '/student/family_update';
    var family_delete = '/student/family_delete/';
    
    self._payments_get = '/student/payments_get/';
    
    self.paymentList = ko.observableArray();
    self.currentPayment = ko.observable();
    
    self.selectPayment = function (payment) {
        self.currentPayment(payment);
    };
    
    self.newPayment = function () {
        var newPayment = new akdm.model.Payment();
        self.currentPayment(newPayment);
    };
    
    
    self.familyList = ko.observableArray();
    self.currentFamily = ko.observable();
    
    self.selectFamily = function (family) {
        self.currentFamily(family);
    };
    
    self.newFamily = function () {
        var newFamily = new akdm.model.Family();
        self.currentFamily(newFamily);
    };
    
    self.saveFamily = function() {
        // TODO: Implementar validación de datos del familiar.
        if (false || !$('#frm').valid()) {
            akdm.ui.Feedback.show('#msgFeedback', 
                self._strings.validation_error, 
                akdm.ui.Feedback.ERROR, akdm.ui.Feedback.LONG);
            return;
        }
        
        var family = self.currentFamily();
        if (family.id())
            // Actualizar
            $.post(family_update, family.toJSON())
                .done(function () {
                    akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.contact_updated + '</strong>',
                        akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
                })
                .fail(self._showError);
        else {
            // Insertar
            family.student_id(self.currentContact().id());
            $.post(family_add, family.toJSON())
                .done(function(newId) {
                    family.id(newId);
                    self.familyList.push(self.currentFamily());
                    akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.contact_created + '</strong>',
                        akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
                })
                .fail(self._showError);
        }
    };
    
    self.removeFamily = function() {
        var family = self.currentFamily();
        $.get(family_delete + family.student_id() + '/' + family.id())
            .done(function() {
                self.familyList.remove(self.currentFamily());
                self.currentFamily(new akdm.model.Family());
                akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.contact_deleted + '</strong>',
                        akdm.ui.Feedback.INFO, akdm.ui.Feedback.SHORT);
            })
            .fail(self._showError);
    };
    
    self.setFamilyList = function (familyList) {
        self.familyList.removeAll();
        $(familyList).each(function (index, family) {
            self.familyList.push(akdm.model.Family.fromJSON(family));
        });
    };
    
    self.setPaymentList = function (paymentList) {
        self.paymentList.removeAll();
        $(paymentList).each(function (index, payment) {
            self.paymentList.push(akdm.model.Payment.fromJSON(payment));
        });
    };

        
    var parent = {
        selectContact: self.selectContact,
        init: self.init
    };
    
    self.selectContact = function (contact) {
        parent.selectContact(contact);
        self.currentFamily(new akdm.model.Family());
        $.get(self._family_get + contact.id()).done(self.setFamilyList).fail(self._showError);
        self.currentPayment(new akdm.model.Payment());
        $.get(self._payments_get + contact.id()).done(self.setPaymentList).fail(self._showError);
    };    
    
    self.init = function (strings) {
        parent.init(this, strings);
        self.currentFamily(new akdm.model.Family());
        self.currentPayment(new akdm.model.Payment());
    };
};

akdm.StudentViewModel.prototype = new akdm.ContactsViewModel();
akdm.StudentViewModel.prototype.constructor = akdm.StudentViewModel;