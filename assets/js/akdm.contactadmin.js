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

akdm.ContactsViewModel = function() {
    var self = this;
    self._get = '/contact/get';
    self._add = '/contact/add';
    self._update = '/contact/update';
    self._delete = '/contact/delete/';
    self._ContactPrototype = akdm.model.Contact;
    self._string = {
        contact_created: 'Contacto creado satisfactoriamente.',
        contact_updated: 'Contacto actualizado satisfactoriamente.',
        contact_deleted: 'Contacto eliminado satisfactoriamente.',
        server_error: 'Error interno del servidor. Detalles: '
    };
    
    self.contacts = ko.observableArray();
    self.filter = ko.observable();
    self.filteredContacts = ko.computed(function() {
        return ko.utils.arrayFilter(self.contacts(), function(contact) {
            return self.filter() === undefined
                    || contact.full_name().toLowerCase()
                           .indexOf(self.filter().toLowerCase()) >= 0;
        });
    });
    self.currentContact = ko.observable();

    self.selectContact = function (contact) {
        self.currentContact(contact);
    };

    self.contactFullName = function (contact) {
        return contact.first_name + ' ' + contact.last_name;
    };

    self.newContact = function () {
        var newContact = new self._ContactPrototype();
        self.currentContact(newContact);
    };

    self.saveContact = function() {
        var contact = self.currentContact();
        if (contact.id())
            // Actualizar
            $.post(self._update, contact.toJSON())
                .done(function () {
                    akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.contact_updated + '</strong>',
                        akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
                })
                .fail(self._showError);
        else {
            // Insertar
            $.post(self._add, contact.toJSON())
                .done(function(newId) {
                    contact.id(newId);
                    self.contacts.push(self.currentContact());
                    akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.contact_created + '</strong>',
                        akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
                })
                .fail(self._showError);
        }
    };

    self.removeContact = function() {
        $.get(self._delete + self.currentContact().id())
            .done(function() {
                self.contacts.remove(self.currentContact());
                self.currentContact(new self._ContactPrototype());
                akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.contact_deleted + '</strong>',
                        akdm.ui.Feedback.INFO, akdm.ui.Feedback.SHORT);
            })
            .fail(self._showError);
    };

    self.activateTab = function (vm, e) {
        e.preventDefault();
        $(e.target).tab('show');
    };
    
    self.setContacts = function (contacts) {
        self.contacts.removeAll();
        $(contacts).each(function (index, contact) {
            self.contacts.push(self._ContactPrototype.fromJSON(contact));
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
        self.currentContact(new self._ContactPrototype());
        $.get(self._get).done(self.setContacts).fail(self._showError);
        self._strings = $.extend(self._strings, strings);
    };
};
