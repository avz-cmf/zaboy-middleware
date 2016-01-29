<?php
/**
 * Zaboy lib (http://zaboy.org/lib/)
 * 
 * @copyright  Zaboychenko Andrey
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace zaboy\middleware\Middleware\Rest;

use zaboy\middleware\Middlewares\StoreMiddlewareAbstract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * 
 * @category   DataStores
 * @package    DataStores
 */
class StoreMiddleware extends StoreMiddlewareAbstract 
{
    
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        switch ($request->getMethod()) {
            case 'GET':
                $rowset = $this->dataStore->find();
                $contentRangeHeader = 'items 0-' . $this->dataStore->count()-1 . '/' . $this->dataStore->count();
                $response = $response->withHeader('Content-Range', $contentRangeHeader);
                $response = $response->withStatus(200);    
                break;
            
            case 'POST':    
                
            break;
        }

        if ($next) {
            return $next($request, $response);
        }
        return $response;


    }
}