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
                    <option value="<?php echo $group["id"] ?>"><?php echo $group["name"] ?> (<?php echo $group["academic_period_name"] ?>)</option>
                <?php } ?>
            </select>            
        </div>
        <div class="span2">
            <label for="txtStartDate"><?php echo lang('form_start_date'); ?></label>
            <input type="text" id="txtStartDate" placeholder="<?php echo lang('date_format_humans'); ?>" class="input-block-level"
                   data-bind="value: start_date, jqDatepicker: start_date">
        </div>
        <div class="span2">
            <label for="tbxPrefStartTime"><?php echo lang('form_start_time'); ?></label>
            <input type="text" id="tbxPrefStartTime" class="input-block-level" readonly
                   data-bind="value: $root.currentStudentGroup().start_time" />
        </div>
        <div class="span2">
            <label for="tbxPrefEndTime"><?php echo lang('form_end_time'); ?></label>
            <input type="text" id="tbxPrefStartTime" class="input-block-level" readonly
                   data-bind="value: $root.currentStudentGroup().end_time" />
        </div>

    </div>
    <div class="row-fluid">
        <div class="span2">
            <label for="lbxLanguageYears"><?php echo lang('form_language_years'); ?></label>
            <input type="text" id="lbxLanguageYears" placeholder="<?php echo lang('form_language_years'); ?>" class="input-block-level" 
                   data-bind="value: language_years" />
        </div>                 
        <div class="span4">
            <label for="lbxLeaveReason"><?php echo lang('form_leave_reason'); ?></label>
            <select id="lbxLeaveReason" class="input-block-level" data-bind="value: leave_reason_code">
                <option value="">--</option>
                <?php foreach ($leaveReasons as $reason) { ?>
                    <option value="<?php echo $reason["code"] ?>"><?php echo $reason["description"] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="span2">
            <label for="txtEndDate"><?php echo lang('form_end_date'); ?></label>
            <input type="text" id="txtEndDate" placeholder="<?php echo lang('date_format_humans'); ?>" class="input-block-level"
                   data-bind="value: end_date, jqDatepicker: end_date">
        </div> 
        <div class="span4">
            <label for="lbxLevel"><?php echo lang('form_level'); ?></label>
            <input type="text" id="tbxPrefStartTime" class="input-block-level" readonly
                   data-bind="value: $root.levels[$root.currentStudentGroup().level_code]" />
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
    <div class="row-fluid newComponentGroup">
        <legend>
            Evaluaciones
            <div class="pull-right">                
                <button type="button" class="btn btn-small " 
                        data-toggle="modal" data-target="#dlgQualification" 
                        data-bind="enable: $root.currentContact().id()>0, click: $root.newQualification">
                    <i class="icon-plus-sign"></i> <?php echo lang('btn_new'); ?>
                </button>
                <button type="button" class="btn btn-small " data-target="_blank" 
                        data-bind="enable: $root.currentContact().id()>0, click: $root.printQualifications">
                    <i class="icon-print"></i> <?php echo lang('btn_print'); ?>
                </button>
            </div>
        </legend>
    </div>
    <div class="row-fluid">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Período</th>
                    <th>Nivel</th>
                    <th>Ev. 1</th>
                    <th>Ev. 2</th>
                    <th>Ev. 3</th>
                    <th>Calificación</th>
                    <th>Trinity</th>
                    <th>Cambridge</th>
                    <th>Otras</th>
                </tr>
            </thead>
            <tbody data-bind="foreach: $root.currentQualifications">
                <tr data-bind="click: $root.selectQualification">
                    <td data-bind="text: $root.academicPeriods[academic_period()]"></td>
                    <td data-bind="text: $root.levels[level_code()]"></td>
                    <td data-bind="text: eval1"></td>
                    <td data-bind="text: eval2"></td>
                    <td data-bind="text: eval3"></td>
                    <td data-bind="text: qualification"></td>
                    <td data-bind="text: trinity"></td>
                    <td data-bind="text: london"></td>
                    <td data-bind="text: others"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div id="dlgQualification" class="modal hide fade" data-bind="with: $root.currentQualification">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Evaluación</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <div class="span4">
                    <label><?php echo lang('form_academic_period'); ?></label>
                    <select class="input-block-level" data-bind="value: academic_period">
                        <option value="">--</option>
                        <?php foreach ($academicPeriods as $period) { ?>
                            <option value="<?php echo $period["code"] ?>"><?php echo $period["name"] ?></option>
                        <?php } ?>
                    </select>                     
                </div>
                <div class="span4">
                    <label><?php echo lang('form_level'); ?></label>
                    <select class="input-block-level" data-bind="value: level_code">
                        <option value="">--</option>
                        <?php foreach ($levels as $level) { ?>
                            <option value="<?php echo $level["code"] ?>"><?php echo $level["description"] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="span4">
                    <label>Calificación</label>
                    <input type="text" class="input-block-level" data-bind="value: qualification">
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <label>Evaluación 1</label>
                    <input type="text" class="input-block-level" data-bind="value: eval1">
                </div>
                <div class="span4">
                    <label>Evaluación 2</label>
                    <input type="text" class="input-block-level" data-bind="value: eval2">
                </div>
                <div class="span4">
                    <label>Evaluación 3</label>
                    <input type="text" class="input-block-level" data-bind="value: eval3">
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <label>Trinity</label>
                    <input type="text" class="input-block-level" data-bind="value: trinity">
                </div>
                <div class="span4">
                    <label>Cambridge</label>
                    <input type="text" class="input-block-level" data-bind="value: london">
                </div>
                <div class="span4">
                    <label>Otras</label>
                    <input type="text" class="input-block-level" data-bind="value: others">
                </div>
            </div>
            <div class="row-fuid">
                <label>Descripción</label>
                <textarea class="input-block-level" data-bind="value: description"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-small btn-success" data-dismiss="modal" data-bind="click: $root.saveQualification"><i class="icon-ok-sign icon-white"></i> Guardar</button>
            <button class="btn btn-small btn-danger" data-dismiss="modal" data-bind="click: $root.removeQualification, visible: student_id"><i class="icon-minus-sign icon-white"></i> Eliminar</button>
            <button class="btn btn-small" data-dismiss="modal"><i class="icon-ban-circle"></i> Cancelar</button>
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
                     src: picture() && picture() != '' ? '/assets/uploads/files/contact/' + picture() : '/assets/img/personal.png'}">
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
                <button class="btn btn-small btn-success" data-bind="click: $root.saveFamily">
                    <i class="icon-ok-sign icon-white"></i> <?php echo lang('btn_save'); ?>
                </button>
                <button class="btn btn-small btn-danger" data-bind="click: $root.removeFamily">
                    <i class="icon-minus-sign icon-white"></i> <?php echo lang('btn_delete'); ?>
                </button>
            </div>
        </legend>
    </div>
    <div class="row-fluid" data-bind="with: currentFamily">
        <div class="span4" >
            <label for="lbxAvailableFamily"><?php echo lang('form_existing_family'); ?></label>
            <select id="lbxAvailableFamily" class="input-block-level"
                    data-bind="options: $root.availableFamily, value: $root.selectedFamily, optionsText: function (item) { return item.full_name(); }, optionsCaption: '--'">
            </select>
        </div>
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
    <div id="currentFamilyDetails" class="row-fluid" data-bind="with: currentFamily">
        <?php
        $configData = [
            'pictureDialogId' => 'currentFamilyPicture',
            'pictureDialogBind' => '$root.currentFamily'
        ];
        $this->load->view('manager/contact_admin_contact_data', $configData);
        ?>
    </div>
</div>
<div id="paymentData" class="tab-pane" data-bind="with: currentContact">
    <div class="row-fluid">
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
                   data-bind="value: bank_account_holder, enable: bank_payment() == 1">
        </div>
        <div class="span2">
            <label for="lbxAccountFormat"><?php echo lang('form_bank_account_format'); ?></label>
            <select id="lbxAccountFormat" class="input-block-level" data-bind="value: bank_account_format, enable: bank_payment() == 1">
                <option value="U">--</option>
                <option value="CCC">CCC</option>
                <option value="IBAN">IBAN</option>
            </select>
        </div>
        <div class="span4">
            <label for="txtAccountNumber"><?php echo lang('form_bank_account_number'); ?></label>
            <input type="text" id="txtAccountNumber" placeholder="<?php echo lang('form_account_numer_desc'); ?>" class="input-block-level"
                   data-bind="value: bank_account_number, enable: bank_payment() == 1">
        </div>
    </div>

    <div class="row-fluid newComponentGroup">
        <!-- Pagos -->
        <legend>
            <?php echo lang('menu_payment'); ?>
            <div class="pull-right">       
                <button class="btn btn-small"  data-toggle="modal" data-target="#dlgPayments" data-bind="enable: $root.currentContact().id() > 0 && $root.currentContact().bank_payment() != 1, click: $root.newPayment">
                    <i class="icon-plus-sign"></i> <?php echo lang('btn_new'); ?>
                </button>

                <div class="btn-group">
                    <button class="btn" data-target="_blank" data-bind="enable: $root.currentContact().id()>0, click: $root.printPayments"><i class="icon-print"></i> <?php echo lang('btn_print'); ?></button>
                    <button class="btn dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" data-bind="visible: $root.paymentList().length > 0 && $root.currentPayment().id() > 0">
                        <li><a href="#" data-bind="click: $root.printPayment">Imprimir activo</a></li>
                    </ul>
                </div>

                <button class="btn btn-small"  data-toggle="modal" data-target="#dlgPayments" data-bind="enable: $root.paymentList().length > 0 && $root.currentPayment().id() > 0" title="<?php echo lang('btn_edit'); ?>">
                    <i class="icon-edit"></i> <?php echo lang('btn_edit'); ?>
                </button>

                <button class="btn btn-small btn-danger" data-bind="enable: $root.paymentList().length > 0 && $root.currentPayment().id() > 0, click: $root.removePayment" title="<?php echo lang('btn_delete'); ?>">
                    <i class="icon-minus-sign icon-white"></i> <?php echo lang('btn_delete'); ?>
                </button>
            </div>
        </legend>
        <div class="row-fluid">

            <table class="table table-striped table-bordered table-hover ">
                <thead>
                    <tr>
                        <th><?php echo lang('form_payment_type'); ?></th>
                        <th><?php echo lang('form_piriod'); ?></th>
                        <th><?php echo lang('form_amount'); ?></th>
                        <th><?php echo lang('form_date'); ?></th>
                        <th><?php echo lang('form_notes'); ?></th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: $root.paymentList">
                    <tr data-bind="click: $root.selectPayment" >
                        <td data-bind="text: $root.paymentTypes[payment_type_id()]">
                            <!--input type="text" data-bind="visible: $root.isInEditRowMode(id)"-->
                        </td>
                        <td data-bind="text: piriod"></td>
                        <td data-bind="text: amount"></td>
                        <td data-bind="text: date"></td>
                        <td data-bind="text: notes"></td>    
                    </tr>
                </tbody>
            </table>        
        </div>
    </div>
    <div id="dlgPayments" class="modal hide fade">
        <!-- Dialogo de pagos -->
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Datos del pago</h3>
        </div>
        <div class="modal-body">

            <div class="row-fluid" data-bind="with: $root.currentPayment">
                <div class="span3">
                    <label for="lbxRelationship"><?php echo lang('subject_payment_type'); ?></label>
                    <select id="lbxRelationship" class="input-block-level" data-bind="value: payment_type_id">
                        <!--option value="">--</option-->
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
                           data-bind="value:  amount" />
                </div>
                <div class="span3">
                    <label for="txtDate"><?php echo lang('form_date'); ?></label>
                    <input type="text" id="txtDate" placeholder="dd/mm/aaaa" class="input-block-level"
                           data-bind="value: date, jqDatepicker: date">
                </div>
            </div>
            <div class="row-fluid" data-bind="with: $root.currentPayment">
                <div class="span12">
                    <label for="lbxNotes"><?php echo lang('form_notes'); ?></label>
                    <input type="text" id="lbxNotes" placeholder="" class="input-block-level" 
                           data-bind="value: notes" />
                </div>                
            </div>
            <div class="row-fluid">
                <span data-bind="text: '&nbsp;' + '&nbsp;'"></span>
                <legend data-bind="with: $root.currentPayment">
                    <div class="pull-right">
                        <button class="btn btn-small btn-success" data-bind="click: $root.savePayment" aria-hidden="true" data-dismiss="modal">
                            <i class="icon-ok-sign icon-white"></i> <?php echo lang('btn_save'); ?>
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