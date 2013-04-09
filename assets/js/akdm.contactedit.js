ko.bindingHandlers.jqDatepicker = {
    init: function(element) {
       $(element).datepicker();
    }
};

var ContactsViewModel = function() {
    var self = this;
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
                    // Notificar actualización
                    ;
                })
                .fail(showError);
        else {
            // Insertar
            $.post('/contact/add', contact.toJSON())
                .done(function(newId) {
                    contact.id(newId);
                    self.contacts.push(self.currentContact());
                })
                .fail(showError);
        }
    };

    self.removeContact = function() {
        $.get('/contact/delete/' + self.currentContact().id())
            .done(function() {
                self.contacts.remove(self.currentContact());
                self.currentContact(new akdm.model.Contact());
            })
            .fail(showError);
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
            alert('Internal Server Error. Details: ' + jqXHR.responseText);
        }
    }
    
    self.init = function () {
        $.get('/contact/get').done(setContacts).fail(self._showError);
    };
};
