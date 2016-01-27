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
class GetAllRequestHeaders
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
        
        $id = 0;        
        $items[] = [
          'id' => $id,
          'Header_Name' => '______URI_______', 
          'Header_Value' => $request->getUri()->__toString()
        ];
        
        $headers = $request->getHeaders();
        foreach ($headers as $headerName => $headerValue) {
            $id = $id +1;            
            $items[] = [
               'id' => $id,
               'Header_Name' => $headerName, 
               'Header_Value' => $headerValue
            ];        
       }
       
       $response = new JsonResponse($items);
       $contentRangeHeader = 'items 0-' . $id . '/' . ($id + 1);
       $response = $response->withHeader('Content-Range', $contentRangeHeader);
       return $response;
       
    }
}