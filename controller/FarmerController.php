<?php
require_once 'model/Farmers.php';
require_once 'config/db_connection.php';

class FarmerController {
    private $model;

    public function __construct($db) {
        $this->model = new Farmer($db);
    }

    public function index() {
        $farmers = $this->model->getAllFarmers();
  
        require_once 'view/farmer_list.php';
    }
}
?>