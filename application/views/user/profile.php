<br><br><br>
<div class="jumbotron subhead">
    <div class="container">
        <img style="float: left" src="../assets/img/logo.png">
        <h1>CS Academia</h1>
        <p class="lead"><?php echo lang('menu_profile'); ?></p>
    </div>
</div>
<div class="container pcontent">
    <div class="row">
        <div class="span8">
            <h2>...</h2>
            <p>...</p>
        </div>
        <div class="span4">
            <form class="well"  method="POST" action="/profile">
                <fieldset>
                    <legend><?php echo lang('menu_profile'); ?></legend>
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
                    <p>
                        Correo actual: <?php echo $this->session->userdata('email'); ?>
                    </p>
                    <label for="email"><?php echo lang('form_email'); ?>: </label>
                    <input class="span3" name="email" id="email" placeholder="<?php echo lang('form_email'); ?>" type="text" value="<?php echo set_value('email'); ?>">
                    <span style="color: red"><?php echo form_error('email'); ?></span>
                    <button type="submit" class="btn btn-primary"><?php echo lang('btn_enter'); ?></button>
                </fieldset>
            </form>

        </div>
    </div>
</div>