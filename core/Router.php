<?php


namespace app\core;

/**
 * Class Router
 *
 * This is where we call controllers and methods
 *
 * @package app\core
 */
class Router
{
    /**
     * This will hold all routes.
     *
     * routes [
     * ['get'  => [
     *  ['/' => function return,],
     *  ['/about' => 'about',],
     * ],
     * ['post' => [
     *  ['/' => function return,],
     *  ['/contact' => function return,],
     * ]]
     * ]
     *
     *
     * ];
     *
     * @var array
     */
    protected array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Add get route and callback fn to routes array
     *
     * @param string $path
     * @param $callback
     */
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     * This creates post path and handling in routes array.
     *
     * @param $path
     * @param $callback
     */
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * Executes user function if it is set in routes array
     */
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

//        echo "<pre>";
//        var_dump($this->routes);
//        echo "</pre>";
//        exit;

        // trying to run a route from routes array
        $callback = $this->routes[$method][$path] ?? false;

        // if there is no such route added, we say not exist
        if ($callback === false) :
            // 404
            $this->response->setResponseCode(404);
            return $this->renderView('_404');
        endif;

        // if our callback value is string
        // $app->router->get('/about', 'about');
        if (is_string($callback)) :
            return $this->renderView($callback);
        endif;

        // page dose exsist we call user function
        return call_user_func($callback);

    }

    /**
     * Renders the page and applies the layout
     *
     * @param string $view
     * @return string|string[]
     */
    public function renderView(string $view, array $params = [])
    {
        $layout = $this->layoutContent();
        $page = $this->pageContent($view, $params);
//        echo $page;
        // take layout and replace the {{content}} with the $page content
        return str_replace('{{content}}', $page, $layout);

        //
    }

    /**
     * Returns the layout HTML content
     *
     * @return false|string
     */
    protected function layoutContent()
    {
        // start buffering
        ob_start();
        include_once Application::$ROOT_DIR . "/view/layout/main.php";
        // stop and return buffering
        return ob_get_clean();

    }

    /**
     * Returns only the given page HTML content
     *
     * @param $view
     * @return false|string
     */
    protected function pageContent($view, $params)
    {
//        $params = [
//            'name' => "AlmostLara",
//            'subtitle' => "This is a nice way to learn PHP"
//        ];
        // a smart way of creating variables dinamically
        // $name = $params['name'];
        foreach ($params as $key => $value) :
            $$key = $value; // name = AlmostLara // $name = AlmostLara
        endforeach;

        // start buffering
        ob_start();
        include_once Application::$ROOT_DIR . "/view/$view.php";
        // stop and return buffering
        return ob_get_clean();
    }



}