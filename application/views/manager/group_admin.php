<?php
$extra_tabs = 'manager/group_admin_extra_tabs';
$extra_tabs_content = 'manager/group_admin_extra_tabs_content';
?>
<form id="frm" action="" method="POST">
    <div class="container container-first">
        <div class="title-bar">
            <div id="msgFeedback" class="feedback top">
            </div>
            <h1><?php echo $title; ?></h1>
        </div>
        <div class="row">
            <div class="span3">
                <legend>
                    <?php echo $subject; ?>
                    <div class="btn-toolbar pull-right">
                        <button class="btn btn-small pull-right" data-bind="click: newGroup">
                            <i class="icon-plus-sign"></i> <?php echo lang('btn_new'); ?>
                        </button>
                    </div>
                </legend>
                <div class="row-fluid">            
                    <input id="appendedInputButtons" type="text" class="span*" placeholder="<?php echo lang('form_type_filter'); ?>" data-bind="value: filter">
                </div>

                <table id="tblContacts" class="table table-bordered table-hover table-condensed cursor-pointer">
                    <thead>
                        <tr>
                            <th><?php echo lang('form_name'); ?></th>
                        </tr>
                    </thead>            
                    <tbody data-bind="foreach: filteredGroups">
                        <tr data-bind="click: $root.selectGroup">
                            <td data-bind="text: name"></td>
                        </tr>    
                    </tbody>
                </table>

                <div class="row-fluid">
                    <legend><?php echo lang('subject_filter') ?></legend>
                    <div class="accordion" id="acFilter">
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#acFilter" href="#collapseOne">
                                    <?php echo lang('form_academic_period') ?>
                                </a>
                            </div>
                            <div id="collapseOne" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <select class="input-block-level" data-bind="value: filterByAcademicPeriod">
                                        <option value=""><?php echo lang('filter_all') ?></option>
                                        <?php foreach ($academic_periods as $period) { ?>
                                            <option value="<?php echo $period["code"] ?>" 
                                            <?php echo $period["code"] == $defaultAcademicPeriod ? "selected" : "" ?>
                                                    >
                                                        <?php echo $period["name"] ?>
                                            </option>
                                        <?php } ?>
                                    </select>   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span9">
                <legend data-bind="with: currentGroup">
                    <span class="title-item-select" data-bind="text: name() + '&nbsp;'"></span>
                    <div class="pull-right">
                        <button class="btn btn-small btn-success" data-bind="click: $root.saveGroup">
                            <i class="icon-ok-sign icon-white"></i> <?php echo lang('btn_save'); ?>
                        </button>
                        <button class="btn btn-small btn-danger" data-bind="click: $root.removeGroup">
                            <i class="icon-minus-sign icon-white"></i> <?php echo lang('btn_delete'); ?>
                        </button>
                        <button type="button" class="btn btn-small " data-target="_blank" 
                                data-bind="click: $root.printGroups">
                            <i class="icon-print"></i> <?php echo lang('btn_print'); ?>
                        </button>
                    </div>
                </legend>
                <ul id="tbContactData" class="nav nav-tabs">                    
                    <?php
                    if (isset($extra_tabs))
                        $this->load->view($extra_tabs)
                        ?>
                </ul>
                <div class="tab-content">                   
                    <?php
                    if (isset($extra_tabs_content))
                        $this->load->view($extra_tabs_content)
                        ?>
                </div>
            </div>
        </div>
    </div>
</form>
