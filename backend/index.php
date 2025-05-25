<?php
require 'config.php';
require 'router.php';

// Controllers
require 'controllers/data.php';

// Initialize Router
$router = new Router();

// Data
$router->get('/api/v1/incident', 'DataController@incident_reports');
$router->post('/api/v1/incident', 'DataController@insert_incident_predictions');

// Dispatch the request
$router->dispatch();
?>