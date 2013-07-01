<div id="studentData" class="tab-pane" data-bind="with: currentContact">
    <div class="row-fluid">
        <!-- Datos de la academia -->
        <div class="span3">
            <label for="lbxCenterId"><?php echo lang('form_center'); ?></label>
            <select id="lbxCenterId" class="input-block-level" data-bind="value: center_id">
                <?php foreach ($centers as $center) { ?>
                    <option value="<?php echo $center["id"] ?>" <?php echo $center["id"] == $this->session->userdata('current_center')['id'] ? "selected" : "" ?>>
                        <?php echo $center["name"] ?>
                    </option>
                <?php } ?>
            </select>            
        </div>
        <div class="span3">
            <label for="lbxCurrentGroupId"><?php echo lang('form_group'); ?></label>
            <select id="lbxCurrentGroupId" class="input-block-level" data-bind="value: group_id">
                <option value="">--</option>
                <?php foreach ($groups as $group) { ?>
                    <option value="<?php echo $group["id"] ?>"><?php echo $group["name"] ?></option>
                <?php } ?>
            </select>            
        </div>
        <div class="span3 hidden hide" >
            <label for="lbxAcademicPeriod"><?php echo lang('form_academic_period'); ?></label>
            <select id="lbxAcademicPeriod" class="input-block-level" data-bind="value: current_academic_period">
                <option value="">--</option>
                <?php foreach ($academicPeriods as $period) { ?>
                    <option value="<?php echo $period["code"] ?>"><?php echo $period["name"] ?></option>
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
                    <option value="<?php echo $reason["code"] ?>"><?php echo $reason["description"] ?></option>
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
            <label for="cbxSchoolLevel"><?php echo lang('form_school_level'); ?></label>
            <select id="cbxSchoolLevel" class="input-block-level" data-bind="value: school_level">
                <option value="">--</option>
                <?php foreach ($schoolLevels as $level) { ?>
                    <option value="<?php echo $level["id"] ?>"><?php echo $level["name"] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="span8">
            <label for="txtSchoolName"><?php echo lang('form_school_name'); ?></label>
            <input type="text" id="txtSchoolName" placeholder="<?php echo lang('form_school_name'); ?>" class="input-block-level"
                   data-bind="value: school_name">
        </div>
    </div>
</div>
<div id="familyData" class="tab-pane">
    <ul class="list thumbnails">
        <!-- ko foreach: familyList -->
        <li class="medium">
            <a href="#" class="thumbnail" data-bind="click: $root.selectFamily">
                <img data-bind="attr: {
                     alt: first_name,
                     src: picture() != '' ? '/assets/uploads/files/contact/' + picture() : '/assets/img/personal.png'}">
            </a>
            <strong data-bind="text: first_name"></strong>
            <p data-bind="text: $root.relationships[relationship_code()]"></p>
        </li>
        <!-- /ko -->
        <li class="medium add">
            <a href="#" class="thumbnail" data-bind="click: $root.newFamily">
                <div></div>
            </a>
            <strong><?php echo lang('btn_new'); ?></strong>
            <p></p>
        </li>            
    </ul>
    <div class="row-fluid">
        <legend data-bind="with: currentFamily">
            <span data-bind="text: full_name() + '&nbsp;'"></span>
            <div class="pull-right">
                <button class="btn btn-small" data-bind="click: $root.saveFamily">
                    <i class="icon-ok-sign"></i> <?php echo lang('btn_save'); ?>
                </button>
                <button class="btn btn-small btn-danger" data-bind="click: $root.removeFamily">
                    <i class="icon-minus-sign icon-white"></i> <?php echo lang('btn_delete'); ?>
                </button>
            </div>
        </legend>
    </div>
    <div class="row-fluid" data-bind="with: currentFamily">
        <div class="span4">
            <label for="lbxRelationship"><?php echo lang('form_relationship'); ?></label>
            <select id="lbxRelationship" class="input-block-level" data-bind="value: relationship_code">
                <option value="">--</option>
                <?php foreach ($relationships as $relationship) { ?>
                    <option value="<?php echo $relationship["code"] ?>"><?php echo $relationship["name"] ?></option>
                <?php } ?>
            </select>
        </div> 
    </div>
    <div class="row-fluid" data-bind="with: currentFamily">
        <?php
        $data = [
            'pictureDialogId' => 'currentFamilyPicture',
            'pictureDialogBind' => '$root.currentFamily'
        ];
        $this->load->view('manager/contact_admin_contact_data', $data);
        ?>
    </div>
</div>
<div id="paymentData" class="tab-pane">
    <button class="btn btn-small"  data-toggle="modal" data-target="#dlgPayments" data-bind="click: $root.newPayment">
        <i class="icon-plus-sign"></i> <?php echo lang('btn_new'); ?>
    </button>

    <div class="btn-group">
        <button class="btn" data-target="_blank" data-bind="enable: paymentList().length > 0, click: $root.printPayments"><i class="icon-print"></i> <?php echo lang('btn_print'); ?></button>
        <button class="btn dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" data-bind="visible: paymentList().length > 0 && currentPayment().id() > 0">
            <li><a href="#" data-bind="click: $root.printPayment">Imprimir activo</a></li>
        </ul>
    </div>

    <!--button class="btn btn-small" data-target="_blank" data-bind="enable: paymentList().length > 0, click: $root.printPayments" title="<?php echo lang('btn_print'); ?>">
        <i class="icon-print"></i> Imprimir listado<?php //echo lang('btn_print');   ?>
    </button-->

    <button class="btn btn-small"  data-toggle="modal" data-target="#dlgPayments" data-bind="enable: paymentList().length > 0 && currentPayment().id() > 0" title="<?php echo lang('btn_edit'); ?>">
        <i class="icon-edit"></i> <?php echo lang('btn_edit'); ?>
    </button>
    <!--button class="btn btn-small" data-bind="enable: paymentList().length > 0 && currentPayment().id() > 0, click: $root.printPayment" title="<?php echo lang('btn_print'); ?>">
        <i class="icon-print"></i> <?php //echo lang('btn_print'); ?>
    </button-->
    <button class="btn btn-small btn-danger" data-bind="enable: paymentList().length > 0 && currentPayment().id() > 0, click: $root.removePayment" title="<?php echo lang('btn_delete'); ?>">
        <i class="icon-minus-sign icon-white"></i> <?php echo lang('btn_delete'); ?>
    </button>


    <br><br>
    <div class="row-fluid">

        <table class="table table-striped table-bordered table-hover ">
            <thead>
                <tr>
                    <th><?php echo lang('form_payment_type'); ?></th>
                    <th><?php echo lang('form_piriod'); ?></th>
                    <th><?php echo lang('form_amount'); ?></th>
                    <th><?php echo lang('form_date'); ?></th>
                </tr>
            </thead>
            <tbody data-bind="foreach: paymentList">
                <tr data-bind="click: $root.selectPayment" >
                    <td data-bind="text: $root.paymentTypes[payment_type_id()]">
                        <input type="text" data-bind="visible: $root.isInEditRowMode(id)">
                    </td>
                    <td data-bind="text: piriod"></td>
                    <td data-bind="text: amount"></td>
                    <td data-bind="text: date"></td>                   
                </tr>
            </tbody>
        </table>        
    </div>

    <div id="dlgPayments" class="modal hide fade">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Datos del pago</h3>
        </div>
        <div class="modal-body">

            <div class="row-fluid" data-bind="with: currentPayment">
                <div class="span3">
                    <label for="lbxRelationship"><?php echo lang('subject_payment_type'); ?></label>
                    <select id="lbxRelationship" class="input-block-level" data-bind="value: payment_type_id">
                        <option value="">--</option>
                        <?php foreach ($payments_types as $payment_type) { ?>
                            <option value="<?php echo $payment_type["id"] ?>"><?php echo $payment_type["name"] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="span4">
                    <label for="lbxPiriod"><?php echo lang('form_piriod'); ?></label>
                    <input type="text" id="lbxPiriod" placeholder="" class="input-block-level" 
                           data-bind="value: piriod" />
                </div>
                <div class="span2">
                    <label for="lbxAmount"><?php echo lang('form_amount'); ?></label>
                    <input type="text" id="lbxAmount" placeholder="" class="input-block-level" 
                           data-bind="value: amount" />
                </div>
                <div class="span3">
                    <label for="txtDate"><?php echo lang('form_date'); ?></label>
                    <input type="text" id="txtDate" placeholder="dd/mm/aaaa" class="input-block-level"
                           data-bind="value: date, jqDatepicker: date">
                </div>
            </div>
            <div class="row-fluid">
                <span data-bind="text: '&nbsp;' + '&nbsp;'"></span>
                <legend data-bind="with: currentPayment">
                    <div class="pull-right">
                        <button class="btn btn-small" data-bind="click: $root.savePayment" aria-hidden="true" data-dismiss="modal">
                            <i class="icon-ok-sign"></i> <?php echo lang('btn_save'); ?>
                        </button>                       
                        <button class="btn btn-small" aria-hidden="true" data-dismiss="modal">
                            <i class="icon-remove-sign"></i> <?php echo lang('btn_close'); ?>
                        </button>                
                    </div>
                </legend>
            </div>
        </div>
    </div>
</div>