<?php
/**
 * Zaboy lib (http://zaboy.org/lib/)
 * 
 * @copyright  Zaboychenko Andrey
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace zaboy\middleware\Middleware\Rest;

use Zend\Stratigility\MiddlewarePipe;

class RestActionPipe extends MiddlewarePipe 
{
    public function __construct($rqlParser, $storeMiddleware, $responseEncoder/**, $errorHandler = null*/)
    {
        $this->pipe($rqlParser);        
        $this->pipe($storeMiddleware);
        $this->pipe($responseEncoder);     
        //$this->pipe($errorHanddler);            
    }
}