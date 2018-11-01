<form id="frm" action="<?php echo site_url('student/payments_bank_report'); ?>" method="POST" target="_blank">
    <div class="container container-first">
        <div class="title-bar">
            <div id="msgFeedback" class="feedback top">
            </div>
            <h1><?php echo $title; ?></h1>
        </div>
        <div class="row">            
            <div class="span3">
            </div>
            <div class="span6">
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
