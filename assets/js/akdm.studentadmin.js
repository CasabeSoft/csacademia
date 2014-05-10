/*jslint sloppy: true */
/*jslint nomen: true */
/*jslint browser: true */
/*jslint vars: true */
/*global $ */
/*global ko */

var akdm = window.akdm || {};

akdm.StudentViewModel = function () {
    akdm.ContactsViewModel.call(this);
    var self = this;
    var parent = {
        selectContact: self.selectContact,
        init: self.init
    };
    var family_add = '/student/family_add';
    var family_update = '/student/family_update';
    var family_delete = '/student/family_delete/';
    var family_relate = '/student/family_relate';
    var family_get_available = '/student/family_get_available';
    var payment_add = '/student/payment_add';
    var payment_update = '/student/payment_update';
    var payment_delete = '/student/payment_delete/';
    var payments_report = '/student/payments_report/';
    var payment_report = '/student/payment_report/';
    var qualification_get = '/student/qualification_get/';
    var qualification_update = '/student/qualification_update/';
    var qualification_add = '/student/qualification_add/';
    var qualification_delete = '/student/qualification_delete/';
    var qualifications_report = '/student/qualifications_report/';
    var levelPriceColumns = {1: "price_1", 2: "price_2", 3: "price_3", 4: "price_4", 6: "price_6", 12: "price_12"};
    var empty_group = (new akdm.model.Group()).toJSON();
    var currentQualificationClone;
    self._get = '/student/get';
    self._add = '/student/add';
    self._update = '/student/update';
    self._delete = '/student/delete/';
    self._ContactPrototype = akdm.model.Student;
    self._family_get = '/student/family_get/';
    self._payments_get = '/student/payments_get/';
    self._get_price_by_student = '/student/get_price_by_student/';
    self._filter = $.extend(self._filter, { "group_id": null });
    // self.levelPrice = ko.observable();
    self.paymentList = ko.observableArray();
    self.currentPayment = ko.observable();
    self.currentDate = ko.observable($.datepicker.formatDate(akdm.config.localeDateFormat, new Date()));
    self.relationships = {};
    self.paymentTypes = {};
    self.academicPeriods = {};
    self.levels = {};
    self.groups = {};
    self.paymentPeriods = {};
    self.currentQualifications = ko.observableArray();
    self.currentQualification = ko.observable();
    self.availableFamily = ko.observableArray();
    self.familyList = ko.observableArray();
    self.currentFamily = ko.observable();
    self.payment_type_id = ko.observable();
    self.selectedFamily = ko.computed({
        read: function () { return null; },
        write: function (value) {
            if (value) self.currentFamily(akdm.model.Family.fromJSON(value.toJSON()));
        }
    });
    self.currentStudentGroup = ko.computed({
        read: function () {
            return self.currentContact() && self.groups[self.currentContact().group_id()] 
                    || empty_group;
        }
    });
    self.filterByGroup = ko.computed({
        read: function () {
            return self._filter.group_id;
        },
        write: function (data) {
            self._filter.group_id = data;
            self.loadContacts();
        }
    });
    self.suggestedPeriods = ko.computed({
        read: function () {
            if (! self.payment_type_id()) return;
            
            var index = 0;
            var payment_type_id = Number(self.payment_type_id());
            return self.paymentPeriods[payment_type_id] 
                ? self.paymentPeriods[payment_type_id] 
                : [];
        }
    });
    // TODO: Eliminar. Parece que no se usa en ninguna parte
    /*
    self.selectedPeriod = ko.computed({
        read: function () { 
            return self.currentPayment() 
                ? self.currentPayment().payment_type_id()
                : null; 
            },
        write: function (value) {
            if (!value) return;
            
            self.currentPayment().payment_type_id(value.id);
        }
    });
    */

    self.suggestPaymentPrice = function () {
        if (! self.currentPayment() || ! self.payment_type_id()) return;

        var priceColumn = levelPriceColumns[self.payment_type_id()];
        self.currentPayment().amount(self.levels[self.currentStudentGroup().level_code][priceColumn]);
        self.currentPayment().concept("");
    };

    self.selectPayment = function (payment) {
        self.currentPayment(payment);
        $('#dlgPayments').modal('show');
    };
    
    self.confirmRemovePayment = function (payment) {
        $('#message_show').html('¿Está seguro que desea eliminar el pago de ' + payment.concept() + '?');
        $('#dlgConfirm').modal('show');
    };

    self.newPayment = function () {
        var newPayment = new akdm.model.Payment();
        newPayment.date(self.currentDate());
        self.currentPayment(newPayment);
    };

    self.selectFamily = function (family) {
        self.currentFamily(family);
    };

    self.newFamily = function () {
        var newFamily = new akdm.model.Family();
        self.currentFamily(newFamily);
        self.selectedFamily(null);
    };

    self.saveFamily = function () {
        // TODO: Implementar validación de datos del familiar.
        /*
        if (!$('#frm').valid()) {
            akdm.ui.Feedback.show('#msgFeedback',
                    self._strings.validation_error,
                    akdm.ui.Feedback.ERROR, akdm.ui.Feedback.LONG);
            return;
        }
        */

        var family = self.currentFamily();
        family.student_id(self.currentContact().id());
        if (family.id()) {
            // Actualizar o relacionar
            var family_action = self.familyList().indexOf(family) >= 0
                ? family_update
                : family_relate;
            $.post(family_action, family.toJSON()).done(function () {
                if (family_action === family_relate) {
                    addFamily(family);
                }
                akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.family_updated + '</strong>',
                        akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
            }).fail(self._showError);
        } else {
            // Insertar
            $.post(family_add, family.toJSON()).done(function (newId) {
                family.id(newId);
                addFamily(family);
                akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.family_created + '</strong>',
                        akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
            }).fail(self._showError);
        }
    };

    self.savePayment = function () {
        var payment = self.currentPayment();

        // TODO: Implementar validación de la fecha.
        if (payment.amount() === '' || isNaN(paymen.amount()) 
                || self.payment_type_id() === '' && payment.concept().length === 0 
                || payment.payment_period_id() === '') {
            akdm.ui.Feedback.show('#dlgMsgFeedback',
                    self._strings.validation_error,
                    akdm.ui.Feedback.ERROR, akdm.ui.Feedback.LONG);
            return;
        }

        if (payment.id()) {
            // Actualizar
            $.post(payment_update, payment.toJSON()).done(function () {
                akdm.ui.Feedback.show('#dlgMsgFeedback', '<strong>' + self._strings.payment_updated + '</strong>',
                        akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
            }).fail(self._showError);
        } else {
            // Insertar
            payment.student_id(self.currentContact().id());
            $.post(payment_add, payment.toJSON()).done(function (newId) {
                payment.id(newId);
                //self.paymentList.push(self.currentPayment());
                self.paymentList.splice(0,0,self.currentPayment());
                akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.payment_created + '</strong>',
                        akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
            }).fail(self._showError);
        }
        
        $('#dlgPayments').modal('hide');
    };

    self.removeFamily = function () {
        var family = self.currentFamily();
        $.get(family_delete + family.student_id() + '/' + family.id()).done(function () {
            self.familyList.remove(family);
            self.currentFamily(new akdm.model.Family());
            akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.family_deleted + '</strong>',
                    akdm.ui.Feedback.INFO, akdm.ui.Feedback.SHORT);
        }).fail(self._showError);
    };

    self.removePayment = function() {
        var payment = self.currentPayment();
        // TODO: implementar como confirmar borrado
        //if (confirm("Estas seguro de borrar el pago " + payment.concept()))
        //{
            $.get(payment_delete + payment.id()).done(function() {
                self.paymentList.remove(self.currentPayment());
                self.currentPayment(new akdm.model.Payment());
                akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.payment_deleted + '</strong>',
                        akdm.ui.Feedback.INFO, akdm.ui.Feedback.SHORT);
            }).fail(self._showError);
        //}
    };

    self.printPayments = function () {        
        var myWindow = window.open(payments_report + self.currentContact().id(), '_blank');
        myWindow.document.title = 'Informe de pagos';
    };

    self.printPayment = function (payment) {
        self.currentPayment(payment);
        var myWindow = window.open(payment_report + self.currentPayment().id(), '_blank');
        myWindow.document.title = 'Pago';
    };

    var addFamily = function (family) {
        self.familyList.push(family);
    };

    self.setFamilyList = function (familyList) {
        self.familyList.removeAll();
        $(familyList).each(function (index, family) {
            var newFamily = akdm.model.Family.fromJSON(family);
            addFamily(newFamily);
        });
    };

    self.setPaymentList = function (paymentList) {
        var newPaypmentList = [];
        self.paymentList.removeAll();
        $(paymentList).each(function (index, payment) {
            newPaypmentList.push(akdm.model.Payment.fromJSON(payment));
        });
        self.paymentList(newPaypmentList);
    };

/*
    self.setLevelPrice = function (price) {
        self.levelPrice(price);
    };
*/
    self.setQualifications = function (qualifications) {
        var newQualifications = [];
        self.currentQualifications.removeAll();
        $(qualifications).each(function (index, qualification) {
            newQualifications.push(akdm.model.Qualification.fromJSON(qualification));
        });
        self.currentQualifications(newQualifications);
    };

    self.selectContact = function (contact) {
        parent.selectContact(contact);
        self.currentFamily(new akdm.model.Family());
        self.currentPayment(new akdm.model.Payment());
        $.get(self._family_get + contact.id()).done(self.setFamilyList).fail(self._showError);
        $.get(self._payments_get + contact.id()).done(self.setPaymentList).fail(self._showError);
        // $.get(self._get_price_by_student + contact.id()).done(self.setLevelPrice).fail(self._showError);
        $.get(qualification_get + contact.id()).done(self.setQualifications).fail(self._showError);
    };

    self.newQualification = function () {
        self.currentQualification(new akdm.model.Qualification());
        self.currentQualification().academic_period(self.currentStudentGroup().academic_period);
        self.currentQualification().level_code(self.currentStudentGroup().level_code);
    };

    self.saveQualification = function () {
        var qualification = self.currentQualification();
        if (qualification.student_id()) {
            $.post(qualification_update, qualification.toJSON()).done(function () {
                akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.qualification_updated + '</strong>',
                        akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
            }).fail(self._showError);
        } else {
            // Insertar
            qualification.student_id(self.currentContact().id());
            $.post(qualification_add, qualification.toJSON()).done(function () {
                self.currentQualifications.push(self.currentQualification());
                akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.qualification_created + '</strong>',
                        akdm.ui.Feedback.SUCCESS, akdm.ui.Feedback.SHORT);
            }).fail(self._showError);
        }
    };

    self.removeQualification = function () {
        var qualification = self.currentQualification();
        $.get(qualification_delete + qualification.student_id() + '/' + qualification.academic_period()).done(function () {
            self.currentQualifications.remove(self.currentQualification());
            self.currentQualification(new akdm.model.Qualification());
            akdm.ui.Feedback.show('#msgFeedback', '<strong>' + self._strings.qualification_deleted + '</strong>',
                    akdm.ui.Feedback.INFO, akdm.ui.Feedback.SHORT);
        }).fail(self._showError);
    };

    self.selectQualification = function (qualification) {
        self.currentQualification(qualification);
        currentQualificationClone = $.clone(qualification, true);
        $('#dlgQualification').modal('show');
    };
    
    self.printQualifications = function () {
        var myWindow = window.open(qualifications_report + self.currentContact().id(), '_blank');
        myWindow.document.title = 'Informe de Calificaciones';
    };

    self.setAvailableFamily = function (contacts) {
        var newAvailableFamily = [];
        contacts.sort(function (a, b) {
            return a.first_name + a.last_name <= b.first_name + b.last_name ? -1 : +1;
        });
        $(contacts).each(function (index, contact) {
            var newFamily = akdm.model.Family.fromJSON(contact);
            newFamily.contact_id(contact.id);
            newAvailableFamily.push(newFamily);
        });
        self.availableFamily(newAvailableFamily);
    };

    self.init = function (messages, relationships, paymentTypes, academicPeriods, 
                          levels, groups, paymentPeriods) {
        parent.init(messages);
        self.currentFamily(new akdm.model.Family());
        self.currentPayment(new akdm.model.Payment());
        self.currentQualification(new akdm.model.Qualification());
        $.get(family_get_available).done(self.setAvailableFamily).fail(self._showError);
        $(relationships).each(function (index, relationship) {
            self.relationships[relationship.code] = relationship.name;
        });
        $(paymentTypes).each(function (index, payment) {
            self.paymentTypes[payment.id] = payment.name;
        });
        $(academicPeriods).each(function (index, period) {
            self.academicPeriods[period.code] = period.name;
        });
        $(levels).each(function (index, level) {
            self.levels[level.code] = level;
        });
        $(groups).each(function (index, group) {
            self.groups[group.id] = group;
        });
        $(paymentPeriods).each(function (index, period) {
            if (! self.paymentPeriods[period.period_type])
                self.paymentPeriods[period.period_type] = [];
            self.paymentPeriods[period.period_type].push(period);
        });
    };
};

akdm.StudentViewModel.prototype = new akdm.ContactsViewModel();
akdm.StudentViewModel.prototype.constructor = akdm.StudentViewModel;
