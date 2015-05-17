<section class="cs-login">
    <article class="container">
        <header class="row">
            <div class="col-xs-6">
                <a href="/"><img src="/assets/img/logo_text_sm.png" alt="CSAcademia logo"></a>
            </div>
        </header>
        <div class="row">
            <div class="col-md-4">
                <form class="well"  method="POST" action="/login">
                    <fieldset>
                        <legend><?php echo lang('menu_login'); ?></legend>
                        <?php
                        if (isset($error)) {
                            ?>   
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error; ?>            
                            </div>
                            <?php
                        }
                        ?>
                        <?php
                        if (isset($message)) {
                            ?>   
                            <div class="alert alert-success" role="alert">
                                <?php echo $message; ?>
                            </div>
                            <?php
                        }
                        ?>
                        <label for="userName"><?php echo lang('form_username'); ?>: </label>
                        <input class="form-control" name="userName" id="userName" placeholder="<?php echo lang('form_username'); ?>" type="text" value="<?php echo set_value('userName'); ?>">
                        <span class="text-danger"><?php echo form_error('userName'); ?></span>
                        <label for="password"><?php echo lang('form_password'); ?>: </label>
                        <input class="form-control" name="password" id="password" placeholder="<?php echo lang('form_password'); ?>" type="password">
                        <span class="text-danger"><?php echo form_error('password'); ?></span>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"> <?php echo lang('form_remenber'); ?>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary"><?php echo lang('btn_enter'); ?></button>
                    </fieldset>
                </form>
            </div>
        </div>
    </article>
</section>
