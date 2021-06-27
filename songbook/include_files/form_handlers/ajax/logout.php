<?php
    /* if we direct write session_destroy() then nothing to destroy.*/
    session_start();
    session_destroy();
?>
