<?php
class Controller
{
    public function __construct($query, $controller)
    {
        $this->post = $_POST;
        $this->get = $_GET;
    }
}
?>