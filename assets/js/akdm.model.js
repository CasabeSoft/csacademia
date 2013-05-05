window.akdm = window.akdm || {};

akdm.model = (function() {
    var Contact = function() {
        this.id = ko.observable(null);
        this.first_name = ko.observable("");
        this.last_name = ko.observable("");
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

    Contact.prototype.full_name = function() {
        return this.first_name() + " " + this.last_name();
    };

    Contact.prototype.toJSON = function() {
        return Contact.toJSON(this);
    };

    Contact.prototype.fromJSON = function(contactJSON) {
        this.id(contactJSON.id);
        this.first_name(contactJSON.first_name);
        this.last_name(contactJSON.last_name);
        this.sex(contactJSON.sex);
        this.email(contactJSON.email);
        this.phone_mobile(contactJSON.phone_mobile);
        this.phone(contactJSON.phone);
        this.picture(contactJSON.picture);
        this.notes(contactJSON.notes);
        this.address(contactJSON.address);
        this.postal_code(contactJSON.postal_code);
        this.town(contactJSON.town);
        this.province(contactJSON.province);
        this.date_of_birth(akdm.tools.db2LocaleDateStr(contactJSON.date_of_birth || ""));
        this.occupation(contactJSON.occupation);
        this.id_card(contactJSON.id_card);
        return this;
    };

    Contact.fromJSON = function(contactJSON) {
        return new Contact().fromJSON(contactJSON);
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

    Teacher.fromJSON = function(teacherJSON) {
        return new Teacher().fromJSON(teacherJSON);
    };

    Teacher.toJSON = function(teacher) {
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

    Teacher.prototype = new Contact();
    Teacher.prototype.constructor = Teacher;
    Teacher.prototype.toJSON = function() {
        return Teacher.toJSON(this);
    };
    Teacher.prototype.fromJSON = function(teacherJSON) {
        Contact.prototype.fromJSON.call(this, teacherJSON);
        this.contact_id(teacherJSON.contact_id);
        this.title(teacherJSON.title);
        this.cv(teacherJSON.cv);
        this.type(teacherJSON.type);
        this.start_date(akdm.tools.db2LocaleDateStr(teacherJSON.start_date || ""));
        this.end_date(akdm.tools.db2LocaleDateStr(teacherJSON.end_date || ""));
        this.state(teacherJSON.state);
        this.bank_account_format(teacherJSON.bank_account_format);
        this.bank_account_number(teacherJSON.bank_account_number);
        return this;
    };

    var Student = function() {
        Contact.call(this);
        this.contact_id = ko.observable("");
        this.center_id = ko.observable("");
        this.start_date = ko.observable("");
        this.school_academic_period = ko.observable("");
        this.school_name = ko.observable("");
        this.language_years = ko.observable("");
        this.pref_start_time = ko.observable("");
        this.pref_end_time = ko.observable("");
        this.current_academic_period = ko.observable("");
        this.bank_account_format = ko.observable("");
        this.bank_account_number = ko.observable("");
        this.bank_account_holder = ko.observable("");
        this.bank_payment = ko.observable(false);
        this.current_level_code = ko.observable("");
        this.leave_reason_code = ko.observable("");
        this.end_date = ko.observable("");
    };

    Student.fromJSON = function(studentJSON) {
        return new Student().fromJSON(studentJSON);
    };

    Student.toJSON = function(student) {
        return $.extend(Contact.toJSON(student),
                {
                    "contact_id": student.contact_id(),
                    "center_id": student.center_id(),
                    "start_date": akdm.tools.locale2dbDateStr(student.start_date()),
                    "school_academic_period": student.school_academic_period(),
                    "school_name": student.school_name(),
                    "language_years": student.language_years(),
                    "pref_start_time": student.pref_start_time(),
                    "pref_end_time": student.pref_end_time(),
                    "current_academic_period": student.current_academic_period(),
                    "bank_account_format": student.bank_account_format(),
                    "bank_account_number": student.bank_account_number(),
                    "bank_account_holder": student.bank_account_holder(),
                    "bank_payment": student.bank_payment(),
                    "current_level_code": student.current_level_code(),
                    "leave_reason_code": student.leave_reason_code(),
                    "end_date": akdm.tools.locale2dbDateStr(student.end_date())
                });
    };

    Student.prototype = new Contact();
    Student.prototype.constructor = Student;
    Student.prototype.fromJSON = function(studentJSON) {
        Contact.prototype.fromJSON.call(this, studentJSON);
        this.contact_id(studentJSON.contact_id);
        this.center_id(studentJSON.center_id);
        this.start_date(akdm.tools.db2LocaleDateStr(studentJSON.start_date || ""));
        this.school_academic_period(studentJSON.school_academic_period);
        this.school_name(studentJSON.school_name);
        this.language_years(studentJSON.language_years);
        this.pref_start_time(studentJSON.pref_start_time);
        this.pref_end_time(studentJSON.pref_end_time);
        this.current_academic_period(studentJSON.current_academic_period);
        this.bank_account_format(studentJSON.bank_account_format);
        this.bank_account_number(studentJSON.bank_account_number);
        this.bank_account_holder(studentJSON.bank_account_holder);
        this.bank_payment(studentJSON.bank_payment);
        this.current_level_code(studentJSON.current_level_code);
        this.leave_reason_code(studentJSON.leave_reason_code);
        this.end_date(akdm.tools.db2LocaleDateStr(studentJSON.end_date || ""));
        return this;
    };
    Student.prototype.toJSON = function() {
        return Student.toJSON(this);
    };

    var Group = function() {
        this.id = ko.observable("");
        this.name = ko.observable("");
        this.center_id = ko.observable("");
        this.classroom_id = ko.observable("");
        this.teacher_id = ko.observable("");
        this.level_code = ko.observable("");
        this.academic_period = ko.observable("");
        this.monday = ko.observable("");
        this.tuesday = ko.observable("");
        this.wednesday = ko.observable("");
        this.thursday = ko.observable("");
        this.friday = ko.observable("");
        this.saturday = ko.observable("");
        this.start_time = ko.observable("");
        this.end_time = ko.observable("");
    };

    Group.prototype.toJSON = function() {
        return Group.toJSON(this);
    };

    Group.prototype.fromJSON = function(groupJSON) {
        this.id(groupJSON.id);
        this.name(groupJSON.name);
        this.center_id(groupJSON.center_id);
        this.classroom_id(groupJSON.classroom_id);
        this.teacher_id(groupJSON.teacher_id);
        this.level_code(groupJSON.level_code);
        this.academic_period(groupJSON.academic_period);
        this.monday(groupJSON.monday);
        this.tuesday(groupJSON.tuesday);
        this.wednesday(groupJSON.wednesday);
        this.thursday(groupJSON.thursday);
        this.friday(groupJSON.friday);
        this.saturday(groupJSON.saturday);
        this.start_time(groupJSON.start_time);
        this.end_time(groupJSON.end_time);
        return this;
    };

    Group.fromJSON = function(groupJSON) {
        return new Group().fromJSON(groupJSON);
    };

    Group.toJSON = function(group) {
        return {
            "id": group.id(),
            "name": group.name(),
            "center_id": group.center_id(),
            "classroom_id": group.classroom_id(),
            "teacher_id": group.teacher_id(),
            "level_code": group.level_code(),
            "academic_period": group.academic_period(),
            "monday": group.monday(),
            "tuesday": group.tuesday(),
            "wednesday": group.wednesday(),
            "thursday": group.thursday(),
            "friday": group.friday(),
            "saturday": group.saturday(),
            "start_time": group.start_time(),
            "end_time": group.end_time()
        };
    };

    return {
        Contact: Contact,
        Teacher: Teacher,
        Student: Student,
        Group: Group
    };
})();