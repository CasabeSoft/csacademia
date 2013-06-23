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
                    <div id="rdState">
                        <input type="radio" id="rdActive" name="rdState" checked="checked" value="true" /><label for="rdActive"><?php echo lang('btn_active')?></label>
                        <input type="radio" id="rdInactive" name="rdState" value="false" /><label for="rdInactive"><?php echo lang('btn_inactive')?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
