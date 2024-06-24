<?php

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];


// регистрация
if ($requestUri === '/signup') {
    if ($requestMethod === 'GET') {
        require_once './registration/form/get_registration.php';
    } elseif ($requestMethod === 'POST') {
        require_once './registration/handler/handle_registration.php';
    } else {
        echo "HTTP метод $requestMethod не работает";
    }
}

// проверка пользователля
elseif ($requestUri === '/login') {
    if ($requestMethod === 'GET') {
        require_once './get_login.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handle_login.php';
    } else {
        echo "HTTP метод $requestMethod не работает";
    }
}

// каталог
elseif ($requestUri === '/catalog') {
    if ($requestMethod === 'GET') {
        require_once './catalog.php';
    }
    else {
        echo "HTTP метод $requestMethod не работает";
    }
}

elseif ($requestUri === '/main') {
        require_once './main.php';
    }

else {
    http_response_code(404);
    require_once './404.php';
}



