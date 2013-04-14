ko.bindingHandlers.jqDatepicker = {
    init: function(element) {
       $(element).datepicker();
    }
};

var ContactsViewModel = function(strings) {
    var self = this;
    strings = $.extend( 
        {
            contact_created: 'Contacto creado satisfactoriamente.',
            contact_updated: 'Contacto actualizado satisfactoriamente.',
            contact_deleted: 'Contacto eliminado satisfactoriamente.',
            server_error: 'Error interno del servidor. Detalles: '
        }, strings);
    
    self.contacts = ko.observableArray();
    self.filter = ko.observable();
    self.filteredContacts = ko.computed(function() {
        return ko.utils.arrayFilter(self.contacts(), function(contact) {
            return self.filter() === undefined
                    || contact.full_name().toLowerCase()
                           .indexOf(self.filter().toLowerCase()) >= 0;
        });
    });
    self.currentContact = ko.observable(new akdm.model.Contact());

    self.selectContact = function (contact) {
        self.currentContact(contact);
    };

    self.contactFullName = function (contact) {
        return contact.first_name + ' ' + contact.last_name;
    };

    self.newContact = function () {
        var newContact = new akdm.model.Contact();
        self.currentContact(newContact);
    };

    self.saveContact = function() {
        var contact = self.currentContact();
        if (contact.id())
            // Actualizar
            $.post('/contact/update', contact.toJSON())
                .done(function () {
                    akdm.ui.Feedback.show('#msgFeedback', '<strong>' + strings.contact_updated + '</strong>',
                        akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
                })
                .fail(self._showError);
        else {
            // Insertar
            $.post('/contact/add', contact.toJSON())
                .done(function(newId) {
                    contact.id(newId);
                    self.contacts.push(self.currentContact());
                    akdm.ui.Feedback.show('#msgFeedback', '<strong>' + strings.contact_created + '</strong>',
                        akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
                })
                .fail(self._showError);
        }
    };

    self.removeContact = function() {
        $.get('/contact/delete/' + self.currentContact().id())
            .done(function() {
                self.contacts.remove(self.currentContact());
                self.currentContact(new akdm.model.Contact());
                akdm.ui.Feedback.show('#msgFeedback', '<strong>' + strings.contact_deleted + '</strong>',
                        akdm.ui.Feedback.INFO, akdm.ui.Feedback.SHORT);
            })
            .fail(self._showError);
    };

    self.activateTab = function (vm, e) {
        e.preventDefault();
        $(e.target).tab('show');
    };
    
    function setContacts(contacts) {
        self.contacts.removeAll();
        $(contacts).each(function (index, contact) {
            self.contacts.push(akdm.model.Contact.fromJSON(contact));
        });
    }

    self._showError = function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.status === 500) {
            akdm.ui.Feedback.show('#msgFeedback', 
                strings.server_error + jqXHR.responseText, 
                akdm.ui.Feedback.ERROR, akdm.ui.Feedback.LONG);
        }
    }
    
    self.init = function () {
        $.get('/contact/get').done(setContacts).fail(self._showError);
    };
};
