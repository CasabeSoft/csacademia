<br><br><br>
<div class="jumbotron subhead">
    <div class="container">
        <img style="float: left" src="../assets/img/logo.png">
        <h1>CS Academia</h1>
        <p class="lead"><?php echo lang('menu_change_password'); ?></p>
    </div>
</div>
<div class="container pcontent">
    <div class="row">
        <div class="span8">
            <h2>...</h2>
            <p>...</p>
        </div>
        <div class="span4">
            <form class="well"  method="POST" action="/change_password">
                <fieldset>
                    <legend><?php echo lang('menu_change_password'); ?></legend>
                    <?php
                    if (isset($error)) {
                        ?>   
                        <p style="color: red">
                            <?php echo $error; ?>            
                        </p>
                        <?php
                    }
                    ?>
                    <?php
                    if (isset($message)) {
                        ?>   
                        <p style="color: green">
                            <?php echo $message; ?>
                        </p>
                        <?php
                    }
                    ?>
                    <label for="current_password"><?php echo lang('form_current_password'); ?>: </label>
                    <input class="span3" name="current_password" id="old_password" placeholder="<?php echo lang('form_current_password'); ?>" type="password" value="">
                    <span style="color: red"><?php echo form_error('current_password'); ?></span>
                    <label for="new_password"><?php echo lang('form_new_password'); ?>: </label>
                    <input class="span3" name="new_password" id="new_password" placeholder="<?php echo lang('form_new_password'); ?>" type="password" value="">
                    <span style="color: red"><?php echo form_error('new_password'); ?></span>
                    <label for="confirm_password"><?php echo lang('form_confirm_password'); ?>: </label>
                    <input class="span3" name="confirm_password" id="confirm_password" placeholder="<?php echo lang('form_confirm_password'); ?>" type="password" value="">
                    <span style="color: red"><?php echo form_error('confirm_password'); ?></span>
                    <button type="submit" class="btn btn-primary"><?php echo lang('btn_enter'); ?></button>
                </fieldset>
            </form>

        </div>
    </div>
</div>