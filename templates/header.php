<?php
session_start();
$url_base = "http://localhost:6721/App/";
if (!isset($_SESSION['correo'])) {
    header("Location: " . $url_base . "login.php");
}


?>
<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
</head>

<body class="">
    <header>
        <!-- place navbar here -->
    </header>
    <nav class="navbar navbar-expand-lg bg-dark-subtle" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo $url_base; ?>index.php" aria-current="page">Sistema <span class="visually-hidden">(current)</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse" id="navbarColor02">
                <ul class="nav navbar-nav">
                   
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $url_base; ?>secciones/empleados">Empleados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $url_base ?>secciones/puestos">Puestos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $url_base ?>secciones/usuarios">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $url_base ?>cerrar.php">Cerrar sesion</a>
                    </li>

                </ul>

            </div>
            <a  onclick="cambiarTema()" name="" id="" class="btn" href="#" role="button"><i class="fa-regular fa-moon"></i></a>
        </div>

    </nav>

    <script >
    // Verificar si hay un tema almacenado en localStorage y configurarlo
    let temaActual = localStorage.getItem('tema') || 'dark';
        document.documentElement.setAttribute('data-bs-theme', temaActual);

        const cambiarTema = () => {
            // Verificar el tema actual y cambiarlo en consecuencia
            if (temaActual === 'dark') {
                // Cambiar a tema claro
                document.documentElement.setAttribute('data-bs-theme', 'light');
                // Actualizar el estado del tema y guardarlo en localStorage
                
                temaActual = 'light';
                
                localStorage.setItem('tema', temaActual);
            } else {
                // Cambiar a tema oscuro
                document.documentElement.setAttribute('data-bs-theme', 'dark');
                // Actualizar el estado del tema y guardarlo en localStorage
                temaActual = 'dark';
                localStorage.setItem('tema', temaActual);
            }
        };
    </script>
    </script>

</body>

</html>


    <main class="container">
        <br>
        <?php if (isset($_GET['mensaje'])) { ?>
            <script>
                Swal.fire({
                    icon: "success",
                    title: "<?php echo $_GET['mensaje']; ?>"
                });
            </script>
        <?php } ?>