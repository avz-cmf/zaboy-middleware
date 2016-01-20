<?php
/**
 * Zaboy lib (http://zaboy.org/lib/)
 * 
 * @copyright  Zaboychenko Andrey
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace zaboy\res\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use zaboy\res\DataStores\DataStoresAbstract;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Stratigility\MiddlewareInterface;
use Interop\Container\ContainerInterface;

/**
 * Send DataStores data as HTML
 *                                                this._targetContainsQueryString = this.target.lastIndexOf('?') >= 0;
 *                                                 https://github.com/SitePen/dstore/blob/21129125823a29c6c18533e7b5a31432cf6e5c56/src/Request.js
 * @category   DataStores
 * @package    DataStores
 */
class GetAllFactory
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
        $config = $container->has('config') ? $container->get('config') : [];
        $this->config = isset($config['dataStore'][$requestedName]) ? $config['dataStore'][$requestedName]:[];
        if (isset($this->config['class'])) {
            $className = $this->config['class'];
        }else{
            $className = 'zaboy\res\DataStore\DbTable';
        }
        $tableName = isset($this->config ['tableName']) ? $this->config ['tableName'] : null;
        $db = $container->has('db') ? $container->get('db') : null;
        if (isset($tableName) && isset($db)) {
            $tableGateway = new TableGateway($tableName, $db);
        } else {
            throw new DataStoresException( 
                'Can\'t create Zend\Db\TableGateway\TableGateway for ' . $requestedName
            ); 
        }
        $dataStore =  new DbTable($tableGateway, $options);
        return $dataStore;
    }

}    