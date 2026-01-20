<!-- Ijeccion para poder usar las variables de entorno en js, y no en php-->
<script>
    const CONFIG = 
    {
        BASE_URL: "<?php echo BASE_URL?>",
        PROCESS_URL: "<?php echo PROCESS_URL?>"
    }
</script>

<!-- Cargamos los archivos que lo requieran--> 
<script src=" <?php echo BASE_URL . JS_URL?>/registro.js"></script>