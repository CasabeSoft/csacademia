<div id="studentData" class="tab-pane" data-bind="with: currentContact">
    <div class="row-fluid">
        <!-- Datos de la academia -->
        <div class="span3">
            <label for="lbxCurrentLevelCode"><?php echo lang('form_level'); ?></label>
            <select id="lbxCurrentLevelCode" class="input-block-level" data-bind="value: current_level_code">
                <?php foreach ($levels as $level) { ?>
                <option value="<?php echo $level["code"]?>"><?php echo $level["description"] ?></option>
                <?php } ?>
            </select>            
        </div>
        <div class="span3">
            <label for="lbxAcademicPeriod"><?php echo lang('form_academic_period'); ?></label>
            <select id="lbxAcademicPeriod" class="input-block-level" data-bind="value: current_academic_period">
                <?php foreach ($academicPeriods as $period) { ?>
                <option value="<?php echo $period["code"]?>"><?php echo $period["name"] ?></option>
                <?php } ?>
            </select>            
        </div>
        <div class="span3">
            <label for="tbxPrefStartTime"><?php echo lang('form_pref_start_time'); ?></label>
            <input type="text" id="tbxPrefStartTime" placeholder="16:00" class="input-block-level" 
                   data-bind="value: pref_start_time" />
        </div>
        <div class="span3">
            <label for="tbxPrefEndTime"><?php echo lang('form_pref_end_time'); ?></label>
            <input type="text" id="tbxPrefStartTime" placeholder="18:00" class="input-block-level" 
                   data-bind="value: pref_end_time" />
        </div>        
    </div>
    <div class="row-fluid">
        <div class="span2">
            <label for="lbxLanguageYears"><?php echo lang('form_language_years'); ?></label>
            <input type="text" id="lbxLanguageYears" placeholder="<?php echo lang('form_language_years'); ?>" class="input-block-level" 
                   data-bind="value: language_years" />
        </div>
        <div class="span4">
            <label for="txtStartDate"><?php echo lang('form_start_date'); ?></label>
            <input type="text" id="txtStartDate" placeholder="<?php echo lang('date_format_humans'); ?>" class="input-block-level"
                   data-bind="value: start_date, jqDatepicker: start_date">
        </div>        
        <div class="span2">
            <label for="lbxLeaveReason"><?php echo lang('form_leave_reason'); ?></label>
            <select id="lbxLeaveReason" class="input-block-level" data-bind="value: leave_reason_code">
                <option value="">--</option>
                <?php foreach ($leaveReasons as $reason) { ?>
                <option value="<?php echo $reason["code"]?>"><?php echo $reason["description"] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="span4">
            <label for="txtEndDate"><?php echo lang('form_end_date'); ?></label>
            <input type="text" id="txtEndDate" placeholder="<?php echo lang('date_format_humans'); ?>" class="input-block-level"
                   data-bind="value: end_date, jqDatepicker: end_date">
        </div> 
    </div>
    <div class="row-fluid newComponentGroup">
        <!-- Datos financieros -->
        <div class="span2">
            <label for="rgrBankPayment"><?php echo lang('form_bank_payment'); ?></label>
            <select id="rgrBankPayment" class="input-block-level" data-bind="value: bank_payment">
                <option value="0"><?php echo lang('btn_no'); ?></option>
                <option value="1"><?php echo lang('btn_yes'); ?></option>
            </select>
        </div>
        <div class="span4">
            <label for="txtBankAccountHolder"><?php echo lang('form_bank_account_holder'); ?></label>
            <input type="text" id="txtBankAccountHolder" placeholder="<?php echo lang('form_first_name'); ?>" class="input-block-level"
                data-bind="value: bank_account_holder">
        </div>
        <div class="span2">
            <label for="lbxAccountFormat"><?php echo lang('form_bank_account_format'); ?></label>
            <select id="lbxAccountFormat" class="input-block-level" data-bind="value: bank_account_format">
                <option value="U">--</option>
                <option value="CCC">CCC</option>
                <option value="IBAN">IBAN</option>
            </select>
        </div>
        <div class="span4">
            <label for="txtAccountNumber"><?php echo lang('form_bank_account_number'); ?></label>
            <input type="text" id="txtAccountNumber" placeholder="<?php echo lang('form_account_numer_desc'); ?>" class="input-block-level"
                data-bind="value: bank_account_number">
        </div>
    </div>
    <div class="row-fluid newComponentGroup">
        <!-- Datos escolares -->
        <div class="span4">
            <label for="lbxSchoolAcademicPeriod"><?php echo lang('form_school_academic_period'); ?></label>
            <input type="text" id="lbxSchoolAcademicPeriod" placeholder="20XX-20YY" class="input-block-level" 
                   data-bind="value: school_academic_period" />
        </div>
        <div class="span8">
            <label for="txtSchoolName"><?php echo lang('form_school_name'); ?></label>
            <input type="text" id="txtSchoolName" placeholder="<?php echo lang('form_school_name'); ?>" class="input-block-level"
                data-bind="value: school_name">
        </div>
    </div>
</div>