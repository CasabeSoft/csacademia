<div class="container container-first">
    <div class="row">
        <div class="span8">
            <h2><?php echo lang('page_profile_content'); ?></h2>
            <p><?php echo lang('page_profile_content_info'); ?></p>
        </div>
        <div class="span4">
            <form class="well form-first" method="POST" action="/profile">
                <fieldset>
                    <legend><?php echo lang('menu_profile'); ?></legend>
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
                    <p>
                        Correo actual: <?php echo $this->session->userdata('email'); ?>
                    </p>
                    <label for="email"><?php echo lang('form_email'); ?>: </label>
                    <input class="span3" name="email" id="email" placeholder="<?php echo lang('form_email'); ?>" type="text" value="<?php echo set_value('email'); ?>">
                    <span class="alert-error"><?php echo form_error('email'); ?></span>
                    <button type="submit" class="btn btn-primary"><?php echo lang('btn_enter'); ?></button>
                </fieldset>
            </form>
        </div>
    </div>
</div>