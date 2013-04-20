<script type="text/javascript" src="/assets/lib/knockout/knockout-2.2.1.js"></script>
<script type="text/javascript" src="/assets/lib/jquery-ui/1.10.2/ui/jquery-ui.js"></script>
<?php if ($this->lang_code != 'en') { ?>
<script type="text/javascript" src="/assets/lib/jquery-ui/1.10.2/ui/i18n/jquery.ui.datepicker-<?php echo $this->lang_code ?>.js"></script>
<?php } ?>
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
            contact_created: '<?php echo lang('message_teacher_created') ?>',
            contact_updated: '<?php echo lang('message_teacher_updated') ?>',
            contact_deleted: '<?php echo lang('message_teacher_deleted') ?>',
            server_error: '<?php echo lang('message_server_error_details') ?>'
        });
    });
</script>
