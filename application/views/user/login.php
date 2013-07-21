<div class="jumbotron subhead">
    <div class="container text-center">
        <img src="/assets/img/logo.png" class="logo">
        <h1><?php echo lang('page_login_title'); ?></h1>
        <p class="lead"><?php echo lang('page_login_title_info'); ?></p>
    </div>
</div>
<div class="container pcontent">
    <div class="row">
        <div class="span8">
            <h2><?php echo lang('page_login_content'); ?></h2>
            <p><?php echo lang('page_login_content_info'); ?></p>
        </div>
        <div class="span4">
            <form class="well"  method="POST" action="/login">
                <fieldset>
                    <legend><?php echo lang('menu_login'); ?></legend>
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
                    <label for="userName"><?php echo lang('form_username'); ?>: </label>
                    <input class="span3" name="userName" id="userName" placeholder="<?php echo lang('form_username'); ?>" type="text" value="<?php echo set_value('userName'); ?>">
                    <span class="alert-error"><?php echo form_error('userName'); ?></span>
                    <label for="password"><?php echo lang('form_password'); ?>: </label>
                    <input class="span3" name="password" id="password" placeholder="<?php echo lang('form_password'); ?>" type="password">
                    <span class="alert-error"><?php echo form_error('password'); ?></span>
                    <label class="checkbox">
                        <input type="checkbox"> <?php echo lang('form_remenber'); ?>
                    </label>
                    <button type="submit" class="btn btn-primary"><?php echo lang('btn_enter'); ?></button>
                </fieldset>
            </form>
        </div>
    </div>
</div>
