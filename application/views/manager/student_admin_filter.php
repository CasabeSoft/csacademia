<div class="row-fluid">
    <legend><?php echo lang('subject_filter')?></legend>
    <div class="accordion" id="acFilter">
        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#acFilter" href="#collapseOne">
                    <?php echo lang('form_state')?>
                </a>
            </div>
            <div id="collapseOne" class="accordion-body collapse">
                <div class="accordion-inner">
                    <div class="btn-group" data-toggle="buttons-radio">
                        <button type="button" class="btn active" data-bind="click: filterByState.bind($data, true)"><?php echo lang('btn_active')?></button>
                        <button type="button" class="btn" data-bind="click: filterByState.bind($data, false)" ><?php echo lang('btn_inactive')?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
