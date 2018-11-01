<div id="professionalData" class="tab-pane" data-bind="with: currentContact">
    <label for="txtTitle"><?php echo lang('form_title'); ?></label>
    <input type="text" id="txtTitle" placeholder="<?php echo lang('form_title'); ?>" class="input-block-level"
           data-bind="value: title">
    <div class="row-fluid">
        <div class="span2">
            <label for="lbxType"><?php echo lang('form_type'); ?></label>
            <select id="lbxType" class="input-block-level" data-bind="value: type">
                <option value="U">--</option>
                <option value="F">Fijo</option>
                <option value="P">Tiempo parcial</option>
            </select>
        </div>
        <div class="span4">
            <label for="txtStartDate"><?php echo lang('form_start_date'); ?></label>
            <input type="text" id="txtStartDate" placeholder="<?php echo lang('date_format_humans'); ?>" class="input-block-level"
                   data-bind="value: start_date, jqDatepicker: start_date">
        </div>
        <div class="span2">
            <label for="lbxState"><?php echo lang('form_state'); ?></label>
            <select id="lbxState" class="input-block-level" data-bind="value: state">
                <option value="U">--</option>
                <option value="A">Activo</option>
                <option value="I">Inactivo</option>
            </select>
        </div>
        <div class="span4">
            <label for="txtEndDate"><?php echo lang('form_end_date'); ?></label>
            <input type="text" id="txtEndDate" placeholder="<?php echo lang('date_format_humans'); ?>" class="input-block-level"
                   data-bind="value: end_date, jqDatepicker: end_date">
        </div> 
    </div>
    <div class="row-fluid newComponentGroup">
        <div class="span2">
            <label for="lbxAccountFormat"><?php echo lang('form_bank_account_format'); ?></label>
            <select id="lbxAccountFormat" class="input-block-level" data-bind="value: bank_account_format">
                <option value="U">--</option>
                <option value="CCC">CCC</option>
                <option value="IBAN">IBAN</option>
            </select>
        </div>
        <div class="span10">
            <label for="txtAccountNumber"><?php echo lang('form_bank_account_number'); ?></label>
            <input type="text" id="txtAccountNumber" placeholder="<?php echo lang('form_account_numer_desc'); ?>" class="input-block-level"
                data-bind="value: bank_account_number">
        </div>
    </div>
    <label for="txtCV" class="newComponentGroup"><?php echo lang('form_cv'); ?></label>
    <textarea id="txtCV" class="input-block-level" data-bind="html: cv"></textarea>
</div>
