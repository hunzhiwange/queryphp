<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace App\App\Controller\Petstore;

/**
 * api 文档入口
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class SwaggerV2
{

    /**
     * @SWG\Swagger(
     *     schemes={"http"},
     *     host="petstore.swagger.io",
     *     basePath="/v2",
     *     @SWG\Info(
     *         version="1.0.0",
     *         title="Swagger Petstore",
     *         description="This is a sample server Petstore server.  You can find out more about Swagger at [http://swagger.io](http://swagger.io) or on [irc.freenode.net, #swagger](http://swagger.io/irc/).  For this sample, you can use the api key `special-key` to test the authorization filters.",
     *         termsOfService="http://swagger.io/terms/",
     *         @SWG\Contact(
     *             email="apiteam@swagger.io"
     *         ),
     *         @SWG\License(
     *             name="Apache 2.0",
     *             url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *         )
     *     ),
     *     @SWG\ExternalDocumentation(
     *         description="Find out more about Swagger",
     *         url="http://swagger.io"
     *     )
     * )
     */
    public function run()
    {
        error_reporting(E_ERROR | E_PARSE | E_STRICT);
        
        $path = [
            path_application('App/App/Controller/Petstore')
        ];

        $swagger = \Swagger\scan($path);

        $json = $swagger->__toString();
        $cachePath = path('www/api/swagger.json');

        if(! file_put_contents($cachePath, $json)) {
            throw new Exception(sprintf('Dir %s is not writeable', dirname($cachePath)));
        }

        echo $json;

        exit();
    }
}
