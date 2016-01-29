<?php
/**
 * Zaboy lib (http://zaboy.org/lib/)
 * 
 * @copyright  Zaboychenko Andrey
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace zaboy\middleware\Middlewares\Factory;

//use Zend\ServiceManager\Factory\AbstractFactoryInterface; 
//uncomment it ^^ for Zend\ServiceManager V3
use Zend\ServiceManager\AbstractFactoryInterface; 
//comment it ^^ for Zend\ServiceManager V3
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stratigility\MiddlewareInterface;
use Interop\Container\ContainerInterface;

/**
 * Send DataStores data as HTML
 *                                                this._targetContainsQueryString = this.target.lastIndexOf('?') >= 0;
 *                                                 https://github.com/SitePen/dstore/blob/21129125823a29c6c18533e7b5a31432cf6e5c56/src/Request.js
 * @category   DataStores
 * @package    DataStores
 */
class StoreMiddlewareAbstractFactory  implements AbstractFactoryInterface
{
    /**
     * Can the factory create an instance for the service?
     *
     * @param  Interop\Container\ContainerInterface $container
     * @param  string $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName) 
    {
        $config = $container->get('config');
        return isset ($config['storeMiddleware'][$requestedName]['class']);
    }
    
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
        //take store for Middleware
        $dataStoreServiceName = $config['dataStore'];
        if (!($container->get($dataStoreServiceName))) {
            throw new DataStoresException(
                    'Can\'t get Store' . $dataStoreServiceName 
                    . ' for Middleware ' . $requestedName); 
        }
        $dataStore =  $container->get($dataStoreServiceName);
        return new $requestedClassName($dataStore);
    }    

    /**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName 
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return $this->canCreate($serviceLocator, $requestedName);
    }

    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return mixed
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return $this->__invoke($serviceLocator, $requestedName);
    }
}    