<?php 
$extra_tabs = 'manager/group_admin_extra_tabs';
$extra_tabs_content = 'manager/group_admin_extra_tabs_content';
?>
<form id="frm" action="" method="POST">
    <div class="container container-first">
        <div id="msgFeedback" class="feedback top">
        </div>
        <h1><?php echo $title; ?></h1>
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

                <table id="tblGroups" class="table table-bordered table-hover table-condensed">
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
            </div>
            <div class="span9">
                <legend data-bind="with: currentGroup">
                    <span data-bind="text: name() + '&nbsp;'"></span>
                    <div class="pull-right">
                        <button class="btn btn-small" data-bind="click: $root.saveGroup">
                            <i class="icon-ok-sign"></i> <?php echo lang('btn_save'); ?>
                        </button>
                        <button class="btn btn-small btn-danger" data-bind="click: $root.removeGroup">
                            <i class="icon-minus-sign icon-white"></i> <?php echo lang('btn_delete'); ?>
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
