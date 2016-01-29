<?php
/**
 * Zaboy lib (http://zaboy.org/lib/)
 * 
 * @copyright  Zaboychenko Andrey
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace zaboy\middleware\Middleware\Rest;


class ResponseEncoder
{
    
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $rowset = $request->getAttribute('Response-Body');
        $status = $response->getStatus('Status');
        $headers = $response->getHeaders();
        $response = new JsonResponse($rowset, $status, $headers);
        if ($next) {
            return $next($request, $response);
        }
        return $response;      
    }
}