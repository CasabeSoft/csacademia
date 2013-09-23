<div id="groupAssistance" class="tab-pane" data-bind="">
    <div class="row-fluid">
        <div class="span3">
            <label><?php echo lang('form_date'); ?></label>
            <input type="text" class="input-block-level" 
                placeholder="<?php echo lang('date_format_humans') ?>"
                data-bind="value: currentDate, jqDatepicker: new Date(), event: {change: onCurrentDateChange}">
        </div>
        
        <div class="span3">
            <label><?php echo lang('form_attendance'); ?></label>
            <div class="btn-group" data-toggle="buttons-radio">
                <button class="btn" data-bind="click: setViewDailyAttendance.bind($data, true), css: {active: viewDailyAttendance() }"><img src="/assets/img/icon-calendar-day.png" class="icon-"> Día</button>
                <button class="btn" data-bind="click: setViewDailyAttendance.bind($data, false), css: {active: !viewDailyAttendance() }" ><i class="icon-calendar"></i> Mes</button>
            </div>
        </div>   
        
        <div class="span3" data-bind="visible: viewDailyAttendance">
            <label><?php echo lang('form_view_as'); ?></label>
            <div class="btn-group" data-toggle="buttons-radio">
                <button class="btn" data-bind="click: setViewStudentsAsList.bind($data, false), css: {active: ! viewStudentsAsList() }"><i class="icon-th"></i> Fotos</button>
                <button class="btn" data-bind="click: setViewStudentsAsList.bind($data, true), css: {active: viewStudentsAsList() }" ><i class="icon-th-list"></i> Listado</button>
            </div>
        </div>
        <div class="span2" data-bind="visible: ! viewDailyAttendance()">
            <label>&nbsp;</label>
            <button type="button" class="btn btn-small " data-target="_blank" 
                data-bind="enable: $root.currentGroup().id()>0, click: $root.printAttendance">
                <i class="icon-print"></i> <?php echo lang('btn_print'); ?>
            </button>
        </div>
    </div>
    <ul class="list thumbnails" data-bind="foreach: studentList, visible: viewDailyAttendance() && ! viewStudentsAsList()">
        <li class="medium">
            <a href="#" class="thumbnail">
                <input type="checkbox" data-bind="checked: $root.attended(contact_id(), $root.currentDate()), event: {change: function (data, event) { $root.onAttendanceDayChange(contact_id(), $root.currentDate(), event); }}">
                <img data-bind="attr: {src: picture() && picture() != '' ? '/assets/uploads/files/contact/' + picture() : '/assets/img/personal.png'}">
            </a>
            <p data-bind="text: full_name()" class="name"></p>
        </li>
    </ul>
    <table id="tblInternal" class="table table-bordered table-hover table-condensed" data-bind="visible: viewDailyAttendance() && viewStudentsAsList()">
        <thead>
            <tr>
                <th></th>
                <th><?php echo lang('form_name'); ?></th>
                <th><?php echo lang('form_attendance'); ?></th>
            </tr>
        </thead>
        <tbody data-bind="foreach: studentList">
            <tr>
                <td data-bind="text: $index() + 1"></td>
                <td data-bind="text: full_name()"></td>
                <td><input type="checkbox" data-bind="checked: $root.attended(contact_id(), $root.currentDate()), event: {change: function (data, event) { $root.onAttendanceDayChange(contact_id(), $root.currentDate(), event); }}"></td>
            </tr>
        </tbody>
    </table>
    <table id="tblInternal" class="table table-bordered table-hover table-condensed" data-bind="visible: ! viewDailyAttendance()">
        <thead>
            <tr>
                <th rowspan="3"></th>
                <th rowspan="3"><?php echo lang('form_name'); ?></th>
                <th data-bind="attr: {colspan: attendanceDays().length}"><?php echo lang('form_attendance'); ?> <span data-bind="text: getCurrentMonth()"></span></th>
            </tr>
            <tr data-bind="foreach: attendanceDays">
                <th data-bind="text: name"></th>
            </tr> 
            <tr data-bind="foreach: attendanceDays">
                <th data-bind="text: number"></th>
            </tr>             
        </thead>
        <tbody data-bind="foreach: studentList">
            <tr>
                <td data-bind="text: $index() + 1"></td>
                <td data-bind="text: full_name()"></td>
                <!-- ko foreach: $root.attendanceDays -->
                <td><input type="checkbox" data-bind="checked: $root.attended($parent.contact_id(), $root.genAttendanceDate(number)), event: {change: function (data, event) { $root.onAttendanceDayChange($parent.contact_id(), $root.genAttendanceDate(number), event); }}"></td>
                <!-- /ko -->
            </tr>
        </tbody>
    </table>
</div>
