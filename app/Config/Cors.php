<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class CORS extends BaseConfig
{
    public $allowedOrigins = ['http://localhost:3000']; // URL de votre React app
    public $allowedMethods = ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'];
    public $allowedHeaders = ['Content-Type', 'Authorization', 'X-Requested-With'];
    public $exposedHeaders = [];
    public $maxAge = 3600;
    public $supportsCredentials = false;
}