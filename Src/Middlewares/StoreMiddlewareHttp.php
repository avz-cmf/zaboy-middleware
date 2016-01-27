<?php
/**
 * Zaboy lib (http://zaboy.org/lib/)
 * 
 * @copyright  Zaboychenko Andrey
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace zaboy\Middlewares;

use zaboy\res\DataStores\DataStoresAbstract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Stratigility\MiddlewareInterface;

/**
 * Send DataStores data as HTML
 *                                                this._targetContainsQueryString = this.target.lastIndexOf('?') >= 0;
 *                                                 https://github.com/SitePen/dstore/blob/21129125823a29c6c18533e7b5a31432cf6e5c56/src/Request.js
 * @category   DataStores
 * @package    DataStores
 */
class StoreMiddlewareHttp   extends StoreMiddlewareAbstract
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        
    }
    /**
     * 	'select(prop1,prop2)': ''  'select-param': 'prop1,prop2'
     *  https://github.com/SitePen/dstore/blob/21129125823a29c6c18533e7b5a31432cf6e5c56/tests/unit/Request.js
     * 
     * Parsed JSON https://github.com/ma4eto/expressive-sandbox/blob/master/src/App/Middleware/JsonContentParser.php
     * 
     * @param ServerRequestInterface $request
     */
    protected function getSelect(ServerRequestInterface $request)
    {
        $attributes = $request->getAttributes();
        foreach ($attributes as $key => $value) {
            if (substr($key, 0,strlen('select(')) === 'select(' && empty($value)) {
                //select(prop1,prop2)
                $fildsStr = substr(
                        $key, 
                        strlen('select('),
                        strlen($key) - strlen('select(') - strlen(')')
                );
                $fildsArray = explode(',', $fildsStr);
                return $fildsArray;
            }elseif($key = 'select-param') {
                //'select-param': 'prop1,prop2'
                $fildsArray = explode(',', urldecode($value)); 
                return $fildsArray;
            }
        }
        return null;
    }        
}