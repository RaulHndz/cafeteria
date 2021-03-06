<div class="title">Administraci&oacute;n de Clientes
    <button class="btn btn-default right" onclick="_add()">Añadir</button>
</div>
<div class="clear"></div>
<div class="navbar-form navbar-left" role="search">
    <div class="form-group"  style="width:500px !important;">
        <input type="search" class="form-control" id="txtBuscar" placeholder="Ingresar Datos..." style="width:500px !important;" >
    </div>
    <button class="btn btn-default" type="button" onclick="Search()">Buscar</button>
</div>
<div class="clear"></div>
<div class="table-responsive">
    <?php if($clients): ?>
    <table class="table table-bordered table-condensed table-hover">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Carnet</th>
                <th>Credito</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="wrapper_recibos">
        <?php foreach ($clients as $client): ?>
            <tr>
                <td>
                    <a href="#" onclick="viewProduct('<?php echo $client->codigo; ?>')"><?php echo $client->codigo; ?></a>
                </td>
                <td><?php echo $client->nombre; ?></td>
                <td><?php echo $client->telefono; ?></td>
                <td><?php echo $client->carnet; ?></td>
                <td>$<?php echo $client->credito; ?></td>
                <td><?php echo $client->estado; ?></td>
                <td align="center"><a href="#" onclick="_directEdit('<?php echo $client->codigo; ?>')" class="link-edit" title="Editar"></a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No se encontraron registros</p>
    <?php endif; ?>
</div>

<!--div class="fab-area">

    <div class="fab-mini-box">
        <div class="fab-container">
            <a href="<?php echo base_url(); ?>admin/creditlimit">
                <span for="new" class="label">Creditos</span>
                <div name="new" id="new" class="fab-mini">
                    <img src="<?php echo $assets_uri; ?>img/ic_folder_open_white_18dp.png" alt="Rec." />
                </div>
            </a>
        </div>
    </div>

    <div class="fab-normal" id="options">
        <img src="<?php echo $assets_uri; ?>img/bt_speed_dial_1x.png" alt="+" />
    </div>
</div-->
<a href="<?php echo base_url(); ?>admin/creditos">
    <div class="fab-normal" id="options">
        <img src="<?php echo $assets_uri; ?>img/bt_speed_dial_1x.png" alt="+" />
    </div>
</a>
<script>

    $("#txtBuscar").keyup(function(event){
        if(event.keyCode == 13){
            Search();
        }
    });

    function Search(){
        $('#wrapper_recibos').html('');   

        var _busqueda = $('#txtBuscar').val();
        var _url = "<?php echo base_url().'admin/buscarclients/'; ?>";
        $.ajax({
                url: _url,
                type: 'post',
                dataType: 'json',
                data: {busqueda: _busqueda}
        }).done(function(data)
        {
            $('#wrapper_recibos').html('');
            $(data).each(function(){
                $('#wrapper_recibos').append(   '<tr>'+
                                                '    <td>'+
                                                '        <a href="#" onclick="viewProduct('+this.codigo+')"><?php echo $client->codigo; ?></a>'+
                                                '    </td>'+
                                                '    <td>'+this.nombre+'</td>'+
                                                '    <td>'+this.telefono+'</td>'+
                                                '    <td>'+this.carnet+'</td>'+
                                                '    <td>$'+this.credito+'</td>'+
                                                '    <td>'+this.estado+'</td>'+
                                                '    <td align="center"><a href="#" onclick="_directEdit('+this.codigo+')" class="link-edit" title="Editar"></a></td>'+
                                                '</tr>');
                   

            });
        }).fail(function(){
            alert('Error');
        });
    }

    var _product_code = '';

    function _directEdit(_codigo)
    {
        _product_code = _codigo;
        _edit();
    }

    function viewProduct(_codigo)
    {
        var _url = base_url + 'ajax/get_client';
        $.ajax({url: _url, data : {codigo: _codigo}, type: 'post', dataType: 'json'}).done(function(data){

            _product_code = data.codigo;

            $('#vw_codigo').text(data.codigo);
            $('#vw_nombre').text(data.nombre);
            $('#vw_telefono').text(data.telefono);
            $('#vw_direccion').text(data.direccion);
            $('#vw_dui').text(data.dui);
            $('#vw_carnet').text(data.carnet);
            $('#vw_estado').text(data.estado);
            $('#vw_credito').text(data.credito);

            $('#view_product').modal('show');
        }).fail(function(){
            alert('Error');
        });
    }

    function _edit()
    {
        var _url = base_url + 'ajax/edit_client';
        $.ajax({url: _url, data : {codigo: _product_code}, type: 'post', dataType: 'json'}).done(function(data){

            _product_code = data.codigo;

            var _action = base_url + 'procesator/updateclient';
            $('#procesor').attr('action', _action);

            $('#sv_codigo').val(data.codigo);
            $('#sv_nombre').val(data.nombre);
            $('#sv_telefono').val(data.telefono);
            $('#sv_direccion').val(data.direccion);
            $('#sv_dui').val(data.dui);
            $('#sv_carnet').val(data.carnet);
            $('#sv_etado').val(data.estado);
            $('#sv_credito').val(data.credito);

            $('#view_product').modal('hide');
            $('#save_product').modal('show');
        }).fail(function(){
            alert('Error');
        });
    }

    function _add()
    {
        document.getElementById("procesor").reset();

        var _action = base_url + 'procesator/saveclient';
        $('#procesor').attr('action', _action);
        $('#sv_codigo').removeAttr('readonly');

        $('#save_product').modal('show');
    }
</script>

<!-- Modal de Visualizacion -->
<div id="view_product" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Datos del Cliente</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-condenced table-bordered">
                        <tr><th>Codigo</th><td><span id="vw_codigo"></span></td></tr>
                        <tr><th>Nombre</th><td><span id="vw_nombre"></span></td></tr>
                        <tr><th>Telefono</th><td><span id="vw_telefono"></span></td></tr>
                        <tr><th>Direccion</th><td><span id="vw_direccion"></span></td></tr>
                        <tr><th>Dui</th><td><span id="vw_dui"></span></td></tr>
                        <tr><th>Carnet</th><td><span id="vw_carnet"></span></td></tr>
                        <tr><th>Estado</th><td><span id="vw_estado"></span></td></tr>
                        <tr><th>Credito</th><td>$<span id="vw_credito"></span></td></tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a rol="button" href="#" class="btn btn-default" onclick="_edit()">Editar</a>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Añadir -->
<div id="save_product" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Nuevo Cliente</h4>
            </div>
            <form id="procesor" action="<?php echo base_url(); ?>procesator/saveclient" method="post">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-condenced table-bordered">
                            <input name="codigo" id="sv_codigo" type="hidden">
                            <tr><th>Nombre</th><td><input name="nombre" id="sv_nombre" type="text" class="form-control"></td></tr>
                            <tr><th>Telefono</th><td><input name="telefono" id="sv_telefono" type="text" class="form-control"></td></tr>
                            <tr><th>Direccion</th><td><input name="direccion" id="sv_direccion" type="text" class="form-control"></td></tr>
                            <tr><th>DUI</th><td><input name="dui" id="sv_dui" type="text" class="form-control"></td></tr>
                            <tr><th>Carnet</th><td><input name="carnet" id="sv_carnet" type="text" class="form-control"></td></tr>
                            <tr><th>Credito</th><td><input name="credito" id="sv_credito" type="number" step="any" class="form-control"></td></tr>
                            <tr>
                                <th>Estado</th>
                                <td>
                                    <select name="estado" id="sv_estado" class="form-control">
                                        <option value="ACTIVO">ACTIVO</option>
                                        <option value="INACTIVO">INACTIVO</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>