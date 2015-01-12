<?php
$actual_month = date("m");
$actual_year = date("Y");
?>
<form id="frm" action="<?php echo site_url('student/payments_general_report'); ?>" method="POST" target="_blank">
    <div class="container container-first">
        <div class="title-bar">
            <div id="msgFeedback" class="feedback top">
            </div>
            <h1><?php echo $title; ?></h1>
        </div>
        <div class="row">            
            <div class="span3">
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
            <!--div class="span2">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">
            <?php echo lang('subject_select_type'); ?>
                    </legend>
                    <!--label for="lbxRelationship"><?php echo lang('subject_payment_type'); ?></label-->
            <!--select id="lbxRelationship" name="payment_type" class="input-block-level" data-bind="value: payment_type_id">
                <option value="0">--</option>
            <?php foreach ($payments_types as $payment_type) { ?>
                            <option value="<?php echo $payment_type["id"] ?>"><?php echo $payment_type["name"] ?></option>
            <?php } ?>
            </select>
            </fieldset>
            </div-->
            <!--div class="span3">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">
            <?php echo lang('subject_select_piriod'); ?>
                    </legend>
                    <!--label for="lbxMonth"><?php echo lang('form_month'); ?></label-->                    
            <!--select id="month" name="month" class="input-block-level">
                <option value="0">--</option>
            <?php foreach ($periods_used as $period) { ?>
                            <option value="<?php echo $period["payment_period_id"] ?>"><?php echo $period["payment_period_name"] ?></option>
            <?php } ?>
            </select>
            </fieldset>
            </div-->
            <div class="span2">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">
                        <?php echo lang('subject_select_month'); ?>
                    </legend>
                    <!--label for="lbxMonth"><?php echo lang('form_month'); ?></label-->                    
                    <select id="month" name="month" class="input-block-level">
                        <!--option value="0">--</option-->
                        <option value="01" <?php echo $actual_month == '01' ? 'selected' : ''; ?>><?php echo lang('form_january'); ?></option>
                        <option value="02" <?php echo $actual_month == '02' ? 'selected' : ''; ?>><?php echo lang('form_february'); ?></option>
                        <option value="03" <?php echo $actual_month == '03' ? 'selected' : ''; ?>><?php echo lang('form_march'); ?></option>
                        <option value="04" <?php echo $actual_month == '04' ? 'selected' : ''; ?>><?php echo lang('form_april'); ?></option>
                        <option value="05" <?php echo $actual_month == '05' ? 'selected' : ''; ?>><?php echo lang('form_may'); ?></option>
                        <option value="06" <?php echo $actual_month == '06' ? 'selected' : ''; ?>><?php echo lang('form_june'); ?></option>
                        <option value="07" <?php echo $actual_month == '07' ? 'selected' : ''; ?>><?php echo lang('form_july'); ?></option>
                        <option value="08" <?php echo $actual_month == '08' ? 'selected' : ''; ?>><?php echo lang('form_august'); ?></option>
                        <option value="09" <?php echo $actual_month == '09' ? 'selected' : ''; ?>><?php echo lang('form_september'); ?></option>
                        <option value="10" <?php echo $actual_month == '10' ? 'selected' : ''; ?>><?php echo lang('form_october'); ?></option>
                        <option value="11" <?php echo $actual_month == '11' ? 'selected' : ''; ?>><?php echo lang('form_november'); ?></option>
                        <option value="12" <?php echo $actual_month == '12' ? 'selected' : ''; ?>><?php echo lang('form_december'); ?></option>
                    </select>
                </fieldset>
            </div>        
            <div class="span2">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">
                        <?php echo lang('subject_select_year'); ?>
                    </legend>
                    <!--label for="lbxMonth"><?php echo lang('form_year'); ?></label-->                    
                    <select id="month" name="year" class="input-block-level">
                        <!--option value="0">--</option-->
                        <option value="2008" <?php echo $actual_year == '2008' ? 'selected' : ''; ?>>2008</option>
                        <option value="2009" <?php echo $actual_year == '2009' ? 'selected' : ''; ?>>2009</option>
                        <option value="2010" <?php echo $actual_year == '2010' ? 'selected' : ''; ?>>2010</option>
                        <option value="2011" <?php echo $actual_year == '2011' ? 'selected' : ''; ?>>2011</option>
                        <option value="2012" <?php echo $actual_year == '2012' ? 'selected' : ''; ?>>2012</option>
                        <option value="2013" <?php echo $actual_year == '2013' ? 'selected' : ''; ?>>2013</option>
                        <option value="2014" <?php echo $actual_year == '2014' ? 'selected' : ''; ?>>2014</option>
                        <option value="2015" <?php echo $actual_year == '2015' ? 'selected' : ''; ?>>2015</option>
                        <option value="2016" <?php echo $actual_year == '2016' ? 'selected' : ''; ?>>2016</option>
                        <option value="2017" <?php echo $actual_year == '2017' ? 'selected' : ''; ?>>2017</option>
                        <option value="2018" <?php echo $actual_year == '2018' ? 'selected' : ''; ?>>2018</option>
                        <option value="2019" <?php echo $actual_year == '2019' ? 'selected' : ''; ?>>2019</option>
                    </select>
                </fieldset>
            </div>
            <div class="span2">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">
                        <?php echo lang('subject_select_state'); ?>
                    </legend>
                    <!--label for="lbxState"><?php echo lang('form_state'); ?></label-->
                    <select id="status" name="state" class="input-block-level">
                        <option value="0">--</option>
                        <option value="1"><?php echo lang('btn_paid'); ?></option>
                        <option value="2"><?php echo lang('btn_unpaid'); ?></option>
                    </select>
                </fieldset>
            </div>
            <div class="span3">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">
                        <?php echo lang('form_bank_payment'); ?>
                    </legend>
                    <!--label for="lbxState"><?php echo lang('form_bank_payment'); ?></label-->
                    <select id="status" name="bank_payment" class="input-block-level">
                        <option value="0">--</option>
                        <option value="1"><?php echo lang('btn_no'); ?></option>
                        <option value="2"><?php echo lang('btn_yes'); ?></option>
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
