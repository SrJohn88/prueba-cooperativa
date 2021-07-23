<div class="conatiner">
    <div class=" card mt-5 mx-auto"  style="width: 30rem;">
        <div class="card-body">

        <?php if(isset($_SESSION['error'])):  ?>
            <div class="alert alert-danger" role="alert">
                <?= $_SESSION['error']; ?>
            </div>
        <?php endif ?>


        <form action="index.php?controller=Auth&action=validarLogin" method="POST">
        <div class="form-group">
            <label for="exampleInputEmail1">Correo Electronico:</label>
            <input type="email" class="form-control" name="email" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Contraseña</label>
            <input type="password" class="form-control" name="password">
        </div>
        
        <button type="submit" class="btn btn-outline-success mr-2">Ingresar <i class="bi bi-arrow-right-square-fill"></i></button>
    </form>
        </div>
    </div>
    <?php unset( $_SESSION['error']); ?>
</div>