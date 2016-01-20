<?php
/**
 * Zaboy lib (http://zaboy.org/lib/)
 * 
 * @copyright  Zaboychenko Andrey
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace zaboy\res\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Send DataStores data as HTML
 *                                                this._targetContainsQueryString = this.target.lastIndexOf('?') >= 0;
 *                                                 https://github.com/SitePen/dstore/blob/21129125823a29c6c18533e7b5a31432cf6e5c56/src/Request.js
 * @category   DataStores
 * @package    DataStores
 */
class GetById
{
    
    public function __construct()
    {

    }
    
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
        
        $id = 666;//$request->getAttribute('id');

        
        //$request = $request->withAttribute('session', $this->session);
        
        $response->write( 'd<br>' . get_class($GetById) . '<br>d');
        
        /**
        if ($next) {
            return $next($request, $response);
        }
         */
         
        return $response;
    }
}