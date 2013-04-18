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
        contact.date_of_birth(akdm.tools.db2LocaleDateStr(contactJSON.date_of_birth || ""));
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
    
    var Teacher = function() {
        Contact.call(this);
        this.contact_id = ko.observable(null);
        this.title = ko.observable(""); 
        this.cv = ko.observable(""); 
        this.type = ko.observable(""); 
        this.start_date = ko.observable(""); 
        this.end_date = ko.observable(""); 
        this.state = ko.observable(""); 
        this.bank_account_format = ko.observable(""); 
        this.bank_account_number = ko.observable(""); 
    };
    
    Teacher.fromJSON = function (teacherJSON) {
        var teacher = new Teacher();
        teacher.id(teacherJSON.id);
        teacher.first_name(teacherJSON.first_name);
        teacher.last_name(teacherJSON.last_name);
        teacher.sex(teacherJSON.sex);
        teacher.email(teacherJSON.email);
        teacher.phone_mobile(teacherJSON.phone_mobile);
        teacher.phone(teacherJSON.phone);
        teacher.picture(teacherJSON.picture);
        teacher.notes(teacherJSON.notes);
        teacher.address(teacherJSON.address);
        teacher.postal_code(teacherJSON.postal_code);
        teacher.town(teacherJSON.town);
        teacher.province(teacherJSON.province);
        teacher.date_of_birth(akdm.tools.db2LocaleDateStr(teacherJSON.date_of_birth || ""));
        teacher.occupation(teacherJSON.occupation);
        teacher.id_card(teacherJSON.id_card);
        
        teacher.contact_id(teacherJSON.contact_id);
        teacher.title(teacherJSON.title); 
        teacher.cv(teacherJSON.cv); 
        teacher.type(teacherJSON.type); 
        teacher.start_date(akdm.tools.db2LocaleDateStr(teacherJSON.start_date || "")); 
        teacher.end_date(akdm.tools.db2LocaleDateStr(teacherJSON.end_date || "")); 
        teacher.state(teacherJSON.state); 
        teacher.bank_account_format(teacherJSON.bank_account_format); 
        teacher.bank_account_number(teacherJSON.bank_account_number);
        return teacher;
    };
    
    Teacher.toJSON = function (teacher) {
        return $.extend(Contact.toJSON(teacher), 
            {
                "contact_id": teacher.contact_id(),
                "title": teacher.title(), 
                "cv": teacher.cv(), 
                "type": teacher.type(), 
                "start_date": akdm.tools.locale2dbDateStr(teacher.start_date()), 
                "end_date": akdm.tools.locale2dbDateStr(teacher.end_date()), 
                "state": teacher.state(), 
                "bank_account_format": teacher.bank_account_format(), 
                "bank_account_number": teacher.bank_account_number()
            });
    };
    
    Teacher.prototype = $.extend(new Contact(), {
        constructor: Teacher,
        toJSON: function () {
            return Teacher.toJSON(this);
        }
    }); 

    return {
        Contact: Contact,
        Teacher: Teacher
    };
})();