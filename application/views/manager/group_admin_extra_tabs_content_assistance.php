<div id="groupAssistance" class="tab-pane" data-bind="">
    <h1>Asistencia</h1>
    <div class="row-fluid">
        <div class="span4">
            <label><?php echo lang('form_date_of_birth'); ?></label>
            <input type="text" class="input-block-level" 
                placeholder="<?php echo lang('date_format_humans') ?>"
                data-bind="jqDatepicker: new Date()">
        </div>
        <div class="span4">
            <label><?php echo lang('form_view_as'); ?></label>
            <div class="btn-group">
                <a class="btn active"><i class="icon-th"></i></a>
                <a class="btn"><i class="icon-th-list"></i></a>
            </div>
        </div>
    </div>
    <ul class="list thumbnails" data-bind="foreach: currentList">
        <li class="medium">
          <a href="#" class="thumbnail">
            <img data-bind="attr: {src: picture() != '' ? '/assets/uploads/files/contact/' + picture() : '/assets/img/personal.png'}">
          </a>
        </li>
    </ul>
</div>
