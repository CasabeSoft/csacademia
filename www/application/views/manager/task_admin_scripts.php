<script type="text/javascript" src="/node_modules/knockout/build/output/knockout-latest.js"></script>
<script type="text/javascript" src="/assets/lib/jquery/plugins/jquery-validation/1.11.1/jquery.validate.js"></script>
<?php if ($this->lang_code != 'en') { ?>
    <script type="text/javascript" src="/assets/lib/jquery-ui/1.10.2/ui/i18n/jquery.ui.datepicker-<?php echo $this->lang_code ?>.js"></script>
    <script type="text/javascript" src="/assets/lib/jquery/plugins/jquery-validation/1.11.1/localization/messages_<?php echo $this->lang_code ?>.js"></script>
<?php } ?>
<script src="/assets/lib/jquery/plugins/jquery-file-upload/20130521/js/vendor/jquery.ui.widget.js"></script>
<script src="/assets/lib/jquery/plugins/jquery-file-upload/20130521/js/jquery.iframe-transport.js"></script>
<script src="/assets/lib/jquery/plugins/jquery-file-upload/20130521/js/jquery.fileupload.js"></script>
<script src="/assets/lib/jquery/plugins/jquery-timepicker/jquery.timepicker.js"></script>
<!--script src="/assets/lib/jquery/plugins/jquery-timepicker-addon/jquery-ui-timepicker-addon.js"></script>
<script src="/assets/lib/jquery/plugins/jquery-timepicker-addon/jquery-ui-sliderAccess.js"></script-->
<script type="text/javascript" src="/assets/js/akdm.js"></script>
<script type="text/javascript" src="/assets/js/akdm.tools.js"></script>
<script type="text/javascript" src="/assets/js/akdm.ui.js"></script>
<script type="text/javascript" src="/assets/js/akdm.model.js"></script>
<script type="text/javascript" src="/assets/js/akdm.taskadmin.js"></script>
<script>
    $(document).ready(function() {
        akdm.setConfig({
            locale: '<?php echo $this->lang_code ?>',
            localeDateFormat: ($.datepicker.regional['<?php echo $this->lang_code ?>'] || $.datepicker.regional['']).dateFormat
        });

        var tvm = new akdm.TasksViewModel();
        ko.applyBindings(tvm);
        tvm.init({
            task_created: '<?php echo lang('message_created') ?>',
            task_updated: '<?php echo lang('message_updated') ?>',
            task_deleted: '<?php echo lang('message_deleted') ?>',
            server_error: '<?php echo lang('message_server_error_details') ?>',
            validation_error: <?php echo json_encode(lang('message_validation_error')) ?>
        },
<?php echo json_encode($this->current_user) ?>,
<?php echo json_encode($this->tasks_types) ?>,
<?php echo json_encode($this->tasks_importances) ?>,            
<?php echo json_encode($this->tasks_states) ?>,
<?php echo json_encode($this->users) ?>
        );

        /*$('#my_date').change(function() {
         console.log('cambio ' + $(this).val());
         $('#text_date').html($(this).val());
         });*/
        $('#my_time').timepicker({
            hour: 9,
            hourGrid: 4,
            minuteGrid: 10,
            format: 'HH:mm',
            defaultTimezone: '+0100'
        });
    });

</script>
