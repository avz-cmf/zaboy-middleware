<?php
/**
 * Zaboy lib (http://zaboy.org/lib/)
 * 
 * @copyright  Zaboychenko Andrey
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace zaboy\middleware\Middleware\Dojo\Grid;

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
        $response->write(
<<<DOJO_GRID
       
    <script>
        require([
                'dojo/_base/declare',
                'dstore/Rest',
                'dstore/Trackable',
                'dgrid/OnDemandGrid',
                'dgrid/Editor'
        ], function (declare, Rest, Trackable, OnDemandGrid, Editor) {
            
                var store = new Rest({
                target: '/GetAllRequestHeaders/'
            });

                // Instantiate grid
                var grid = new (declare([OnDemandGrid, Editor]))({
                        collection: store,
                            selectionMode: "single",
                        columns: {
                                Header_Name: {
                                        label: 'Header Name',
                                    editor: 'text',
                                    editOn: 'click',
                                    autoSave: true
                                },
                                Header_Value: {
                                        label: 'Header Value'
                                }
                        }
                }, 'MainRequestHeadesrsGrid');

                grid.startup();
        });
    </script>
DOJO_GRID
        );    
        
        $next($request, $response);
        return $response;        
    }
}