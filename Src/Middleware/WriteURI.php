<?php
/**
 * Zaboy lib (http://zaboy.org/lib/)
 * 
 * @copyright  Zaboychenko Andrey
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace zaboy\middleware\Middleware;

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
class WriteURI
{
    
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        if ($request->getMethod() !== 'GET') {
            if ($next) {
                return $next($request, $response);
            }
            return $response;
        } 

        
        $headers = $request->getHeaders();
        $response->write('HEADERS:' . '<br>' . PHP_EOL);
        foreach ($headers as $header => $header) {
            $response->write($header . ' : ' . $header . '<br>' . PHP_EOL);
        }

        $response->write('URI:' . '<br>' . PHP_EOL . '<br>' . PHP_EOL);
        $response->write($request->getUri());
        
        $next($request, $response);
        
        return $response;
       
    }
}