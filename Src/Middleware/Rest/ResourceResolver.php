<?php
/**
 * Zaboy lib (http://zaboy.org/lib/)
 * 
 * @copyright  Zaboychenko Andrey
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace zaboy\middleware\Middleware\Rest;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Stratigility\MiddlewareInterface;
/**
 * 
 * @category   DataStores
 * @package    DataStores
 */
class ResourceResolver implements MiddlewareInterface
{
    
    /**
     * 
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $path = ltrim($request->getUri()->getPath(), '/');
        $resourceName = explode ('/', $path)[0];
        $request = $request->withAttribute('Resource-Name', $resourceName);
        
        if ($next) {
            return $next($request, $response);
        }
        return $response;


    }
}