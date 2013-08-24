<script type="text/javascript" src="/assets/lib/knockout/knockout-2.2.1.js"></script>
<script type="text/javascript" src="/assets/lib/jquery/plugins/jquery-validation/1.11.1/jquery.validate.js"></script>
<?php if ($this->lang_code != 'en') { ?>
<script type="text/javascript" src="/assets/lib/jquery-ui/1.10.2/ui/i18n/jquery.ui.datepicker-<?php echo $this->lang_code ?>.js"></script>
<script type="text/javascript" src="/assets/lib/jquery/plugins/jquery-validation/1.11.1/localization/messages_<?php echo $this->lang_code ?>.js"></script>
<?php } ?>
<script type="text/javascript" src="/assets/lib/datejs/2007-11-19/date.js"></script>
<script type="text/javascript" src="/assets/js/akdm.js"></script>
<script type="text/javascript" src="/assets/js/akdm.tools.js"></script>
<script type="text/javascript" src="/assets/js/akdm.ui.js"></script>
<script type="text/javascript" src="/assets/js/akdm.model.js"></script>
<script type="text/javascript" src="/assets/js/akdm.groupadmin.js"></script>
<script>
    $(document).ready(function() {
        akdm.setConfig({
            locale: '<?php echo $this->lang_code ?>',
            localeDateFormat: ($.datepicker.regional['<?php echo $this->lang_code ?>'] || $.datepicker.regional['']).dateFormat
        });

        window.gvm = new akdm.GroupsViewModel();
        ko.applyBindings(gvm);
        gvm.init({
            group_created: '<?php echo lang('subject_group') . lang('message_created') ?>',
            group_updated: '<?php echo lang('subject_group') . lang('message_updated') ?>',
            group_deleted: '<?php echo lang('subject_group') . lang('message_deleted') ?>',
            server_error: '<?php echo lang('message_server_error_details') ?>',
            validation_error: <?php echo json_encode(lang('message_validation_error')) ?>,
            day_short_names: '<?php echo lang('day_short_names') ?>',
            student_created: '<?php echo lang('subject_student') . lang('message_created') ?>',
            student_updated: '<?php echo lang('subject_student') . lang('message_updated') ?>',
            student_deleted: '<?php echo lang('subject_student') . lang('message_deleted') ?>'
        }, <?php echo json_encode($this->classrooms) ?>);
    });
</script>