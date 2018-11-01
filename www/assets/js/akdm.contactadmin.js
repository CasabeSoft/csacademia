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

ko.bindingHandlers.jqFileUpload = {
    init: function(element, valueAccessor) {
        var pictureDialogId = $(element).data('parent-dialog');
        $(element).fileupload({
            maxFileSize: 2048,
            dataType: 'json',
            done: function(e, data) {
                var value = valueAccessor();
                value().picture(data.result.picture);
                setTimeout(function() {
                    $('#progress .bar').css('width', '0%');
                    $(pictureDialogId).modal('hide');
                }, 1000);
            },
            progressall: function(e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .bar').css('width', progress + '%');
            },
            fail: function(e, data) {
                setTimeout(function() {
                    $('#progress .bar').css('width', '0%');
                    $(pictureDialogId).modal('hide');
                    akdm.ui.Feedback.show('#msgFeedback',
                            // TODO: cambiar literal de cadena por cadena parametrizada.
                            'Es posible que la foto indicada sea demaciado grande o el fichero ya no exista.',
                            akdm.ui.Feedback.ERROR, akdm.ui.Feedback.LONG);
                }, 1000);
            }
        });
    },
    update: function(element, valueAccessor) {
        var contact = ko.utils.unwrapObservable(valueAccessor());
        if (contact) {
            var url = '/picture/upload/contact/' + contact.id();
            $(element).fileupload('option', 'url', url);
        }
    }
};

ko.bindingHandlers.jqValidator = {
    init: function(element) {
        $(element).validate({
            ignore: '',
            highlight: function(element) {
                $(element).closest('div').addClass('error');
            },
            success: function(element) {
                element
                .closest('div').removeClass('error');
            } 
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
    self._strings = {
        contact_created: 'Contacto creado satisfactoriamente.',
        contact_updated: 'Contacto actualizado satisfactoriamente.',
        contact_deleted: 'Contacto eliminado satisfactoriamente.',
        server_error: 'Error interno del servidor. Detalles: ',
        validation_error: 'Algún valor indicado no es correcto. Verifique los datos.'
    };
    var teachers_report = '/teacher/teachers_report/';
    var students_report = '/student/students_report/';
    var contacts_report = '/contact/contacts_report/';
    
    self._filter = { "isActive": true };
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
    
    self.filterByState = function (value, event) {
        self._filter.isActive = value;
        self.loadContacts();
    };
    
    self.uploadUrl = function () { 
        return  '/picture/upload/contact/' + self.currentContact().id();
    };

    self.selectContact = function (contact) {
        self.currentContact(contact);
    };

    self.contactFullName = function (contact) {
        return contact.first_name + ' ' + contact.last_name;
    };

    self.newContact = function () {
        var contact = new self._ContactPrototype();
        self.selectContact(contact);
    };

    self.saveContact = function() {
        if (!$('#frm').valid()) {
            akdm.ui.Feedback.show('#msgFeedback', 
                self._strings.validation_error, 
                akdm.ui.Feedback.ERROR, akdm.ui.Feedback.LONG);
            return;
        }
        
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
        var newContacts = [];
        self.contacts.removeAll();
        $(contacts).each(function (index, contact) {
            newContacts.push(self._ContactPrototype.fromJSON(contact));
        });
        self.contacts(newContacts);
    };

    self._showError = function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.status === 500) {
            akdm.ui.Feedback.show('#msgFeedback', 
                self._strings.server_error + jqXHR.responseText, 
                akdm.ui.Feedback.ERROR);
        }
    };
    
    self.printTeachers = function () {
        var myWindow = window.open(teachers_report + self._filter.isActive, '_blank');
        myWindow.document.title = 'Profesores';
    };
    
    self.printStudents = function () {
        var myWindow = window.open(students_report + self._filter.isActive + '/' + self._filter.group_id, '_blank');
        myWindow.document.title = 'Alumnos';
    };
    
    self.printContacts = function () {
        var myWindow = window.open(contacts_report + self._filter.isActive, '_blank');
        myWindow.document.title = 'Contactos';
    };
    
    self.loadContacts = function () {
        self.newContact();
        $.post(self._get, self._filter).done(self.setContacts).fail(self._showError);
    };
    
    self.init = function (strings) {
        self.currentContact(new self._ContactPrototype());
        self.loadContacts();
        self._strings = $.extend(self._strings, strings);
    };
};
