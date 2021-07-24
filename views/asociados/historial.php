<div class="container">
    <div class="card mt-5">
        <div class="card-header">
            <h5>Historial de Modificaciones</h5>
        </div>
        <div class="card-body">
            <a href="index.php?controller=Asociados&action=index" class="mb-3 mt-3 btn btn-dark">
                Volver
            </a>
            <table class="table">
                <thead>                    
                    <th>Asociado ID</th>
                    <th>Asociado</th>
                    <th>Fecha de modificacion</th>
                    <th>Usuario</th>
                    <th>Campo</th>
                    <th>Valor Antiguo</th>
                    <th>Valor Nuevo</th>
                </thead>
                <tbody>
                    <?php foreach( $historials as $historial): ?>
                        <tr>
                            <td> <?= $historial->asociado_id ?> </td>
                            <td> <?= $historial->asociado ?> </td>
                            <td> <?= $historial->fecha ?> </td>
                            <td> <?= $historial->usuario ?> </td>
                            <td> <?= $historial->campo ?> </td>
                            <td> <?= $historial->antiguo ?> </td>
                            <td> <?= $historial->nuevo ?> </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>