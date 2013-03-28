<style>
    .newComponentGroup {
        margin-top: 20px;
        border-top: 1px solid #e5e5e5;
        padding-top: 20px;
    }
    #txtNotes {
        min-height: 266px;        
    }
    #picture { 
        display: inline;
        position: relative; 
    }
    #picture a {
        color: black;
        position: absolute;
        text-decoration: underline;
        height: 20px;
        top: 50%;
        margin-top: -10px;
        left: 3px;
        right: 3px;
        text-align: center;
        visibility: hidden;
        background-color: rgba(255, 255, 255, 0.75);
    }
    #picture:hover img {
        border-color: rgba(130, 182, 222, 0.870588);
    }
    #picture:hover a {
        visibility: visible;
    }
</style>
<div class="container  container-first">
<h1><?php echo $title ?></h1>
<div class="row">
    <div class="span3">
    <form>
        <legend>Contactos <button class="btn pull-right"><i class="icon-plus-sign"></i></button></legend>
        <div class="row-fluid">            
            <input id="appendedInputButtons" type="text" class="span*" placeholder="Filtro de búsqueda">
        </div>
        <table class="table table-bordered table-hover table-condensed">
            <thead>
                <tr>
                    <th>Nombre</th>
                </tr>
            </thead>            
            <tbody>
                <tr>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </form>
    </div>
    <div class="span9">
    <form>
        <fieldset>
            <legend>Nombre completo</legend>
            <input type="hidden" id="cnt_id" />
            <div class="row-fluid">
                <div class="span8">
                    <div class="row-fluid">
                        <div class="span6">
                            <label for="txtFirstname">Nombre</label>
                            <input type="text" id="txtFirstname" placeholder="Nombre" class="input-block-level">
                        </div>
                        <div class="span6">
                            <label for="txtLastname">Apellidos</label>
                            <input type="text" id="txtLastname" placeholder="Apellidos" class="input-block-level">
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span6">
                            <label for="txtDateOfBirth">Fecha de nacimiento</label>
                            <input type="text" id="txtDateOfBirth" class="input-block-level" placeholder="dd/MM/aaaa">
                        </div>                        
                        <div class="span6">
                            <label for="lbxGender">Género</label>
                            <select id="lbxGender" class="input-block-level">
                                <option>Sin especificar</option>
                                <option>Masculino</option>
                                <option>Femenino</option>
                            </select>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span6">
                            <label for="txtIdCard">DNI / NIE / NIF / Pasaporte </label>
                            <input type="text" id="txtIdCard" placeholder="Número de identidad" class="input-block-level">
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
                            <input type="text" id="txtPhoneMobile" placeholder="Número de teléfono" class="input-block-level">
                        </div>
                        <div class="span6">
                            <label for="txtPhone">Teléfono</label>
                            <input type="text" id="txtPhone" placeholder="Número de teléfono" class="input-block-level">
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span6">
                            <label for="txtEmail">E-mail</label>
                            <input type="text" id="txtEmail" placeholder="Correo electrónico" class="input-block-level">
                        </div>
                        <div class="span6">
                            <label for="txtOccupation">Ocupación</label>
                            <input type="text" id="txtOccupation" placeholder="Ocupación" class="input-block-level">
                        </div>
                    </div>
                    <div class="row-fluid newComponentGroup">
                        <div class="span*">
                            <label for="txtAddress">Dirección</label>
                            <input type="text" id="txtAddress" placeholder="Calle, número, puerta..." class="input-block-level">
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span2">
                            <label for="txtPostCode">C.P.</label>
                            <input type="text" id="txtPostCode" placeholder="Código postal" class="input-block-level">
                        </div>
                        <div class="span5">
                            <label for="txtTown">Localidad</label>
                            <input type="text" id="txtTown" placeholder="Localidad" class="input-block-level">
                        </div>
                        <div class="span5">
                            <label for="txtProvince">Provincia</label>
                            <input type="text" id="txtProvince" placeholder="Provincia" class="input-block-level">
                        </div>
                    </div>
                </div>
                <div class="span4">
                    <label>Notas</label>
                    <textarea id="txtNotes" class="input-block-level"></textarea>
                </div>
            </div>
        </fieldset>
    </form>
    </div>
</div>
</div>
