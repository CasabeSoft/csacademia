<?php if ($this->role_id == ROLE_ADMINISTRATOR || $this->role_id == ROLE_MANAGER) { ?>
    <li><a href="#professionalData" data-bind="click: $root.activateTab"><?php echo lang('subject_professional_data'); ?></a></li>
<?php } ?>