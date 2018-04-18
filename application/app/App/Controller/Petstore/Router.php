<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace App\App\Controller\Petstore;

class Router
{
    public function run() {
        error_reporting(E_ERROR | E_PARSE | E_STRICT);

        $routers = [];

       // $statics = [];

        $groups = [];

        $basepaths = [];



        $path = [
            path_application('App/App/Controller/Petstore')
        ];

        $swagger = \Swagger\scan($path);

       // dump($swagger);

        $basePathPrefix = '';

        if ($swagger->basePath) {
            $basepaths[] = $swagger->basePath;
            $basePathPrefix = $swagger->basePath;
        }

        $routerField = [
            //'prefix',
            'params',
            'where',
            'strict'//,
            //'bind'
        ];
    // +get: Get {#285 ▶}
    // +put: null
    // +post: null
    // +delete: null
    // +options: null
    // +head: null
    // +patch: null
    // 
     $letters = [
        'a','b','c','d','e','f','g','h',
        'i','j','k','l','m','n','o','p',
        'q','r','s','t','u','v','w','x',
        'y','z'
     ];

     if ($swagger->tags) {
        foreach ($swagger->tags as $tags) { 
            if (property_exists($tags, '__group')) {
                $groups[] = '/' . $tags->__group;
            }
        }
     }

    // dd($groups);

if ($swagger->paths) {
        foreach ($swagger->paths as $paths) {
            $apis = [];

            foreach (['get','delete','post', 'delete','options','head','patch'] as $key) {
                $method = $paths->$key;

                if ($method && $method->deprecated !== true) {
                    $context = $method->_context;

                    $node = [];

                    ////if ($context->class && $context->method) {
                   //     $node['url'] = [$context->fullyQualifiedName($context->class), $context->method];
                   // } else

                    if (property_exists($method,'__bind')) {
                        $node['url'] = $method->__bind;
                    } else {
                        //throw new Exception('');
                    }

                    foreach ($routerField as $f) {
                        $field = '__' . $f;
                        if(property_exists($method, $field)) {
                            $node[[$f] = $method->$field;
                        } else {
                            $node[[$f] = null;
                        }
                    }

                    $routePath = $paths->path;

                    //$result[$key][$routePath] = $node;

                    if (strlen($routePath)>1) {
                        if (in_array($routePath[1], $letters)) {
                           // $staticrs[$routePath[1]][] = ['get', $routePath];
                           $prefix = $routePath[1];
                        } else {
                            $prefix = '_';
                        }
                    }else{
                        $prefix = '_';
                    }

                    $groupPrefix = '_';

                    foreach($groups as $g) {
                        if (strpos($routePath, $g) === 0) {
                            $groupPrefix = $g;
                            break;
                        }
                    }

                   // dump($groupPrefix);

                    $routers[$key][$prefix][$groupPrefix][$basePathPrefix . $routePath] = $node;
                }
            }

            
        }
}

$groups[] = '_';

        $result = [
            'basepaths' => $basepaths,
            'groups' => $groups,
            'routers' => $routers
        ];



       // dd($result);

       // dd($statics);

        // $json = $swagger->__toString();
        $cachePath = path_runtime('router/router2.php');

        $content = '<?' . 'php /* ' . date('Y-m-d H:i:s') . ' */ ?' . '>' . PHP_EOL . '<?' . 'php return ' . var_export(
                $result, true) . '; ?' . '>';

        if(! file_put_contents($cachePath, $content)) {
            throw new Exception(sprintf('Dir %s is not writeable', dirname($cachePath)));
        }

        // echo $json;
        //$cachePath = path('www/api/swagger.json');

        //if(! file_put_contents($cachePath, $json)) {
            //throw new Exception(sprintf('Dir %s is not writeable', dirname($cachePath)));
        //}

        //echo $json;

        //exit();
    }
}