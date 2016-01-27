<?php
/**
 * Zaboy lib (http://zaboy.org/lib/)
 * 
 * @copyright  Zaboychenko Andrey
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace zaboy\middleware\Middleware\API\Get;

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
class GetAllAllType extends StoreMiddlewareAbstract
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
            $response = new JsonResponse($rowset, 200);
            $contentRangeHeader = 'items 0-' . $this->dataStore->count()-1 . '/' . $this->dataStore->count();
            $response = $response->withHeader('Content-Range', $contentRangeHeader);
            break;
        
            case 'POST':    
                
            break;
        }
        if ($request->getMethod() === 'GET') {

        }else{
            
        } 
        if ($next) {
            return $next($request, $response);
        }
        return $response;


    }
}