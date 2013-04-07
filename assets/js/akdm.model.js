window.akdm = window.akdm || {};

akdm.model = (function () {
    var Contact = function() {
        this.id = ko.observable(null);
        this.first_name = ko.observable("");
        this.last_name =  ko.observable("");
        this.sex = ko.observable("");
        this.email = ko.observable("");
        this.phone_mobile = ko.observable("");
        this.phone = ko.observable("");
        this.picture = ko.observable("");
        this.notes = ko.observable("");
        this.address = ko.observable("");
        this.postal_code = ko.observable("");
        this.town = ko.observable("");
        this.province = ko.observable("");
        this.date_of_birth = ko.observable("");
        this.occupation = ko.observable("");
        this.id_card = ko.observable("");
    };
    
    Contact.prototype.full_name = function () {
        return this.first_name() + " " + this.last_name();
    };
    
    Contact.fromJSON = function (contactJSON) {
        var contact = new Contact();
        contact.id(contactJSON.id);
        contact.first_name(contactJSON.first_name);
        contact.last_name(contactJSON.last_name);
        contact.sex(contactJSON.sex);
        contact.email(contactJSON.email);
        contact.phone_mobile(contactJSON.phone_mobile);
        contact.phone(contactJSON.phone);
        contact.picture(contactJSON.picture);
        contact.notes(contactJSON.notes);
        contact.address(contactJSON.address);
        contact.postal_code(contactJSON.postal_code);
        contact.town(contactJSON.town);
        contact.province(contactJSON.province);
        contact.date_of_birth(akdm.tools.db2LocaleDateStr(contactJSON.date_of_birth));
        contact.occupation(contactJSON.occupation);
        contact.id_card(contactJSON.id_card);
        return contact;
    };
    
    Contact.toJSON = function(contact) {
        return {
            "id": contact.id(),
            "first_name": contact.first_name(),
            "last_name": contact.last_name(),
            "sex": contact.sex(),
            "email": contact.email(),
            "phone_mobile": contact.phone_mobile(),
            "phone": contact.phone(),
            "picture": contact.picture(),
            "notes": contact.notes(),
            "address": contact.address(),
            "postal_code": contact.postal_code(),
            "town": contact.town(),
            "province": contact.province(),
            "date_of_birth": akdm.tools.locale2dbDateStr(contact.date_of_birth()),
            "occupation": contact.occupation(),
            "id_card": contact.id_card()
        };
    };
    
    Contact.prototype.toJSON = function () {
        return Contact.toJSON(this);
    }; 
    
    return {
        Contact: Contact
    };
})();