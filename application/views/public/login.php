<div class="jumbotron subhead">
    <div class="container">
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
            <form class="well"  method="POST" action="admin/main">
                <fieldset>
                    <legend><?php echo lang('menu_login'); ?></legend>
                    <label for="userName"><?php echo lang('form_username'); ?>: </label>
                    <input name="userName" id="userName" placeholder="<?php echo lang('form_username'); ?>" type="text">
                    <label for="password"><?php echo lang('form_password'); ?>: </label>
                    <input name="password" id="password" placeholder="<?php echo lang('form_password'); ?>" type="password">
                    <label class="checkbox">
                        <input type="checkbox"> <?php echo lang('form_remenber'); ?>
                    </label>
                    <button type="submit" class="btn btn-primary"><?php echo lang('btn_enter'); ?></button>
                </fieldset>
            </form>
        </div>
    </div>
</div>