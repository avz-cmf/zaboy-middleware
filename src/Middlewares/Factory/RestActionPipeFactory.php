<?php
/**
 * Zaboy lib (http://zaboy.org/lib/)
 * 
 * @copyright  Zaboychenko Andrey
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace zaboy\middleware\Middlewares\Factory;

//use Zend\ServiceManager\Factory\FactoryInterface; 
//uncomment it ^^ for Zend\ServiceManager V3
use Zend\ServiceManager\FactoryInterface; 
//comment it ^^ for Zend\ServiceManager V3
use Zend\ServiceManager\ServiceLocatorInterface;
use zaboy\middleware\Middleware\Rest;
use Interop\Container\ContainerInterface;

/**
 * 
 * @category   DataStores
 * @package    DataStores
 */
class RestActionPipeFactory  implements FactoryInterface
{
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
        $rqlParser =  new Rest\Rql\RqlParser();       
        $responseEncoder = new Rest\ResponseEncoder();
        
        $resourceName = $requestedName;
        //is there config for this resource?
        $config = $container->get('config');
        if (isset($config['resource'][$resourceName]['storeMiddleware'])) {
            $storeMiddlewareServiceName = $config['resource'][$resourceName]['storeMiddleware'];
            $storeMiddleware = $container->get($storeMiddlewareServiceName);
            return new restActionPipe($rqlParser, $storeMiddleware, $responseEncoder/**, $errorHandler = null*/);
        }
        
        //is there table with same name?
        $db = $container->has('db') ? $container->get('db') : null;
        if (isset($db)) {
            $dbMetadata = new Zend\Db\Metadata\Metadata($db);
            $tableNames = $dbMetadata->getTableNames();
            if (isset($tableNames[$resourceName])) {
            $tableGateway = new TableGateway($resourceName, $db);
            $dataStore =  new DbTable($tableGateway);
            $storeMiddleware = new DefaultDataProvider($dataStore); 
            return new Rest\RestActionPipe($rqlParser, $storeMiddleware, $responseEncoder/**, $errorHandler = null*/);
            }    
        }    
        throw new DataStoresException(
                'Can\'t make RestActionPipe' 
                . ' for resource: ' . $resourceName
        ); 
    }    

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator) 
    {
        return $this->__invoke($serviceLocator, 'thereisnoname');
    }
}    