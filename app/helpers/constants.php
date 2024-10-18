<?php
define('VIEW_PATH','../app/views/');

// validate
define('REQUIRED', 'ValidateRequired');
define('EMAIL', 'ValidateEmail');
define('CPF', 'ValidateCpf');
define('PASSWORD', 'ValidatePassword');
define('CNPJ', 'ValidateCnpj');
define('IMAGE', 'ValidateImage');
define('TIME', 'ValidateTime');
define('DATE', 'ValidateDate');
define('CSRF', 'ValidateSessionToken');

// config
define('ROOT', dirname(__FILE__, 3));
define('IMAGES_DIR', 'http://localhost:8889/');
define('CONTROLLER_PATH', 'app/controllers/');
define('CONTROLLER_DEFAULT', 'Home');
define('CONTROLLER_FOLDER_DEFAULT', 'client');
define('AVATAR_DEFAULT', '/assets/images/avatar_default.png');
define('IMAGE_DEFAULT', '/assets/images/image_default.png');
?>