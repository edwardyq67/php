</main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
        
        <script>
    $(document).ready(function(){
        $("#tabla_id").DataTable({
            "pageLength": 5,
            "lengthMenu": [
                [3, 5, 10, 20],
                [3, 5, 10, 20] // Esto corresponde a los textos que se mostrarán en el menú
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json" // Corregido el enlace al archivo de idioma
            },
            "info":false
        });
    });
</script>
<script>
    function borrar(id) {
        Swal.fire({
            title: "¿Desea borrar?",
            showCancelButton: true,
            confirmButtonText: "Sí",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "index.php?txtID=" + id; // Cambiado 'textID' a 'txtID'
            }
        });
    }
</script>
    </body>
</html>