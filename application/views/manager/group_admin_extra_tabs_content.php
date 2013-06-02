<div id="generalData" class="tab-pane active" data-bind="with: currentGroup">
    <input type="hidden" id="cnt_id" data-bind="value: id" />
    <div class="row-fluid">
        <div class="span2 control-group">
            <label for="txtName" class="control-label"><?php echo lang('form_name'); ?></label>
            <input type="text" id="txtName" placeholder="<?php echo lang('form_name'); ?>" class="input-block-level"
                   data-bind="value: name" required >
        </div>
        <div class="span2">
            <label for="lbxClassroom"><?php echo lang('form_classroom'); ?></label>
            <select id="lbxClassroom" class="input-block-level" data-bind="value: classroom_id">
                <option value="">--</option>
                <?php foreach ($classrooms as $classroom) { ?>
                    <option value="<?php echo $classroom["id"] ?>"><?php echo $classroom["id"] ?></option>
                <?php } ?>
            </select>            
        </div>
        <div class="span3">
            <label for="lbxCenter"><?php echo lang('form_center'); ?></label>
            <select id="lbxCenter" class="input-block-level" data-bind="value: center_id">
                <option value="">--</option>
                <?php foreach ($centers as $center) { ?>
                    <option value="<?php echo $center["id"] ?>"><?php echo $center["name"] ?></option>
                <?php } ?>
            </select>            
        </div>

        <div class="span5">
            <label for="lbxTeacher"><?php echo lang('form_teacher'); ?></label>
            <select id="lbxTeacher" class="input-block-level" data-bind="value: teacher_id">
                <option value="">--</option>
                <?php foreach ($teachers as $teacher) { ?>
                    <option value="<?php echo $teacher["contact_id"] ?>"><?php echo $teacher["full_name"] ?></option>
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
        <div class="span3">
            <label for="lbxAcademicPeriod"><?php echo lang('form_academic_period'); ?></label>
            <select id="lbxAcademicPeriod" class="input-block-level" data-bind="value: academic_period">
                <option value="">--</option>
                <?php foreach ($academic_periods as $period) { ?>
                    <option value="<?php echo $period["code"] ?>"><?php echo $period["name"] ?></option>
                <?php } ?>
            </select>            
        </div>
        <div class="span5">
            <label for="lbxLevel"><?php echo lang('form_level'); ?></label>
            <select id="lbxLevel" class="input-block-level" data-bind="value: level_code">
                <option value="">--</option>
                <?php foreach ($levels as $level) { ?>
                    <option value="<?php echo $level["code"] ?>"><?php echo $level["description"] ?></option>
                <?php } ?>
            </select>            
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">
            <label for="lbxmonday"><?php echo lang('form_monday'); ?></label>
            <select id="lbxmonday" class="input-block-level" data-bind="value: monday">
                <option value="">--</option>
                <option value="1"><?php echo lang('btn_yes'); ?></option>
                <option value="0"><?php echo lang('btn_no'); ?></option>
            </select> 
        </div>
        <div class="span2">
            <label for="lbxtuesday"><?php echo lang('form_tuesday'); ?></label>
            <select id="lbxtuesday" class="input-block-level" data-bind="value: tuesday">
                <option value="">--</option>
                <option value="1"><?php echo lang('btn_yes'); ?></option>
                <option value="0"><?php echo lang('btn_no'); ?></option>
            </select>
        </div>
        <div class="span2">
            <label for="lbxwednesday"><?php echo lang('form_wednesday'); ?></label>
            <select id="lbxwednesday" class="input-block-level" data-bind="value: wednesday">
                <option value="">--</option>
                <option value="1"><?php echo lang('btn_yes'); ?></option>
                <option value="0"><?php echo lang('btn_no'); ?></option>
            </select>
        </div>
        <div class="span2">
            <label for="lbxthursday"><?php echo lang('form_thursday'); ?></label>
            <select id="lbxthursday" class="input-block-level" data-bind="value: thursday">
                <option value="">--</option>
                <option value="1"><?php echo lang('btn_yes'); ?></option>
                <option value="0"><?php echo lang('btn_no'); ?></option>
            </select>
        </div>
        <div class="span2">
            <label for="lbxfriday"><?php echo lang('form_friday'); ?></label>
            <select id="lbxfriday" class="input-block-level" data-bind="value: friday">
                <option value="">--</option>
                <option value="1"><?php echo lang('btn_yes'); ?></option>
                <option value="0"><?php echo lang('btn_no'); ?></option>
            </select>
        </div>
        <div class="span2">
            <label for="lbxsaturday"><?php echo lang('form_saturday'); ?></label>
            <select id="lbxsaturday" class="input-block-level" data-bind="value: saturday">
                <option value="">--</option>
                <option value="1"><?php echo lang('btn_yes'); ?></option>
                <option value="0"><?php echo lang('btn_no'); ?></option>
            </select>
        </div>
    </div>
</div>
<div id="studentData" class="tab-pane" >
    <div class="row-fluid">
        
        <ul class="family thumbnails">
            <!-- ko foreach: studentList -->
            <li class="span2">
                <a href="#" class="thumbnail" data-bind="click: $root.selectStudent">
                    <img  alt="" 
                          data-bind="attr: {src: picture() != '' ? '/assets/uploads/files/contact/' + picture() : '/assets/img/personal.png'}">
                </a>
                <strong data-bind="text: first_name"></strong>
            </li>
            <!-- /ko -->
            <li class="span2 add">
                <a href="#" class="thumbnail" data-bind="click: $root.newStudent">
                    <div><img src="/assets/img/personal.png" alt=""></div>
                </a>
                <strong><?php echo lang('btn_new'); ?></strong>
                <p></p>
            </li>            
        </ul>
    </div>
</div>
