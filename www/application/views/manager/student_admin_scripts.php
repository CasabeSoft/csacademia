<script type="text/javascript" src="/node_modules/knockout/build/output/knockout-latest.js"></script>
<?php if ($this->lang_code != 'en') { ?>
<script type="text/javascript" src="/assets/lib/jquery-ui/1.10.2/ui/i18n/jquery.ui.datepicker-<?php echo $this->lang_code ?>.js"></script>
<?php } ?>
<script type="text/javascript" src="/assets/lib/jquery/plugins/jquery-validation/1.11.1/jquery.validate.js"></script>
<script type="text/javascript" src="/assets/lib/jquery/plugins/jquery-validation/1.11.1/localization/messages_<?php echo $this->lang_code ?>.js"></script>
<script src="/assets/lib/jquery/plugins/jquery-file-upload/20130521/js/vendor/jquery.ui.widget.js"></script>
<script src="/assets/lib/jquery/plugins/jquery-file-upload/20130521/js/jquery.iframe-transport.js"></script>
<script src="/assets/lib/jquery/plugins/jquery-file-upload/20130521/js/jquery.fileupload.js"></script>
<script type="text/javascript" src="/assets/js/akdm.js"></script>
<script type="text/javascript" src="/assets/js/akdm.tools.js"></script>
<script type="text/javascript" src="/assets/js/akdm.ui.js"></script>
<script type="text/javascript" src="/assets/js/akdm.model.js"></script>
<script type="text/javascript" src="/assets/js/akdm.contactadmin.js"></script>
<script type="text/javascript" src="/assets/js/akdm.studentadmin.js"></script>
<script>
    $(document).ready(function () {
        akdm.setConfig({
            locale: '<?php echo $this->lang_code ?>',
            localeDateFormat: ($.datepicker.regional['<?php echo $this->lang_code ?>'] || $.datepicker.regional['']).dateFormat
        });
        
        window.svm = new akdm.StudentViewModel();
        ko.applyBindings(svm);
        svm.init({
            contact_created: '<?php echo lang('message_student_created') ?>',
            contact_updated: '<?php echo lang('message_student_updated') ?>',
            contact_deleted: '<?php echo lang('message_student_deleted') ?>',
            server_error: '<?php echo lang('message_server_error_details') ?>',
            validation_error: <?php echo json_encode(lang('message_validation_error')) ?>,
            qualification_created: '<?php echo lang('message_qualification_created') ?>',
            qualification_updated: '<?php echo lang('message_qualification_updated') ?>',
            qualification_deleted: '<?php echo lang('message_qualification_deleted') ?>',
            payment_created: '<?php echo lang('subject_payment') . lang('message_created') ?>',
            payment_updated: '<?php echo lang('subject_payment') . lang('message_updated') ?>',
            payment_deleted: '<?php echo lang('subject_payment') . lang('message_deleted') ?>',
            payment_type_one_time: '<?php echo lang('form_one_time') ?>',
            family_created: '<?php echo lang('subject_family') . lang('message_created') ?>',
            family_updated: '<?php echo lang('subject_family') . lang('message_updated') ?>',
            family_deleted: '<?php echo lang('subject_family') . lang('message_deleted') ?>',
        }, 
            <?php echo json_encode($this->relationships) ?>,
            <?php echo json_encode($this->payments_types) ?>,
            <?php echo json_encode($this->academicPeriods) ?>,
            <?php echo json_encode($this->levels) ?>,
            <?php echo json_encode($this->groups) ?>,
            <?php echo json_encode($this->payment_periods) ?>
        );
    });
</script>
