<?php
/**
 * Zaboy lib (http://zaboy.org/lib/)
 * 
 * @copyright  Zaboychenko Andrey
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace zaboy\middleware\Middleware\Dojo;

use Zend\Diactoros\Response\JsonResponse;
use zaboy\middleware\Middlewares\StoreMiddlewareAbstract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Send DataStores data as HTML
 *                                                this._targetContainsQueryString = this.target.lastIndexOf('?') >= 0;
 *                                                 https://github.com/SitePen/dstore/blob/21129125823a29c6c18533e7b5a31432cf6e5c56/src/Request.js
 * @category   DataStores
 * @package    DataStores
 */
class DojoInHead
{
    
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $response->write(
<<<DOJO_HEAD
    <script 
        src='./js/dojo/dojo.js' 
        data-dojo-config="async: true, parseOnLoad: true">
    </script>
    
    <link rel="stylesheet" href="./js/dijit/themes/claro/claro.css">
    <link rel="stylesheet" href="./js/dgrid/css/dgrid.css">
    <link rel="stylesheet" href="./js\dgrid/css/skins/claro.css">
DOJO_HEAD
        );    
        
        $next($request, $response);

        return $response;         
    }
}