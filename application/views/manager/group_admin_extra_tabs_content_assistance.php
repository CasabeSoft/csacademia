<div id="groupAssistance" class="tab-pane" data-bind="">
    <div class="row-fluid">
        <div class="span4">
            <label><?php echo lang('form_date'); ?></label>
            <input type="text" class="input-block-level" 
                placeholder="<?php echo lang('date_format_humans') ?>"
                data-bind="value: currentDate, jqDatepicker: new Date()">
        </div>
        <div class="span3">
            <label><?php echo lang('form_attendance'); ?></label>
            <div class="btn-group" data-toggle="buttons-radio">
                <button type="button" class="btn" data-bind="click: setViewDailyAttendance.bind($data, true), css: {active: viewDailyAttendance() }"><img src="/assets/img/icon-calendar-day.png" class="icon-"> Día</button>
                <button type="button" class="btn" data-bind="click: setViewDailyAttendance.bind($data, false), css: {active: !viewDailyAttendance() }" ><i class="icon-calendar"></i> Mes</button>
            </div>
        </div>        
        <div class="span4" data-bind="visible: viewDailyAttendance">
            <label><?php echo lang('form_view_as'); ?></label>
            <div class="btn-group" data-toggle="buttons-radio">
                <button type="button" class="btn" data-bind="click: setViewStudentsAsList.bind($data, false), css: {active: ! viewStudentsAsList() }"><i class="icon-th"></i> Fotos</button>
                <button type="button" class="btn" data-bind="click: setViewStudentsAsList.bind($data, true), css: {active: viewStudentsAsList() }" ><i class="icon-th-list"></i> Listado</button>
            </div>
        </div>
    </div>
    <ul class="list thumbnails" data-bind="foreach: currentList, visible: viewDailyAttendance() && ! viewStudentsAsList()">
        <li class="medium">
            <a href="#" class="thumbnail">
                <input type="checkbox">
              <img data-bind="attr: {src: picture() != '' ? '/assets/uploads/files/contact/' + picture() : '/assets/img/personal.png'}">
            </a>
            <p data-bind="text: full_name()" class="name"></p>
        </li>
    </ul>
    <table class="table table-bordered table-hover" data-bind="visible: viewDailyAttendance() && viewStudentsAsList()">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Asistencia</th>
            </tr>
        </thead>
        <tbody data-bind="foreach: currentList">
            <tr>
                <td data-bind="text: $index() + 1"></td>
                <td data-bind="text: full_name()"></td>
                <td><input type="checkbox"></td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered table-hover" data-bind="visible: ! viewDailyAttendance()">
        <thead>
            <tr>
                <th rowspan="2">#</th>
                <th rowspan="2">Nombre</th>
                <th colspan="31">Asistencia <span data-bind="text: getCurrentMonth()"></span></th>
            </tr>
            <tr data-bind="foreach: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]">
                <th data-bind="text: $data"></th>
            </tr>            
        </thead>
        <tbody data-bind="foreach: currentList">
            <tr>
                <td data-bind="text: $index() + 1"></td>
                <td data-bind="text: full_name()"></td>
                <!-- ko foreach: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16] -->
                <td><input type="checkbox"></td>
                <!-- /ko -->
            </tr>
        </tbody>
    </table>
</div>
