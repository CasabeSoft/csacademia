<style>
    .newComponentGroup {
        margin-top: 40px;
        border-top: 1px solid #e5e5e5;
        padding-top: 20px;
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
                    <img src="/assets/img/personal.png" class="img-polaroid" />
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
                </div>
                <div class="span4">
                    <label>Notas</label>
                    <textarea class="input-block-level"></textarea>
                </div>
            </div>
        </fieldset>
    </form>
    </div>
</div>
</div>
