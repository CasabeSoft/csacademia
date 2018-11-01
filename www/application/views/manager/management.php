<div class="container container-first">
    <h1>Gestión</h1>

    <div class="btn-toolbar">
        <button class="btn btn-primary">Adicionar</button>
        <button class="btn">Exportar</button>
    </div>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th style="width: 36px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($extra_info["table"] as $row) { ?>
                <tr>
                    <td><?php echo $row[0]?></td>
                    <td><?php echo $row[1]?></td>
                    <td><?php echo $row[2]?></td>
                    <td><?php echo $row[3]?></td>
                    <td>
                        <a href="#"><i class="icon-pencil"></i></a>
                        <a href="#delConfirmation" role="button" data-toggle="modal"><i class="icon-remove"></i></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    <div class="pagination">
        <ul>
            <li><a href="#">Prev</a></li>
            <?php for ($i = 1; $i <= $extra_info["num_pages"]; $i++) { ?>
            <li><a href="#"><?php echo $i ?></a></li>
            <?php } ?>
            <li><a href="#">Next</a></li>
        </ul>
    </div>
    <div class="modal small hide fade" id="delConfirmation" tabindex="-1" role="dialog" aria-labelledby="lblTitle" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="lblTitle">Confirmaci&oacute;n</h3>
        </div>
        <div class="modal-body">
            <p class="error-text">Está seguro que quiere elminar el usuario?</p>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-danger" data-dismiss="modal">Eliminar</button>
        </div>
    </div>
</div>