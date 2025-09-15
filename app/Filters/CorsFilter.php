<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\CORS;

class CorsFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $corsConfig = new CORS();
        
        // Handle preflight requests
        if ($request->getMethod() === 'OPTIONS') {
            $response = service('response');
            
            $response->setHeader('Access-Control-Allow-Origin', implode(', ', $corsConfig->allowedOrigins))
                     ->setHeader('Access-Control-Allow-Methods', implode(', ', $corsConfig->allowedMethods))
                     ->setHeader('Access-Control-Allow-Headers', implode(', ', $corsConfig->allowedHeaders))
                     ->setHeader('Access-Control-Max-Age', $corsConfig->maxAge);
            
            if ($corsConfig->supportsCredentials) {
                $response->setHeader('Access-Control-Allow-Credentials', 'true');
            }
            
            return $response->setStatusCode(200);
        }
        
        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $corsConfig = new CORS();
        
        $response->setHeader('Access-Control-Allow-Origin', implode(', ', $corsConfig->allowedOrigins))
                 ->setHeader('Access-Control-Allow-Methods', implode(', ', $corsConfig->allowedMethods))
                 ->setHeader('Access-Control-Allow-Headers', implode(', ', $corsConfig->allowedHeaders));
        
        if (!empty($corsConfig->exposedHeaders)) {
            $response->setHeader('Access-Control-Expose-Headers', implode(', ', $corsConfig->exposedHeaders));
        }
        
        if ($corsConfig->supportsCredentials) {
            $response->setHeader('Access-Control-Allow-Credentials', 'true');
        }
        
        return $response;
    }
}