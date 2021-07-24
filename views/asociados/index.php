<div class="ml-5 mr-5">

    <div class="alert alert-info mt-5 mx-auto" style="width: 20rem;">
        Usuario en Sesion
    </div>
    <table class="table mt-1 mx-auto" style="width: 20rem;">
        <thead>
            <th>ID</th>
            <th>Nombre</th>
            <th></th>
        </thead>
        <tbody>
            <td><?= $_SESSION['auth']->id ?></td>
            <td><?= $_SESSION['auth']->nombre.' '.$_SESSION['auth']->apellido?></td>
            <td>
                <a href="index.php?controller=Auth&action=logout" class="btn btn-danger btn-sm">
                    Cerrar Sesion
                </a>
            </td>
        </tbody>
    </table>

    <div class="card mt-5">
        <div class="card-header">
            <h5>Asociados</h5>
        </div>
        <div class="card-body">
        <button type="button" class="mb-3 btn btn-dark" data-toggle="modal" data-target="#exampleModal">
            Agregar
        </button>
    
            <table class="table" id="tableAsociados">
                <thead>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Direccion</th>
                    <th>Edad</th>
                    <th>DUI</th>
                    <th>NIT</th>
                    <th>Profesion</th>
                    <th>Agencia</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    <?php foreach( $asociados as $asociado): ?>
                        <tr id="row<?=$asociado->id ?>">
                            <td id="tableId"> <?= $asociado->id ?> </td>
                            <td id="tableNombre"> <?= $asociado->nombre ?> </td>
                            <td id="tableApellido"> <?= $asociado->apellido ?> </td>
                            <td id="tableDireccion"> <?= $asociado->direccion ?> </td>
                            <td id="tableEdad"> <?= $asociado->edad ?> </td>
                            <td id="tableDui"> <?= $asociado->dui ?> </td>
                            <td id="tableNit"> <?= $asociado->nit ?> </td>
                            <td id="tableProfesionId"> <?= $asociado->profesion ?> </td>
                            <td id="tableAgenciaId"> <?= $asociado->agencia ?> </td>
                            <td id="table">
                                <a class="btn btn-sm btn-info" href="index.php?controller=Asociados&action=historial&id=<?=$asociado->id ?>">Historial</a>
                                <button class="btn btn-sm btn-warning editar m-1" idAsociado="<?= $asociado->id ?>" id="editarAsociado" data-toggle="modal" data-target="#exampleModal"><i class="bi bi-pen-fill"></i></button>
                                <button class="btn btn-sm btn-danger eliminar m-1" idAsociado="<?= $asociado->id ?>" id="eliminarAsociado"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--- VENTANA MODAL -->
<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Gestionar de Asociados</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formAsociados">
      <div class="modal-body">
            <div class="row">

            <input type="hidden" class="form-control" id="txtId" name="id" value="">
                
            <div class="col">
                    <label for="formGroupExampleInput">Nombre</label>
                    <input type="text" class="form-control" id="txtNombre" name="nombre" placeholder="Ejemplo: Jonathan">
                    <div class="valid-feedback">
                      Se ve bien !
                    </div>
                    <div class="invalid-feedback">
                      !No se ve bien !
                    </div>
                </div>
                <div class="col">
                    <label for="formGroupExampleInput">Apellido</label>    
                    <input type="text" class="form-control" id="txtApellido" name="apellido" placeholder="Ejemplo: Alvarado">
                    <div class="valid-feedback">
                      Se ve bien !
                    </div>
                    <div class="invalid-feedback">
                      ¡ No se ve bien !
                    </div>
                </div>
                <div class="col-3">
                    <label for="formGroupExampleInput">Edad</label>    
                    <input type="number" min="0" max="100" class="form-control" id="txtEdad" name="edad" placeholder="Ejemplo: 24">
                    <div class="valid-feedback">
                      ¡ Se ve bien !
                    </div>
                    <div class="invalid-feedback">
                      ¡No parace tu edad !
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="formGroupExampleInput">DUI (Unique)</label>
                    <input type="text" class="form-control" id="txtDui" name="dui" placeholder="05427753-9">
                    <div class="valid-feedback">
                      ¡ Se ve bien !
                    </div>
                    <div class="invalid-feedback">
                    ¡No parece un numero de DUI!
                    </div>
                </div>
                <div class="col-4">
                    <label for="formGroupExampleInput">NIT</label>
                    <input type="text" class="form-control" id="txtNit" name="nit" placeholder="1002-211296-101-1">
                    <div class="valid-feedback">
                      Se ve bien !
                    </div>
                    <div class="invalid-feedback">
                      ¡No parece un numero de NIT!
                    </div>
                </div>
                <div class="col-5">
                    <label for="formGroupExampleInput">Direccion</label>
                    <textarea class="form-control" id="txtDireccion" name="direccion" rows="2"></textarea>
                    <div class="valid-feedback">
                      Se ve bien !
                    </div>
                    <div class="invalid-feedback">
                      ¡ No parace una direccion !
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="txtProdesion">Profesion/Oficio</label>
                    <select class="form-control" id="txtProfesion" name="profesion_id">
                        <?php foreach ($profesiones as $profesion ) : ?>                
                            <option value="<?= $profesion->id ?>"><?= $profesion->profesion ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col">
                    <label for="txtAgenda">Agencia</label>
                    <select class="form-control" id="txtAgencia" name="agencia_id">
                        <?php foreach ($agencias as $agencia ) : ?>                
                            <option value="<?= $agencia->id ?>"><?= $agencia->agencia ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Guardar Asociado</button>
      </div>
      </form>
    </div>
  </div>
</div>