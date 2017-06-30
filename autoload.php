<?php
spl_autoload_register(function ($class_name) {
    include "oop/class/".$class_name . '.php';
    include "oop/interface/".$class_name . '.php';
    include "oop/abstract/".$class_name . '.php';
});