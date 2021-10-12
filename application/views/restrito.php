<section>
    <div class="container">
        <div class="row">
            <div classs="col">
                <div class="form-group">
                    <a class="btn btn-link" href="/restrito/logoff"><i class="fa fa-sign-out"></i>Sair</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
                <h1>Gerenciar Clientes</h1>
            </div>
        </div>
    </div>
    <div class="container">
        <a id="btn_add_clientes" class="btn btn-primary"><i class="fa fa-plus"> Adicionar Clientes</i></a>
        <hr />
        <table id="dt_clientes" class="table table-striped table-bordered">
            <thead>
                <tr class="tableheader">
                    <th class="dt-center">ID</th>
                    <th class="dt-center">Nome</th>
                    <th class="dt-center">Email</th>
                    <th class="dt-center no-sort">Telefone</th>
                    <th class="dt-center">Fornecedor</th>
                    <th class="dt-center no-sort">Ações</th>
                </tr>
            </thead>

        </table>
    </div>
</section>

<!-- Modal -->

<div id="modal_clientes" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Clientes</h4>
                <button type="button" class="close" data-dismiss="modal">x</button>
            </div>

            <div class="modal-body">
                <form id="form_clientes">
                    <input id="clientes_id" name="clientes_id" hidden>

                    <div class="form-group">
                        <div class="col">
                            <input id="clientes_name" placeholder="Nome" name="clientes_name" class="form-control"
                                max-length="255">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col">
                            <input id="clientes_email" placeholder="Email" name="clientes_email" class="form-control"
                                max-length="255">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col">
                            <input id="clientes_fone" placeholder="Telefone" name="clientes_fone" class="form-control"
                                onkeypress="mask(this, mphone);" onblur="mask(this, mphone);">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col">
                            <input id="clientes_fornecedor" placeholder="Fornecedor" name="clientes_fornecedor"
                                class="form-control" max-length="255">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col">
                            <button type="submit" id="btn_save_cliente" class="btn btn-primary">
                                <i class="fa fa-save"></i> Salvar
                            </button>
                            <span class="help-block"></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>