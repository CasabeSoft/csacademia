<div class="container  container-first">
    <h1><?php echo $title ?></h1>
    <div class="row">
        <div class="span3">
            <legend>
                Contactos
                <div class="btn-toolbar pull-right">
                    <button class="btn btn-small pull-right" data-bind="click: newContact">
                        <i class="icon-plus-sign"></i> Nuevo
                    </button>
                </div>
            </legend>
            <div class="row-fluid">            
                <input id="appendedInputButtons" type="text" class="span*" placeholder="Teclee el filtro y presione [Enter]"
                       data-bind="value: filter">
            </div>
            <table id="tblContacts" class="table table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th>Nombre</th>
                    </tr>
                </thead>            
                <tbody data-bind="foreach: filteredContacts">
                    <tr data-bind="click: $root.selectContact">
                        <td data-bind="text: full_name()"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="span9" data-bind="with: currentContact">
            <legend>
                <span data-bind="text: full_name() + '&nbsp;'"></span>
                <div class="pull-right">
                    <button class="btn btn-small" data-bind="click: $root.saveContact">
                        <i class="icon-ok-sign"></i> Guardar
                    </button>
                    <button class="btn btn-small btn-danger" data-bind="click: $root.removeContact">
                        <i class="icon-minus-sign icon-white"></i> Eliminar
                    </button>
                </div>
            </legend>
            <ul id="tbContactData" class="nav nav-tabs">
                <li class="active"><a href="#generalData" data-bind="click: $root.activateTab">Datos generales</a></li>
                <li><a href="#academicData" data-bind="click: $root.activateTab">Académicos</a></li>
                <li><a href="#professionalData" data-bind="click: $root.activateTab">Profesionales</a></li>
            </ul>
            <div class="tab-content">
                <div id="generalData" class="tab-pane active">
                    <div class="row-fluid">
                        <div class="span8">
                            <input type="hidden" id="cnt_id" data-bind="value: id" />
                            <div class="row-fluid">
                                <div class="span6">
                                    <label for="txtFirstname">Nombre</label>
                                    <input type="text" id="txtFirstname" placeholder="Nombre" class="input-block-level"
                                           data-bind="value: first_name">
                                </div>
                                <div class="span6">
                                    <label for="txtLastname">Apellidos</label>
                                    <input type="text" id="txtLastname" placeholder="Apellidos" class="input-block-level"
                                           data-bind="value: last_name">
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <label for="txtDateOfBirth">Fecha de nacimiento</label>
                                    <input type="text" id="txtDateOfBirth" class="input-block-level" 
                                           placeholder="<?php echo lang('date_format_humans') ?>"
                                           data-bind="value: date_of_birth, jqDatepicker: date_of_birth">
                                </div>                        
                                <div class="span6">
                                    <label for="lbxGender">Género</label>
                                    <select id="lbxGender" class="input-block-level"
                                            data-bind="value: sex">
                                        <option value="U">Sin especificar</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <label for="txtIdCard">DNI / NIE / NIF / Pasaporte </label>
                                    <input type="text" id="txtIdCard" placeholder="Número de identidad" class="input-block-level"
                                           data-bind="value: id_card">
                                </div>                        
                            </div>
                        </div>
                        <div class="span4">
                            <div id="picture">
                                <img src="/assets/img/personal.png" class="img-polaroid" />
                                <a href="#">Cambiar imagen</a>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid newComponentGroup">
                        <div class="span8">
                            <div class="row-fluid">
                                <div class="span6">
                                    <label for="txtPhoneMobile">Teléfono móvil</label>
                                    <input type="text" id="txtPhoneMobile" placeholder="Número de teléfono" class="input-block-level"
                                           data-bind="value: phone_mobile">
                                </div>
                                <div class="span6">
                                    <label for="txtPhone">Teléfono</label>
                                    <input type="text" id="txtPhone" placeholder="Número de teléfono" class="input-block-level"
                                           data-bind="value: phone">
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <label for="txtEmail">E-mail</label>
                                    <input type="text" id="txtEmail" placeholder="Correo electrónico" class="input-block-level"
                                           data-bind="value: email">
                                </div>
                                <div class="span6">
                                    <label for="txtOccupation">Ocupación</label>
                                    <input type="text" id="txtOccupation" placeholder="Ocupación" class="input-block-level"
                                           data-bind="value: occupation">
                                </div>
                            </div>
                            <div class="row-fluid newComponentGroup">
                                <div class="span*">
                                    <label for="txtAddress">Dirección</label>
                                    <input type="text" id="txtAddress" placeholder="Calle, número, puerta..." class="input-block-level"
                                           data-bind="value: address">
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span2">
                                    <label for="txtPostCode">C.P.</label>
                                    <input type="text" id="txtPostCode" placeholder="Código postal" class="input-block-level"
                                           data-bind="value: postal_code">
                                </div>
                                <div class="span5">
                                    <label for="txtTown">Localidad</label>
                                    <input type="text" id="txtTown" placeholder="Localidad" class="input-block-level"
                                           data-bind="value: town">
                                </div>
                                <div class="span5">
                                    <label for="txtProvince">Provincia</label>
                                    <input type="text" id="txtProvince" placeholder="Provincia" class="input-block-level"
                                           data-bind="value: province">
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <label>Notas</label>
                            <textarea id="txtNotes" class="input-block-level" 
                                      data-bind="html: notes">
                            </textarea>
                        </div>
                    </div>
                </div>
                <div id="academicData" class="tab-pane">
                    <h1>Datos académicos</h1>
                </div>
                <div id="professionalData" class="tab-pane">
                    <h1>Datos profesionales</h1>
                </div>            
            </div>
        </div>
    </div>
</div>
