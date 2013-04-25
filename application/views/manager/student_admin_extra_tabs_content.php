<div id="studentData" class="tab-pane" data-bind="with: currentContact">
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
                <option value="0">Se muda</option>
                <option value="1">Cambio de escuela</option>
            </select>
        </div>
        <div class="span4">
            <label for="txtEndDate"><?php echo lang('form_end_date'); ?></label>
            <input type="text" id="txtEndDate" placeholder="<?php echo lang('date_format_humans'); ?>" class="input-block-level"
                   data-bind="value: end_date, jqDatepicker: end_date">
        </div> 
    </div>
    <div class="row-fluid newComponentGroup">
        <div class="span4">
            <label for="lbxAccountFormat"><?php echo lang('form_bank_account_format'); ?></label>
            <select id="lbxAccountFormat" class="input-block-level" data-bind="value: bank_account_format">
                <option value="U">--</option>
                <option value="CCC">CCC</option>
                <option value="IBAN">IBAN</option>
            </select>
        </div>
        <div class="span8">
            <label for="txtAccountNumber"><?php echo lang('form_bank_account_number'); ?></label>
            <input type="text" id="txtAccountNumber" placeholder="<?php echo lang('form_account_numer_desc'); ?>" class="input-block-level"
                data-bind="value: bank_account_number">
        </div>
    </div>
</div>