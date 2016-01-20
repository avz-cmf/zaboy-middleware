<?php
/**
 * Zaboy lib (http://zaboy.org/lib/)
 * 
 * @copyright  Zaboychenko Andrey
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace zaboy\res\Middleware\Factory;

use Zend\Stratigility\MiddlewareInterface;
use Interop\Container\ContainerInterface;

/**
 * Send DataStores data as HTML
 *                                                this._targetContainsQueryString = this.target.lastIndexOf('?') >= 0;
 *                                                 https://github.com/SitePen/dstore/blob/21129125823a29c6c18533e7b5a31432cf6e5c56/src/Request.js
 * @category   DataStores
 * @package    DataStores
 */
class StoreMiddlewareAbstractFactory
{
    /**
     * @var array|null
     */
    protected  $config;

    /**
     * Create and return an instance of the Middleware.
     *
     * @param  Interop\Container\ContainerInterface $container
     * @param  string $requestedName
     * @param  array $options
     * @return MiddlewareInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) 
    {
        $config = $container->get('config')['storeMiddleware'][$requestedName];
        if (empty($config['class'])) {
            throw new DataStoresException(
                    'Can\'t get class for Store Middleware ' . $requestedName); 
        }
        $requestedClassName = $config['class'];
        $dataStoreServiceName = $config['dataStore'];
        if (!($container->get($dataStoreServiceName))) {
            throw new DataStoresException(
                    'Can\'t get Store' . $dataStoreServiceName 
                    . ' for Middleware ' . $requestedName); 
        }
        $dataStore =  $container->get($dataStoreServiceName);
        return new $dataStoreServiceName($dataStore);
    }    

}    