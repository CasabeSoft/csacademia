<div class="jumbotron subhead">
    <div class="container">
        <img style="float: left" src="../assets/img/logo.png">
        <h1><?php echo lang('page_contact_title'); ?></h1>
        <p class="lead"><?php echo lang('page_contact_title_info'); ?></p>
    </div>
</div>
<div class="container pcontent">
    <div class="row">
        <form class="span5 well"  method="POST" action="/contact">
            <fieldset>
                <?php
                if (isset($error)) {
                    ?>   
                    <div class="alert alert-error">
                        <?php echo $error; ?>            
                    </div>
                    <?php
                }
                ?>
                <?php
                if (isset($message)) {
                    ?>   
                    <div class="alert alert-success">
                        <?php echo $message; ?>
                    </div>
                    <?php
                }
                ?>
                <label><?php echo lang('form_name'); ?></label>
                <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span><input id="name" name="name" type="text" class="span3" placeholder="<?php echo lang('form_full_name'); ?>" value="<?php echo set_value('name'); ?>"></div>
                <span class="alert-error"><?php echo form_error('name'); ?></span>
                <label><?php echo lang('form_email'); ?></label>
                <div class="input-prepend"><span class="add-on"><i class="icon-envelope"></i></span><input id="email" name="email" type="text" class="span3" placeholder="<?php echo lang('form_email_info'); ?>" value="<?php echo set_value('email'); ?>"></div>
                <span class="alert-error"><?php echo form_error('email'); ?></span>
                <label><?php echo lang('form_subject'); ?></label>
                <div class="input-prepend"><span class="add-on"><i class="icon-question-sign"></i></span>
                    <select id="subject" name="subject" class="span3">
                        <option value="" <?php echo set_select('subject', '', TRUE); ?>><?php echo lang('form_contact_subject_select'); ?></option>
                        <option value="information"  <?php echo set_select('subject', 'information'); ?>><?php echo lang('form_contact_subject_information'); ?></option>
                        <option value="suggestions"  <?php echo set_select('subject', 'suggestions'); ?>><?php echo lang('form_contact_subject_suggestions'); ?></option>
                        <option value="report"  <?php echo set_select('subject', 'report'); ?>><?php echo lang('form_contact_subject_report'); ?></option>
                        <option value="other"  <?php echo set_select('subject', 'other'); ?>><?php echo lang('form_contact_subject_other'); ?></option>
                    </select>
                </div>
                <span class="alert-error"><?php echo form_error('subject'); ?></span>
                <label><?php echo lang('form_message'); ?></label>
                <textarea name="message" id="message" class="span5" rows="10"><?php echo set_value('message'); ?></textarea>
                <span class="alert-error"><?php echo form_error('message'); ?></span>
                <label class="checkbox">
                    <input type="checkbox" name="privacy" id="privacy" value="0" <?php echo set_checkbox('privacy', '0'); ?>> <?php echo lang('form_contact_privacy_info'); ?>
                </label>
                <span class="alert-error"><?php echo form_error('privacy'); ?></span>
                <button type="submit" class="btn btn-kprimary"><?php echo lang('btn_send'); ?></button>
            </fieldset>
        </form>
        <div class="span5 pull-right">
            <iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://www.openstreetmap.org/export/embed.html?bbox=-3.7296,40.4023,-3.6752,40.4294&amp;layer=mapquest" style="border: 1px solid black"></iframe><br /><small><a href="http://www.openstreetmap.org/?lat=40.41585&amp;lon=-3.7024&amp;zoom=14&amp;layers=Q">Ver mapa m&#225;s grande</a></small>
        </div>
    </div>
</div>
