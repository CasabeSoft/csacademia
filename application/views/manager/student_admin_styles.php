<?php $this->load->view('manager/contact_admin_styles'); ?>
<style>
    #currentFamilyDetails .noSoImportant { display: none }
    #currentFamilyDetails #txtNotes { min-height: 95px; }
    
    fieldset.scheduler-border {
        border: 1px groove #ddd !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow:  0px 0px 0px 0px #000;
        box-shadow:  0px 0px 0px 0px #000;
        font-size: 0.5em !important;
    }

    legend.scheduler-border {
        width:inherit; /* Or auto */
        padding:0 10px; /* To give a bit of padding on the left and right */
        border-bottom:none;
    } 
    
    #lbxPeriod > input {
        margin-bottom: 0;
    }
    #lbxPeriod > ul {
        max-height: 120px;
        overflow-y: scroll;
    }
</style>