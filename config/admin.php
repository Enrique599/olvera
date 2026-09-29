<?php

// Acceso por defecto del panel (el que menciona la pantalla de login).
// Cámbialo en el .env: ADMIN_USUARIO y ADMIN_CONTRASENA.
return [
    'usuario'    => env('ADMIN_USUARIO', 'admin'),
    'contrasena' => env('ADMIN_CONTRASENA', 'admin123'),
];
