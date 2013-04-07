<div class="jumbotron subhead">
    <div class="container">
        <h1>Información de contacto</h1>
        <p class="lead">¿Agluna sugerencia, crítica, solicitud de información...?</p>
    </div>
</div>
<div class="container pcontent">
    <div class="row">
        <form class="span5 well">
            <fieldset>
                    <label><?php echo lang('form_name'); ?></label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span><input type="text" class="span3" placeholder="Nombre completo"></div>
                    <label><?php echo lang('form_email'); ?></label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-envelope"></i></span><input type="text" class="span3" placeholder="Tu dirección de Email"></div>
                    <label><?php echo lang('form_subject'); ?></label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-question-sign"></i></span>
                        <select id="subject" name="subject" class="span3">
                            <option value="na" selected="">Seleccione el motivo de su mensaje:</option>
                            <option value="information">Solicitud de información</option>
                            <option value="suggestions">Sugerencias</option>
                            <option value="report">Reporte de error o incidencia</option>
                            <option value="otro">Otro asunto</option>
                        </select>
                    </div>
                    <label><?php echo lang('form_message'); ?></label>
                    <textarea name="message" id="message" class="span5" rows="10"></textarea>
                    <label class="checkbox">
                        <input type="checkbox"> He leído la política de privacidad y comprendo que CasabeSoft no hará ningún uso de mis datos, salvo para ponerse en contacto conmigo.
                    </label>
                    <button type="submit" class="btn btn-kprimary"><?php echo lang('btn_send'); ?></button>
            </fieldset>
        </form>
        <div class="span5 pull-right">
            <iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://www.openstreetmap.org/export/embed.html?bbox=-3.7296,40.4023,-3.6752,40.4294&amp;layer=mapquest" style="border: 1px solid black"></iframe><br /><small><a href="http://www.openstreetmap.org/?lat=40.41585&amp;lon=-3.7024&amp;zoom=14&amp;layers=Q">Ver mapa m&#225;s grande</a></small>
        </div>
    </div>
</div>
