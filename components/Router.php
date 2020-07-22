<?php 
    class Router {
        private $routes;

        public function __construct() {
            $routesPath = './config/routes.php';
            $this->routes = include($routesPath);
        }

        private function getURI() {
            if (!empty($_SERVER['REQUEST_URI'])) {
                return trim($_SERVER['REQUEST_URI'], '/');
            }
        }

        private function getMethod() {
            return $_SERVER['REQUEST_METHOD'];
        }

        public function run() {
            //получить строку и метод запроса
            $uri = $this->getURI();
            $method = $this->getMethod();

            //Проверить наличие запроса в роутах
            foreach ($this->routes as $uriPattern => $path) {
                if (preg_match("~^$uriPattern\b~", $uri)) {

                    //Получаем внутренний путь из внешнего
                    $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                    //определить какой контроллер, экшн
                    $segments = explode('/', $internalRoute);
                    $controllerName = ucfirst(array_shift($segments)."Controller");
                    $actionName = "action".$method.ucfirst(array_shift($segments));

                    //определяем параметры
                    if ($method === 'POST') {
                        $parameters = $_POST;
                    } elseif ($method === 'PATCH') {
                        $data = file_get_contents('php://input');
                        $arrayData = json_decode($data, true);
                        $parameters = array($segments, $arrayData);
                    }  else {
                        $parameters = $segments;
                    }
                

                    // подключить файл класса контроллера
                    $controllerFile = $_SERVER['DOCUMENT_ROOT'] . '/controllers/' . 
                        $controllerName . '.php';
                    if (file_exists($controllerFile)) {
                        include_once($controllerFile);
                    }
                    //Создать объект
                    $controllerObject = new $controllerName;

                    //вызываем метод нужного контроллера и передаем ему параметры
                    $result = $controllerObject->$actionName($parameters);
                    if ($result != null) {
                        break;
                    }
                }   

            }
        }
    }
?>