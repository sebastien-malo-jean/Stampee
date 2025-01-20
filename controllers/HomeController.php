<?php 

include('models/ExampleModel.php');

class HomeController {
    public function index() {
        $model = new ExampleModel();
        $data = $model->getData();
        include('views/home.php');
    }
}