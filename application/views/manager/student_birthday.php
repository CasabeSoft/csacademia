<form id="frm" action="<?php echo site_url('student/birthday_report'); ?>" method="POST" target="_blank">
    <div class="container container-first">
        <div class="title-bar">
            <div id="msgFeedback" class="feedback top">
            </div>
            <h1><?php echo $title; ?></h1>
        </div>
        <div class="row">
            <div class="span4">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">
                        <?php echo lang('subject_select_state'); ?>
                    </legend>
                    <!--label for="lbxState"><?php echo lang('form_state'); ?></label-->
                    <select id="status" name="state" class="input-block-level">
                        <option value="true"><?php echo lang('btn_active'); ?></option>
                        <option value="false"><?php echo lang('btn_inactive'); ?></option>
                    </select>
                </fieldset>
            </div>
            <div class="span4">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">
                        <?php echo lang('subject_select_center'); ?>
                    </legend>
                    <!--label for="lbxCenter"><?php echo lang('form_center'); ?></label-->
                    <select id="center" name="center" class="input-block-level">
                        <option value="0">--</option>
                        <?php foreach ($centers as $center) { ?>
                            <option value="<?php echo $center["id"] ?>">
                                <?php echo $center["name"] ?>
                            </option>
                        <?php } ?>
                    </select>
                </fieldset>
            </div>
            <div class="span4">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">
                        <?php echo lang('subject_select_month'); ?>
                    </legend>
                    <!--label for="lbxMonth"><?php echo lang('form_month'); ?></label-->                    
                    <select id="month" name="month" class="input-block-level">
                        <option value="0">--</option>
                        <option value="1"><?php echo lang('form_january'); ?></option>
                        <option value="2"><?php echo lang('form_february'); ?></option>
                        <option value="3"><?php echo lang('form_march'); ?></option>
                        <option value="4"><?php echo lang('form_april'); ?></option>
                        <option value="5"><?php echo lang('form_may'); ?></option>
                        <option value="6"><?php echo lang('form_june'); ?></option>
                        <option value="7"><?php echo lang('form_july'); ?></option>
                        <option value="8"><?php echo lang('form_august'); ?></option>
                        <option value="9"><?php echo lang('form_september'); ?></option>
                        <option value="10"><?php echo lang('form_october'); ?></option>
                        <option value="11"><?php echo lang('form_november'); ?></option>
                        <option value="12"><?php echo lang('form_december'); ?></option>
                    </select>
                </fieldset>
            </div>
        </div>
        <div class="row">
            <div class="span12"><hr></div>          
            <div class="span5 offset5">
                <button type="submit" class="btn btn-large">
                    <i class="icon-print"></i> <?php echo lang('btn_print'); ?>
                </button>
            </div>
        </div>
        <br>
    </div>
</form>

<style>
      
</style>
