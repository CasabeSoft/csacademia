(function() {
    var ContactsViewModel = function() {
        var self = this;
        self.contacts = ko.observableArray();
        self.filter = ko.observable();
        self.filteredContacts = ko.computed(function() {
            return ko.utils.arrayFilter(self.contacts(), function(contact) {
                return self.filter() === undefined
                        || self.contactFullName(contact).toLowerCase()
                               .indexOf(self.filter().toLowerCase()) >= 0;
            });
        });
        self.currentContact = ko.observable(new akdm.model.Contact());
        
        self.selectContact = function(contact) {
            self.currentContact(contact);
        };
        
        self.contactFullName = function (contact) {
            return contact.first_name + ' ' + contact.last_name;
        };

        $.get('/contact/lst', self.contacts);
    };
    ko.applyBindings(new ContactsViewModel());
})();


