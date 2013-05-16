<div class="row-fluid">
    <div class="span8">
        <input type="hidden" id="cnt_id" data-bind="value: id" />
        <div class="row-fluid">
            <div class="span6 control-group">
                <label for="txtFirstname" class="control-label"><?php echo lang('form_first_name'); ?></label>
                <input type="text" id="txtFirstname" placeholder="<?php echo lang('form_first_name'); ?>" class="input-block-level"
                       data-bind="value: first_name" required minlength="2">
            </div>
            <div class="span6">
                <label for="txtLastname"><?php echo lang('form_last_name'); ?></label>
                <input type="text" id="txtLastname" placeholder="<?php echo lang('form_last_name'); ?>" class="input-block-level"
                       data-bind="value: last_name">
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <label for="txtDateOfBirth"><?php echo lang('form_date_of_birth'); ?></label>
                <input type="text" id="txtDateOfBirth" class="input-block-level" 
                       placeholder="<?php echo lang('date_format_humans') ?>"
                       data-bind="value: date_of_birth, jqDatepicker: date_of_birth">
            </div>                        
            <div class="span6">
                <label for="lbxGender"><?php echo lang('form_sex'); ?></label>
                <select id="lbxGender" class="input-block-level"
                        data-bind="value: sex">
                    <option value="U">--</option>
                    <option value="M"><?php echo lang('form_sex_male'); ?></option>
                    <option value="F"><?php echo lang('form_sex_female'); ?></option>
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <label for="txtIdCard"><?php echo lang('form_id_card'); ?></label>
                <input type="text" id="txtIdCard" placeholder="<?php echo lang('form_id_card'); ?>" class="input-block-level"
                       data-bind="value: id_card">
            </div>                        
        </div>
    </div>
    <div class="span4">
        <div id="picture">
            <img class="img-polaroid" 
                 data-bind="attr: {src: picture() != '' ? '/assets/uploads/files/contact/' + picture() : '/assets/img/personal.png'}" />
            <a href="#"><?php echo lang('lnk_chanche_picture'); ?></a>
        </div>
    </div>
</div>
<div class="row-fluid newComponentGroup">
    <div class="span8">
        <div class="row-fluid">
            <div class="span6">
                <label for="txtPhoneMobile"><?php echo lang('form_phone_mobile'); ?></label>
                <input type="text" id="txtPhoneMobile" placeholder="<?php echo lang('form_phone_mobile'); ?>" class="input-block-level"
                       data-bind="value: phone_mobile">
            </div>
            <div class="span6">
                <label for="txtPhone"><?php echo lang('form_phone'); ?></label>
                <input type="text" id="txtPhone" placeholder="<?php echo lang('form_phone'); ?>" class="input-block-level"
                       data-bind="value: phone">
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <label for="txtEmail"><?php echo lang('form_email'); ?></label>
                <input type="text" id="txtEmail" placeholder="<?php echo lang('form_email'); ?>" class="input-block-level"
                       data-bind="value: email">
            </div>
            <div class="span6">
                <label for="txtOccupation"><?php echo lang('form_occupation'); ?></label>
                <input type="text" id="txtOccupation" placeholder="<?php echo lang('form_occupation'); ?>" class="input-block-level"
                       data-bind="value: occupation">
            </div>
        </div>
        <div class="row-fluid newComponentGroup">
            <div class="span*">
                <label for="txtAddress"><?php echo lang('form_address'); ?></label>
                <input type="text" id="txtAddress" placeholder="<?php echo lang('form_address_desc'); ?>" class="input-block-level"
                       data-bind="value: address">
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">
                <label for="txtPostCode"><?php echo lang('form_p_c'); ?></label>
                <input type="text" id="txtPostCode" placeholder="<?php echo lang('form_postal_code'); ?>" class="input-block-level"
                       data-bind="value: postal_code">
            </div>
            <div class="span5">
                <label for="txtTown"><?php echo lang('form_town'); ?></label>
                <input type="text" id="txtTown" placeholder="<?php echo lang('form_town'); ?>" class="input-block-level"
                       data-bind="value: town">
            </div>
            <div class="span5">
                <label for="txtProvince"><?php echo lang('form_province'); ?></label>
                <input type="text" id="txtProvince" placeholder="<?php echo lang('form_province'); ?>" class="input-block-level"
                       data-bind="value: province">
            </div>
        </div>
    </div>
    <div class="span4">
        <label><?php echo lang('form_notes'); ?></label>
        <textarea id="txtNotes" class="input-block-level" 
                  data-bind="html: notes">
        </textarea>
    </div>
</div>