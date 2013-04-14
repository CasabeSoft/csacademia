<div class="container container-first">
    <div id="msgFeedback" class="feedback top">
    </div>
    <h1><?php echo lang('page_manage_teachers'); ?></h1>
    <div class="row">
        <div class="span3">
            <legend>
                <?php echo lang('subject_teacher'); ?>
                <div class="btn-toolbar pull-right">
                    <button class="btn btn-small pull-right" data-bind="click: newContact">
                        <i class="icon-plus-sign"></i> <?php echo lang('btn_new'); ?>
                    </button>
                </div>
            </legend>
            <div class="row-fluid">            
                <input id="appendedInputButtons" type="text" class="span*" placeholder="<?php echo lang('form_type_filter'); ?>"
                       data-bind="value: filter">
            </div>
            <table id="tblContacts" class="table table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th><?php echo lang('form_name'); ?></th>
                    </tr>
                </thead>            
                <tbody data-bind="foreach: filteredContacts">
                    <tr data-bind="click: $root.selectContact">
                        <td data-bind="text: full_name()"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="span9">
            <legend data-bind="with: currentContact">
                <span data-bind="text: full_name() + '&nbsp;'"></span>
                <div class="pull-right">
                    <button class="btn btn-small" data-bind="click: $root.saveContact">
                        <i class="icon-ok-sign"></i> <?php echo lang('btn_save'); ?>
                    </button>
                    <button class="btn btn-small btn-danger" data-bind="click: $root.removeContact">
                        <i class="icon-minus-sign icon-white"></i> <?php echo lang('btn_delete'); ?>
                    </button>
                </div>
            </legend>
            <ul id="tbContactData" class="nav nav-tabs">
                <li class="active"><a href="#generalData" data-bind="click: $root.activateTab"><?php echo lang('subject_general_data'); ?></a></li>
                <li><a href="#professionalData" data-bind="click: $root.activateTab"><?php echo lang('subject_professional_data'); ?></a></li>
            </ul>
            <div class="tab-content">
                <div id="generalData" class="tab-pane active" data-bind="with: currentContact">
                    <div class="row-fluid">
                        <div class="span8">
                            <input type="hidden" id="cnt_id" data-bind="value: id" />
                            <div class="row-fluid">
                                <div class="span6">
                                    <label for="txtFirstname"><?php echo lang('form_first_name'); ?></label>
                                    <input type="text" id="txtFirstname" placeholder="<?php echo lang('form_first_name'); ?>" class="input-block-level"
                                           data-bind="value: first_name">
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
                                <img src="/assets/img/personal.png" class="img-polaroid" />
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
                </div>
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
                    <label for="txtCV" class="newComponentGroup"><?php echo lang('form_cv'); ?></label>
                    <textarea id="txtCV" class="input-block-level" data-bind="html: cv"></textarea>
                </div>            
            </div>
        </div>
    </div>
</div>
