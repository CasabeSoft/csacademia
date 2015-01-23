<div id="generalData" class="tab-pane active" data-bind="with: currentGroup">
    <input type="hidden" id="cnt_id" data-bind="value: id" />
    <div class="row-fluid">
        <div class="span2">
            <label for="txtName" class="control-label"><?php echo lang('form_name'); ?></label>
            <input type="text" id="txtName" placeholder="<?php echo lang('form_name'); ?>" class="input-block-level"
                   data-bind="value: name" required >
        </div>
        <div class="span2">
            <label for="lbxClassroom"><?php echo lang('form_classroom'); ?></label>
            <select id="lbxClassroom" class="input-block-level" data-bind="value: classroom_id">
                <option value="">--</option>
                <?php foreach ($classrooms as $classroom) { ?>
                    <option value="<?php echo $classroom["id"] ?>"><?php echo $classroom["name"] ?></option>
                <?php } ?>
            </select>            
        </div>
        <div class="span4">
            <label for="lbxCenter"><?php echo lang('form_center'); ?></label>
            <select id="lbxCenter" class="input-block-level" data-bind="value: center_id">
                <option value="">--</option>
                <?php foreach ($centers as $center) { ?>
                    <option value="<?php echo $center["id"] ?>"><?php echo $center["name"] ?></option>
                <?php } ?>
            </select>            
        </div>

        <div class="span4">
            <label for="lbxTeacher"><?php echo lang('form_teacher'); ?></label>
            <select id="lbxTeacher" class="input-block-level" data-bind="value: teacher_id">
                <option value="">--</option>
                <?php foreach ($teachers as $teacher) { ?>
                    <option value="<?php echo $teacher["contact_id"] ?>"><?php echo $teacher["first_name"].' '.$teacher["last_name"] ?></option>
                <?php } ?>
            </select>            
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">
            <label for="txtstart_time"><?php echo lang('form_start_time'); ?></label>
            <input type="text" id="txtstart_time" placeholder="<?php echo lang('form_start_time'); ?>" class="input-block-level"
                   data-bind="value: start_time">
        </div>
        <div class="span2">
            <label for="txtend_time"><?php echo lang('form_end_time'); ?></label>
            <input type="text" id="txtend_time" placeholder="<?php echo lang('form_end_time'); ?>" class="input-block-level"
                   data-bind="value: end_time">
        </div>                    
        <div class="span4">
            <label for="lbxAcademicPeriod"><?php echo lang('form_academic_period'); ?></label>
            <select id="lbxAcademicPeriod" class="input-block-level" data-bind="value: academic_period">
                <option value="">--</option>
                <?php foreach ($academic_periods as $period) { ?>
                    <option value="<?php echo $period["code"] ?>"><?php echo $period["name"] ?></option>
                <?php } ?>
            </select>            
        </div>
        <div class="span4">
            <label for="lbxLevel"><?php echo lang('form_level'); ?></label>
            <select id="lbxLevel" class="input-block-level" data-bind="value: level_code">
                <option value="">--</option>
                <?php foreach ($levels as $level) { ?>
                    <option value="<?php echo $level["code"] ?>"><?php echo $level["description"] ?></option>
                <?php } ?>
            </select>            
        </div>
    </div>
    <label><?php echo lang('form_classes_x_week'); ?></label>
    <div class="row-fluid">
        <div class="span2">
            <label class="checkbox">
                <input type="checkbox" data-bind="checked: monday() == 1, event: {change: function (data, event) { $root.changeDay(monday, event);} }">
                <?php echo lang('form_monday'); ?>
            </label>
        </div>
        <div class="span2">
            <label class="checkbox">
                <input type="checkbox" data-bind="checked: tuesday() == 1, event: {change: function (data, event) { $root.changeDay(tuesday, event);} }">
                <?php echo lang('form_tuesday'); ?>
            </label>
        </div>
        <div class="span2">
            <label class="checkbox">
                <input type="checkbox" data-bind="checked: wednesday() == 1, event: {change: function (data, event) { $root.changeDay(wednesday, event);} }">
                <?php echo lang('form_wednesday'); ?>
            </label>
        </div>
        <div class="span2">
            <label class="checkbox">
                <input type="checkbox" data-bind="checked: thursday() == 1, event: {change: function (data, event) { $root.changeDay(thursday, event);} }">
                <?php echo lang('form_thursday'); ?>
            </label>
        </div>
        <div class="span2">
            <label class="checkbox">
                <input type="checkbox" data-bind="checked: friday() == 1, event: {change: function (data, event) { $root.changeDay(friday, event);} }">
                <?php echo lang('form_friday'); ?>
            </label>
        </div>
        <div class="span2">
            <label class="checkbox">
                <input type="checkbox" data-bind="checked: saturday() == 1, event: {change: function (data, event) { $root.changeDay(saturday, event);} }">
                <?php echo lang('form_saturday'); ?>
            </label>
        </div>
    </div>
</div>
<div id="studentData" class="tab-pane" >
    <div class="row-fluid">
        <div class="span4">
            <label><?php echo lang('form_view_as'); ?></label>
            <div class="btn-group" data-toggle="buttons-radio">
                <button class="btn" data-bind="click: setViewStudentsAsList.bind($data, false), css: {active: ! viewStudentsAsList() }"><i class="icon-th"></i> <?php echo lang('subject_photo'); ?></button>
                <button class="btn" data-bind="click: setViewStudentsAsList.bind($data, true), css: {active: viewStudentsAsList() }" ><i class="icon-th-list"></i> <?php echo lang('subject_listing'); ?></button>
            </div>
        </div>
        <div class="span2" data-bind="visible: viewStudentsAsList()">
            <label>&nbsp;</label>
            <button type="button" class="btn btn-small " data-target="_blank" 
                data-bind="enable: $root.currentGroup().id()>0, click: $root.printStudents">
                <i class="icon-print"></i> <?php echo lang('btn_print'); ?>
            </button>
        </div>
    </div>
    <div class="alert" data-bind="visible: overbooking">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo lang('message_warning_overbooking') ?>
    </div>
    <ul class="list thumbnails" data-bind="foreach: studentList, visible: ! viewStudentsAsList()">        
        <li class="medium">
            <a href="#" class="thumbnail" data-bind="click: $root.selectStudent">
                <img  alt="" 
                      data-bind="attr: {src: picture() && picture() != '' ? '/assets/uploads/files/contact/' + picture() : '/assets/img/personal.png'}">
            </a>
            <p data-bind="text: full_name_lastname()" class="name"></p>
        </li>
    </ul>
    <table id="tblInternal" class="table table-bordered table-hover table-condensed table-striped" data-bind="visible: viewStudentsAsList()">
        <thead>
            <tr>
                <th></th>
                <th><?php echo lang('form_name'); ?></th>
            </tr>
        </thead>
        <tbody data-bind="foreach: studentList">
            <tr data-bind="click: $root.selectStudent">
                <td data-bind="text: $index() + 1"></td>
                <td data-bind="text: full_name_lastname()"></td>
            </tr>
        </tbody>
    </table>
    <div class="row-fluid">
        <legend data-bind="with: currentStudent">
            <span data-bind="text: full_name_lastname() + '&nbsp;'"></span>
            <div class="pull-right">
                <button class="btn btn-small" data-bind="click: $root.newStudent, visible: $root.canAddMoreStudents">
                    <i class="icon-plus-sign"></i> <?php echo lang('btn_new'); ?>
                </button>
                <button class="btn btn-small btn-success" data-bind="click: $root.saveStudent, visible: $root.canAddMoreStudents">
                    <i class="icon-ok-sign icon-white"></i> <?php echo lang('btn_save'); ?>
                </button>
                <button class="btn btn-small btn-danger" data-bind="click: $root.removeStudent">
                    <i class="icon-minus-sign icon-white"></i> <?php echo lang('btn_delete'); ?>
                </button>
            </div>
        </legend>
    </div>
    <div class="row-fluid" data-bind="with: currentStudent">
        <div class="span4">
            <label for="lbxRelationship"><?php echo lang('menu_student'); ?></label>
            <select id="lbxRelationship" class="input-block-level" data-bind="value: contact_id">
                <option value="">--</option>
                <?php foreach ($students as $student) { ?>
                    <option value="<?php echo $student["contact_id"] ?>"><?php echo $student["first_name"] . ' ' . $student["last_name"] ?></option>
                <?php } ?>
            </select>
        </div> 
    </div>
</div>
<?php $this->load->view('manager/group_admin_extra_tabs_content_assistance') ?>
