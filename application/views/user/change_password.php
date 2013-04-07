<div class="container container-first">
    <div class="row">
        <div class="span8">
            <h2><?php echo lang('page_change_password_content'); ?></h2>
            <p><?php echo lang('page_change_password_content_info'); ?></p>
        </div>
        <div class="span4">
            <form class="well form-first" method="POST" action="/change_password">
                <fieldset>
                    <legend><?php echo lang('menu_change_password'); ?></legend>
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
                    <label for="current_password"><?php echo lang('form_current_password'); ?>: </label>
                    <input class="span3" name="current_password" id="current_password" placeholder="<?php echo lang('form_current_password'); ?>" type="password" value="">
                    <span class="alert-error"><?php echo form_error('current_password'); ?></span>
                    <label for="new_password"><?php echo lang('form_new_password'); ?>: </label>
                    <input class="span3" name="new_password" id="new_password" placeholder="<?php echo lang('form_new_password'); ?>" type="password" value="">
                    <span class="alert-error"><?php echo form_error('new_password'); ?></span>
                    <label for="confirm_password"><?php echo lang('form_confirm_password'); ?>: </label>
                    <input class="span3" name="confirm_password" id="confirm_password" placeholder="<?php echo lang('form_confirm_password'); ?>" type="password" value="">
                    <span class="alert-error"><?php echo form_error('confirm_password'); ?></span>
                    <button type="submit" class="btn btn-primary"><?php echo lang('btn_enter'); ?></button>
                </fieldset>
            </form>
        </div>
    </div>
</div>