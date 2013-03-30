<div class="jumbotron subhead">
    <div class="container">
        <img style="float: left" src="../assets/img/logo.png">
        <h1>Acceder a CS Academia</h1>
        <p class="lead">Accede y obtén la información que buscas, gestiona datos y mucho más...</p>
    </div>
</div>
<div class="container pcontent">
    <div class="row">
        <div class="span8">
            <h2>Si ya tienes una cuenta de usuario podrás...</h2>
            <p>Si tienes una cuenta accede al sistema, si no... ¡solicítanosla!</p>
        </div>
        <div class="span4">
            <form class="well"  method="POST" action="/login">
                <fieldset>
                    <legend><?php echo lang('menu_login'); ?></legend>
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
                    <label for="userName"><?php echo lang('form_username'); ?>: </label>
                    <input class="span3" name="userName" id="userName" placeholder="<?php echo lang('form_username'); ?>" type="text" value="<?php echo set_value('userName'); ?>">
                    <span style="color: red"><?php echo form_error('userName'); ?></span>
                    <label for="password"><?php echo lang('form_password'); ?>: </label>
                    <input class="span3" name="password" id="password" placeholder="<?php echo lang('form_password'); ?>" type="password">
                    <span style="color: red"><?php echo form_error('password'); ?></span>
                    <label class="checkbox">
                        <input type="checkbox"> <?php echo lang('form_remenber'); ?>
                    </label>
                    <button type="submit" class="btn btn-primary"><?php echo lang('btn_enter'); ?></button>
                </fieldset>
            </form>

        </div>
    </div>
</div>