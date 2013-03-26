<div class="container container-first">
<h1><?php echo $title ?></h1>
<div class="row">
    <form class="span3">
        <fieldset>
            <legend>Contactos <button class="btn pull-right"><i class="icon-plus-sign"></i></button></legend>
            <div class="input-prepend">
                <span class="add-on"><i class="icon-search"></i></span>
                <input id="appendedInputButtons" type="text">
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
        </fieldset>
    </form>
    <form class="span9">
        <fieldset>
            <legend>Detalles del contacto</legend>
            <input type="hidden" id="cnt_id" />
            <h3>Nombre completo</h3>
            <div class="row-fluid">
                <div class="span8">
                    <div class="row-fluid">
                        <div class="span6">
                            <label for="txtFirstname">Nombre</label>
                            <input type="text" id="txtFirstname" placeholder="Nombre" class="span12">
                        </div>
                        <div class="span6">
                            <label for="txtLastname">Apellidos</label>
                            <input type="text" id="txtLastname" placeholder="Apellidos" class="span12">
                        </div>
                    </div>
                    <label for="txtOccupation">Ocupación</label>
                    <input type="text" id="txtOccupation" placeholder="Ocupación">
                </div>
                <div class="span4">
                    <div class="row-fluid">
                        <img src="/assets/img/personal.png" class="img-polaroid" />
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</div>
</div>
