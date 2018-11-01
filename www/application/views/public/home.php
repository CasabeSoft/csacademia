<section class="cs-home">
    <article id="home" class="container">
        <header class="row">
            <div class="col-xs-6">
                <img src="/assets/img/logo_text_sm.png" alt="CSAcademia logo">
            </div>
            <div class="col-xs-6">
                <a href="#" id="lnkLogin" data-toggle="popover" data-placement="bottom">
                    <?php echo lang('menu_login'); ?>
                </a>
                <div id="loginTemplate">
                    <form class="login" method="POST" action="/login">
                        <fieldset>
                            <div class="form-group">
                                <input type="text" name="userName" id="userName" placeholder="Nombre de usuario" required class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="password" placeholder="Contraseña" required class="form-control">
                            </div>
                            <input type="submit" value="Entrar" class="btn btn-primary">
                            <button type="button" class="btn btn-default" data-bind="click: hideLogin">Cancelar</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </header>
        <div class="row call-4-action">
            <div class="col-sm-6">
                <img src="../assets/img/desktop-tablet-mobile.png" 
                     class="img-responsive center-block" alt="Software multiplataforma" />
            </div>
            <div class="col-sm-6">
                <p class="they">
                    Los Sistemas de Gestión Académica contribuyen a controlar 
                    la matrícula, evaluaciones periódicas y más...
                </p>
                <p class="us">CSAcademia te ayuda a <mark>ahorrar tiempo y dinero</mark>.</p>
                <form id="register">
                    <fieldset>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Nombre" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Correo electrónico" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Contraseña" required>
                        </div>
                        <label>
                            <input type="checkbox"> Acepto las condiciones del servicio
                        </label>
                    </fieldset>
                    <button type="button" class="btn btn-lg btn-primary" data-bind="attr: { type: startRole}, click: startRegistering">Comenzar ahora</button>
                </form>
            </div>
        </div>
        <a href="#features" class="cs-scroll-to">Más información <span class="caret"></span></a>    
    </article>
    <article id="features" class="container">
        <h2>¿Por qué usar CSAcademia?</h2>
        <div class="row" data-template="featureTemplate" data-bind="source: data.features">
            <script id="featureTemplate" type="text/x-kendo-template">
            <div class="media col-sm-6">
                <div class="media-left">
                    <a href="\#">
                        <img class="media-object" data-bind="attr: {src: image, alt: name}">
                    </a>
                </div>
                <div class="media-body">
                  <h3 class="media-heading" data-bind="text: name"></h3>
                  <p data-bind="text: description"></p>
                </div>
            </div>
            </script>
        </div>
        <div class="row call-4-action">
            <p>¿Si ya lo tienes más claro? Entonces...</p>
            <div class="col-sm-5">
                <a href="#home" class="btn-block btn btn-lg btn-primary cs-scroll-to" data-bind="click: startRegistering">Comienza a usar CSAcademia</a>
            </div>
            <div class="col-sm-2 separator">
                o
            </div>
            <div class="col-sm-5">
                <a href="#contact" class="btn-block btn btn-lg btn-default cs-scroll-to">Pide más información</a>
            </div>
        </div>
    </article>
    <article id="prices" class="container">
        <h2>Precios</h2>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#centers" aria-controls="centers" role="tab" data-toggle="tab">Para centros educativos</a></li>
            <li role="presentation"><a href="#teachers" aria-controls="teachers" role="tab" data-toggle="tab">Para profesores</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="centers">
                <div data-template="planTemplate" class="row" data-bind="source: data.schoolPlans">
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="teachers">
                <div data-template="planTemplate" class="row" data-bind="source: data.teacherPlans">
                </div>
            </div>
            <script id="planTemplate" type="text/x-kendo-template">
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading" data-bind="text: name">
                        </div>
                        <div class="panel-body">
                            <p>
                                <span data-bind="text: for"></span> desde <span data-bind="text: min"></span>
                                <span data-bind="visible: max">hasta <span data-bind="text: max"></span></span>
                                <span data-bind="invisible: max"> o más</span> alumnos.
                            </p>
                            <p><span data-bind="text: price"></span> €</p>  
                        </div>
                    </div>
                </div>                
            </script>
        </div>
    </article>
    <article id="contact" class="container">
        <h2>Déjanos tus datos y te escribiremos o llamaremos</h2>
        <form class="row" data-bind="events: {submit: onContactSubmit}">
            <fieldset class="col-md-6">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="<?php echo lang('form_full_name'); ?>" required data-bind="value: contact.name">
            </div>
            <div class="row">
                <div class="form-group col-sm-7">
                    <input type="email" class="form-control" placeholder="<?php echo lang('form_email_info'); ?>" required data-bind="value: contact.email">
                </div>
                <div class="form-group col-sm-1 hidden-xs separator">
                    o
                </div>
                <div class="form-group col-sm-4">
                    <input type="phone" class="form-control" placeholder="<?php echo lang('form_phone'); ?>" data-bind="value: contact.phone, events: { change: onPhoneChange}">
                </div>
            </div>
            <div class="form-group">
                <textarea class="form-control" rows="5" placeholder="<?php echo lang('form_message'); ?>" required data-bind="value: contact.message"></textarea>
            </div>
            <label>
                <input type="checkbox" required> He leído la política de privacidad y comprendo que CasabeSoft no hará ningún uso de mis datos, salvo para ponerse en contacto conmigo.
            </label>
            <button type="submit" class="btn btn-lg btn-primary">Enviar</button>
            </fieldset>
            <div role="alert" data-bind="visible: contactFeedback.text, attr: {class: contactFeedbackClass}" style="display: none">
                <p data-bind="text: contactFeedback.text"></p>
            </div>

        </form>
    </article>
    <article id="legal">
        Legal
    </article>
    <footer>
        <nav>
            <a href="#home" class="cs-scroll-to">Inicio</a>
            <a href="#prices" class="cs-scroll-to">Precios</a>
            <a href="#contact" class="cs-scroll-to">Contacto</a>
            <a href="/#/legal">Legal</a>
        </nav>
    </footer>
</section>
