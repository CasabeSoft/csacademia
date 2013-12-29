/*jslint sloppy: true */
/*jslint nomen: true */
/*jslint browser: true */
/*jslint vars: true */
/*global $ */
/*global ko */

var akdm = window.akdm || {};

akdm.model = (function () {
    var Contact = function () {
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

    Contact.prototype.full_name = function () {
        return (this.first_name() || "") + " " + (this.last_name() || "");
    };
    
    Contact.prototype.full_name_lastname = function () {
        if (this.last_name() === "" && this.first_name() === "") return "";
        return (this.last_name() || "") + ", " + (this.first_name() || "");
    };

    Contact.prototype.toJSON = function () {
        return Contact.toJSON(this);
    };

    Contact.prototype.fromJSON = function (contactJSON) {
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

    Contact.fromJSON = function (contactJSON) {
        return new Contact().fromJSON(contactJSON);
    };

    Contact.toJSON = function (contact) {
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

    var Teacher = function () {
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
        return new Teacher().fromJSON(teacherJSON);
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

    Teacher.prototype = new Contact();
    Teacher.prototype.constructor = Teacher;
    Teacher.prototype.toJSON = function () {
        return Teacher.toJSON(this);
    };
    Teacher.prototype.fromJSON = function (teacherJSON) {
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

    var Student = function () {
        Contact.call(this);
        this.contact_id = ko.observable("");
        this.center_id = ko.observable("");
        this.start_date = ko.observable("");
        this.school_level = ko.observable("");
        this.school_name = ko.observable("");
        this.language_years = ko.observable("");
        this.bank_account_format = ko.observable("");
        this.bank_account_number = ko.observable("");
        this.bank_account_holder = ko.observable("");
        this.bank_payment = ko.observable(false);
        this.leave_reason_code = ko.observable("");
        this.end_date = ko.observable("");
        this.group_id = ko.observable("");
        this.bank_notes = ko.observable("");
    };

    Student.fromJSON = function (studentJSON) {
        return new Student().fromJSON(studentJSON);
    };

    Student.toJSON = function (student) {
        return $.extend(Contact.toJSON(student),
            {
                "contact_id": student.contact_id(),
                "center_id": student.center_id(),
                "start_date": akdm.tools.locale2dbDateStr(student.start_date()),
                "school_level": student.school_level(),
                "school_name": student.school_name(),
                "language_years": student.language_years(),
                "bank_account_format": student.bank_account_format(),
                "bank_account_number": student.bank_account_number(),
                "bank_account_holder": student.bank_account_holder(),
                "bank_payment": student.bank_payment(),
                "leave_reason_code": student.leave_reason_code(),
                "end_date": akdm.tools.locale2dbDateStr(student.end_date()),
                "group_id": student.group_id(),
                "bank_notes": student.bank_notes()
            });
    };

    Student.prototype = new Contact();
    Student.prototype.constructor = Student;
    Student.prototype.fromJSON = function (studentJSON) {
        Contact.prototype.fromJSON.call(this, studentJSON);
        this.contact_id(studentJSON.contact_id);
        this.center_id(studentJSON.center_id);
        this.start_date(akdm.tools.db2LocaleDateStr(studentJSON.start_date || ""));
        this.school_level(studentJSON.school_level);
        this.school_name(studentJSON.school_name);
        this.language_years(studentJSON.language_years);
        this.bank_account_format(studentJSON.bank_account_format);
        this.bank_account_number(studentJSON.bank_account_number);
        this.bank_account_holder(studentJSON.bank_account_holder);
        this.bank_payment(studentJSON.bank_payment);
        this.leave_reason_code(studentJSON.leave_reason_code);
        this.end_date(akdm.tools.db2LocaleDateStr(studentJSON.end_date || ""));
        this.group_id(studentJSON.group_id);
        this.bank_notes(studentJSON.bank_notes);
        return this;
    };
    Student.prototype.toJSON = function () {
        return Student.toJSON(this);
    };

    var Group = function () {
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

    Group.prototype.toJSON = function () {
        return Group.toJSON(this);
    };

    Group.prototype.fromJSON = function (groupJSON) {
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

    Group.fromJSON = function (groupJSON) {
        return new Group().fromJSON(groupJSON);
    };

    Group.toJSON = function (group) {
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

    var Family = function () {
        Contact.call(this);
        this.contact_id = ko.observable(null);
        this.student_id = ko.observable(null);
        this.relationship_code = ko.observable(null);
    };

    Family.fromJSON = function (familyJSON) {
        return new Family().fromJSON(familyJSON);
    };

    Family.toJSON = function (family) {
        return $.extend(Contact.toJSON(family),
            {
                "contact_id": family.contact_id(),
                "student_id": family.student_id(),
                "relationship_code": family.relationship_code()
            });
    };

    Family.prototype = new Contact();
    Family.prototype.constructor = Family;
    Family.prototype.fromJSON = function (familyJSON) {
        Contact.prototype.fromJSON.call(this, familyJSON);
        this.contact_id(familyJSON.contact_id);
        this.student_id(familyJSON.student_id);
        this.relationship_code(familyJSON.relationship_code);
        return this;
    };
    Family.prototype.toJSON = function () {
        return Family.toJSON(this);
    };

    var Students_by_groups = function () {
        this.groups_id = ko.observable("");
        this.student_id = ko.observable("");
    };

    Students_by_groups.prototype.toJSON = function () {
        return Students_by_groups.toJSON(this);
    };

    Students_by_groups.prototype.fromJSON = function (students_by_groupsJSON) {
        this.groups_id(students_by_groupsJSON.groups_id);
        this.student_id(students_by_groupsJSON.student_id);
        return this;
    };

    Students_by_groups.fromJSON = function (students_by_groupsJSON) {
        return new Students_by_groups().fromJSON(students_by_groupsJSON);
    };

    Students_by_groups.toJSON = function (students_by_groups) {
        return {
            "groups_id": students_by_groups.groups_id(),
            "student_id": students_by_groups.student_id()
        };
    };

    var Payment = function () {
        this.id = ko.observable("");
        this.date = ko.observable("");
        this.amount = ko.observable("");
        this.piriod = ko.observable("");
        this.student_id = ko.observable("");       
        this.payment_type_id = ko.observable("");
        this.payment_type_name = ko.observable("");
        this.notes = ko.observable("");
    };

    Payment.prototype.toJSON = function () {
        return Payment.toJSON(this);
    };

    Payment.prototype.fromJSON = function (paymentJSON) {
        this.id(paymentJSON.id);
        this.date(akdm.tools.db2LocaleDateStr(paymentJSON.date || ""));
        this.amount(paymentJSON.amount);
        this.piriod(paymentJSON.piriod);
        this.student_id(paymentJSON.student_id);
        this.payment_type_id(paymentJSON.payment_type_id);
        this.payment_type_name(paymentJSON.payment_type_name);
        this.notes(paymentJSON.notes);
        return this;
    };

    Payment.fromJSON = function (paymentJSON) {
        return new Payment().fromJSON(paymentJSON);
    };

    Payment.toJSON = function (payment) {
        return {
            "id": payment.id(),
            "date": akdm.tools.locale2dbDateStr(payment.date()),
            "amount": payment.amount(),
            "piriod": payment.piriod(),
            "student_id": payment.student_id(),
            "payment_type_id": payment.payment_type_id(),
            "payment_type_name": payment.payment_type_name(),
            "notes": payment.notes()
        };
    };

    var Qualification = function () {
        this.student_id = ko.observable();
        this.academic_period = ko.observable();
        this.description = ko.observable();
        this.qualification = ko.observable();
        this.trinity = ko.observable();
        this.london = ko.observable();
        this.others = ko.observable();
        this.eval1 = ko.observable();
        this.eval2 = ko.observable();
        this.eval3 = ko.observable();
        this.level_code = ko.observable();
    };

    Qualification.prototype.toJSON = function () {
        return Qualification.toJSON(this);
    };

    Qualification.prototype.fromJSON = function (qualificationJSON) {
        this.student_id(qualificationJSON.student_id);
        this.academic_period(qualificationJSON.academic_period);
        this.description(qualificationJSON.description);
        this.qualification(qualificationJSON.qualification);
        this.trinity(qualificationJSON.trinity);
        this.london(qualificationJSON.london);
        this.others(qualificationJSON.others);
        this.eval1(qualificationJSON.eval1);
        this.eval2(qualificationJSON.eval2);
        this.eval3(qualificationJSON.eval3);
        this.level_code(qualificationJSON.level_code);
        return this;
    };

    Qualification.toJSON = function (qualification) {
        return {
            "student_id": qualification.student_id(),
            "academic_period": qualification.academic_period(),
            "description": qualification.description(),
            "qualification": qualification.qualification(),
            "trinity": qualification.trinity(),
            "london": qualification.london(),
            "others": qualification.others(),
            "eval1": qualification.eval1(),
            "eval2": qualification.eval2(),
            "eval3": qualification.eval3(),
            "level_code": qualification.level_code()
        };
    };

    Qualification.fromJSON = function (qualificationJSON) {
        return new Qualification().fromJSON(qualificationJSON);
    };
           
    var Task = function () {
        this.id = ko.observable("");
        this.start_date = ko.observable("");
        this.start_time = ko.observable("");
        this.end_date = ko.observable("");
        this.end_time = ko.observable("");
        this.task = ko.observable("");
        this.description = ko.observable("");       
        this.importance = ko.observable("");
        this.task_type_id = ko.observable("");
        this.task_state_id = ko.observable("");
        this.login_id = ko.observable("");
    };

    Task.prototype.toJSON = function () {
        return Task.toJSON(this);
    };

    Task.prototype.fromJSON = function (taskJSON) {
        this.id(taskJSON.id);
        this.start_date(akdm.tools.db2LocaleDateStr(taskJSON.start_date || ""));
        this.start_time(taskJSON.start_time);
        this.end_date(akdm.tools.db2LocaleDateStr(taskJSON.end_date || ""));
        this.end_time(taskJSON.end_time);
        this.task(taskJSON.task);
        this.description(taskJSON.description);
        this.importance(taskJSON.importance);
        this.task_type_id(taskJSON.task_type_id);
        this.task_state_id(taskJSON.task_state_id);
        this.login_id(taskJSON.login_id);
        return this;
    };

    Task.fromJSON = function (taskJSON) {
        return new Task().fromJSON(taskJSON);
    };

    Task.toJSON = function (task) {
        return {
            "id": task.id(),
            "start_date": akdm.tools.locale2dbDateStr(task.start_date()),
            "start_time": task.start_time(),
            "end_date": akdm.tools.locale2dbDateStr(task.end_date()),
            "end_time": task.end_time(),
            "task": task.task(),
            "description": task.description(),
            "importance": task.importance(),
            "task_type_id": task.task_type_id(),
            "task_state_id": task.task_state_id(),
            "login_id": task.login_id()
        };
    };
                   
    return {
        Contact: Contact,
        Teacher: Teacher,
        Student: Student,
        Group: Group,
        Family: Family,
        Students_by_groups: Students_by_groups,
        Payment: Payment,
        Qualification: Qualification,
        Task: Task
    };
})();
