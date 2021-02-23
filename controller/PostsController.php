<?php


namespace app\controller;


use app\core\Controller;
use app\core\Request;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        $params = [];
        return $this->render('posts/posts', $params);
    }

}