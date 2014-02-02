<form id="frm" action="" method="POST">
    <div class="container container-first">
        <div class="title-bar">
            <div id="msgFeedback" class="feedback top">
            </div>
            <h1><?php echo $title; ?></h1>
        </div>
        <div class="row">
            <div class="span3 fixed">
                <legend>
                    <?php echo $subject; ?>
                    <div class="btn-toolbar pull-right">
                        <button class="btn btn-small pull-right" data-bind="click: newTask">
                            <i class="icon-plus-sign"></i> <?php echo lang('btn_new'); ?>
                        </button>
                    </div>
                </legend>
                <div>                     
                    <div class="btn-group" data-toggle="buttons-radio">
                        <button class="btn" data-bind="click: setViewDaily.bind($data, true)"><img src="/assets/img/icon-calendar-day.png" class="icon-"> <?php echo lang('subject_day'); ?></button>
                        <button class="btn" data-bind="click: setViewDaily.bind($data, false)"><i class="icon-calendar"></i> <?php echo lang('subject_month'); ?></button>
                    </div>
                    <label id="text_date">&nbsp; </label>
                    <span type="text" class="input-block-level" id="my_date"
                          placeholder="<?php echo lang('date_format_humans') ?>"
                          data-bind="value: currentDate, jqDatepicker: new Date(), event: {change: onCurrentDateChange}"></span>
                    <label>&nbsp; </label>                   
                </div>
            </div>
            <div class="span9">
                <legend data-bind="with: currentDate" class="row-fluid">
                    <span class="title-item-select" data-bind="text: $root.currentDateText() + '&nbsp;'"></span>
                    <div class="pull-right">                   
                        <button type="button" class="btn btn-small " data-target="_blank" 
                                data-bind="click: $root.printTasks">
                            <i class="icon-print"></i> <?php echo lang('btn_print'); ?>
                        </button>
                    </div>
                </legend>
                <div class="tab-content row-fluid">
                    <table id="tblInternal" class="table table-bordered table-hover table-condensed" >
                        <thead>
                            <tr>
                                <!--th></th-->                                                                
                                <th><?php echo lang('form_date'); ?></th>
                                <th><?php echo lang('form_time'); ?></th>
                                <th><?php echo lang('form_task'); ?></th>
                                <th><?php echo lang('form_description'); ?></th>
                                <th><?php echo lang('form_importance'); ?></th>
                                <th><?php echo lang('form_type'); ?></th>
                                <th><?php echo lang('form_state'); ?></th>
                                <th><?php echo lang('subject_user'); ?></th>
                            </tr>
                        </thead>
                        <tbody data-bind="foreach: tasks">
                            <tr data-bind="style: {backgroundColor: $root.taskStates[task_state_id()].color}">
                                <!--td data-bind="text: $index() + 1, click: $root.selectTask"></td--> 
                                <td data-bind="text: start_date(), click: $root.selectTask"></td> <!--, visible: !$root.viewDaily()-->
                                <td data-bind="text: short_start_time(), click: $root.selectTask"></td>                                
                                <td data-bind="text: task(), click: $root.selectTask"></td>
                                <td data-bind="text: description(), click: $root.selectTask"></td>
                                <td data-bind="text: $root.taskImportances[task_importance_id()], click: $root.selectTask"></td>
                                <td data-bind="text: $root.taskTypes[task_type_id()], click: $root.selectTask"></td>
                                <td data-bind="text: $root.taskStates[task_state_id()].name, click: $root.selectTask"></td>
                                <td data-bind="text: $root.users[login_id()], click: $root.selectTask"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="dlgTasks" class="modal hide fade">
        <!-- Dialogo de tareas -->
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3><?php echo lang('subject_task'); ?></h3>
        </div>        
        <div class="modal-body">
            <div class="row-fluid" data-bind="with: $root.currentTask">                  
                <div class="span3">
                    <label for="lbxStartDate"><?php echo lang('form_task_start_date'); ?></label>
                    <input type="text" id="start_date" placeholder="dd/mm/aaaa" class="input-block-level"
                           data-bind="value: start_date, jqDatepicker: start_date, event: {change: $root.onChangeDate}">
                </div>
                <div class="span3">
                    <label for="lbxStartTime"><?php echo lang('form_task_start_time'); ?></label>
                    <input type="text" id="start_time" placeholder="HH:mm" class="input-block-level" 
                           data-bind="value: start_time, timepicker: start_time, timepickerOptions: {timeFormat: 'H:i', step: 15}"/>
                </div>                
                <div class="span3">
                    <label for="txtDate"><?php echo lang('form_task_end_date'); ?></label>
                    <input type="text" id="end_date" placeholder="dd/mm/aaaa" class="input-block-level"
                           data-bind="value: end_date, jqDatepicker: end_date">
                </div>
                <div class="span3">
                    <label for="lbxEndTime"><?php echo lang('form_task_end_time'); ?></label>
                    <input type="text" id="end_time" placeholder="HH:mm" class="input-block-level" 
                           data-bind="value: end_time, timepicker: end_time, timepickerOptions: {timeFormat: 'H:i', step: 15}"/>
                </div> 
                <input type="hidden" id="login_id" name="login_id" data-bind="value: login_id()"/>
            </div>
            <div class="row-fluid" data-bind="with: $root.currentTask">               
                <div class="span12">
                    <label for="lbxAmount"><?php echo lang('form_task'); ?></label>
                    <input type="text" id="task" placeholder="" class="input-block-level" 
                           data-bind="value: task" />
                </div>
            </div>
            <div class="row-fluid" data-bind="with: $root.currentTask">
                <div class="span12">
                    <label for="lbxNotes"><?php echo lang('form_description'); ?></label>
                    <textarea id="description" placeholder="" class="input-block-level" 
                              data-bind="value: description" ></textarea>
                </div>                
            </div>
            <div class="row-fluid" data-bind="with: $root.currentTask">               
                <div class="span4">
                    <label for="lbxTaskImportance"><?php echo lang('form_importance'); ?></label>
                    <select id="importance" class="input-block-level" data-bind="value: task_importance_id">
                        <!--option value="">--</option-->
                        <?php foreach ($tasks_importances as $task) { ?>
                            <option value="<?php echo $task["id"] ?>"><?php echo $task["name"] ?></option>
                        <?php } ?>  
                    </select>
                </div>
                <div class="span4">
                    <label for="lbxTaskType"><?php echo lang('form_type'); ?></label>
                    <select id="task_type_id" class="input-block-level" data-bind="value: task_type_id">
                        <!--option value="">--</option-->
                        <?php foreach ($tasks_types as $task) { ?>
                            <option value="<?php echo $task["id"] ?>"><?php echo $task["name"] ?></option>
                        <?php } ?>                        
                    </select>
                </div>
                <div class="span4">
                    <label for="lbxTaskType"><?php echo lang('form_state'); ?></label>
                    <select id="task_state_id" class="input-block-level" data-bind="value: task_state_id">
                        <!--option value="">--</option-->
                        <?php foreach ($tasks_states as $task) { ?>
                            <option value="<?php echo $task["id"] ?>"><?php echo $task["name"] ?></option>
                        <?php } ?>                        
                    </select>
                </div>
            </div>                       
            <div class="row-fluid">
                <span data-bind="text: '&nbsp;' + '&nbsp;'"></span>
                <legend data-bind="with: $root.currentTask">
                    <div class="pull-right">
                        <button class="btn btn-small" data-dismiss="modal" data-bind="click: $root.printTask, visible: id">
                            <i class="icon-print"></i> <?php echo lang('btn_print'); ?>
                        </button>
                        <button class="btn btn-small btn-success" data-bind="click: $root.saveTask" aria-hidden="true" data-dismiss="modal">
                            <i class="icon-ok-sign icon-white"></i> <?php echo lang('btn_save'); ?>
                        </button> 
                        <button class="btn btn-small btn-danger" data-dismiss="modal" data-bind="click: $root.removeTask, visible: id">
                            <i class="icon-minus-sign icon-white"></i> <?php echo lang('btn_delete'); ?>
                        </button>
                        <button class="btn btn-small" aria-hidden="true" data-dismiss="modal">
                            <i class="icon-remove-sign"></i> <?php echo lang('btn_cancel'); ?>
                        </button>                
                    </div>
                </legend>
            </div>
        </div>
    </div>
</form>
