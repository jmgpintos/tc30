</div><!--cuerpo-->
</div><!--container-->
<footer class='footer col-md-12 text-center bg-primary ' style='margin-top:15px;padding:5px;'>
    <?php
    put('<strong>ROOT:</strong> ' . ROOT . ' | <strong>BASE_URL:</strong> ' . BASE_URL . ' <br> ' . info_sesion(' | '));
    ?>
    <?php // echo APP_NAME;?>
    <div class="">
        <h4>
            <?php echo APP_SLOGAN; ?><br>
            <small class="text-info"><?php echo APP_COMPANY; ?></small
        </h4>
    </div>

</footer>
</body>
<script src="<?php echo $_layoutParams['ruta_js'] ?>bootstrap.min.js"></script>
</html>