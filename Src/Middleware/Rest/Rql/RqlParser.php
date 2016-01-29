<?php
/**
 * Zaboy lib (http://zaboy.org/lib/)
 * 
 * @copyright  Zaboychenko Andrey
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace zaboy\middleware\Middleware\Rest\Rql;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Xiag\Rql\Parser\Lexer;
use Xiag\Rql\Parser\Parser;
use Xiag\Rql\Parser\ExpressionParser;
use Xiag\Rql\Parser\TokenParserGroup;
use Xiag\Rql\Parser\TokenParser\Query\GroupTokenParser;
use Xiag\Rql\Parser\TokenParser\SelectTokenParser;
use Xiag\Rql\Parser\TokenParser\LimitTokenParser;
use Xiag\Rql\Parser\TokenParser\SortTokenParser;
use Xiag\Rql\Parser\TokenParser\Query\Fiql;
use Zend\Stratigility\MiddlewareInterface;

/**
 * Send DataStores data as HTML
 *                                                this._targetContainsQueryString = this.target.lastIndexOf('?') >= 0;
 *                                                 https://github.com/SitePen/dstore/blob/21129125823a29c6c18533e7b5a31432cf6e5c56/src/Request.js
 * @category   DataStores
 * @package    DataStores
 */
class RqlParser implements MiddlewareInterface
{
    /**
     *
     * @var Xiag\Rql\Parser\TokenParserGroup; 
     */
    protected $queryTokenParser;    

    /**
     *
     * @var Xiag\Rql\Parser\Lexer 
     */    
    protected $lexer;

    /**
     *
     * @var Xiag\Rql\Parser\ExpressionParser; 
     */
    protected $parser;

    
    public function __construct()
    {
        $this->lexer = new Lexer();

        $this->queryTokenParser = new TokenParserGroup();
        $this->queryTokenParser
            ->addTokenParser(new GroupTokenParser($this->queryTokenParser))
            ->addTokenParser(new Fiql\ArrayOperator\InTokenParser())
            ->addTokenParser(new Fiql\ArrayOperator\OutTokenParser())
            ->addTokenParser(new Fiql\ScalarOperator\EqTokenParser())
            ->addTokenParser(new Fiql\ScalarOperator\NeTokenParser())
            ->addTokenParser(new Fiql\ScalarOperator\LtTokenParser())
            ->addTokenParser(new Fiql\ScalarOperator\GtTokenParser())
            ->addTokenParser(new Fiql\ScalarOperator\LeTokenParser())
            ->addTokenParser(new Fiql\ScalarOperator\GeTokenParser())
            ->addTokenParser(new LimitTokenParser())
            ->addTokenParser(new SortTokenParser())        
            ->addTokenParser(new SelectTokenParser());       
        
        $this->parser = new Parser(new ExpressionParser());        
        $this->parser->addTokenParser($this->queryTokenParser);
    }
 
    /**
     * 
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $rqlQueryString = $request->getUri()->getQuery(); 
        /* @var $rqlQueryObject \Xiag\Rql\Parser\Query */
        $tokens = $this->lexer->tokenize($rqlQueryString);
        /* @var $rqlQueryObject \Xiag\Rql\Parser\Query */
        $rqlQueryObject = $this->parser->parse($tokens);
        $request = $request->withAttribute('Rql-Query-Object', $rqlQueryObject);
        //$response->write(var_dump($rqlQueryObject));
        if ($next) {
            return $next($request, $response);
        }
/**        
if($key = 'select-param') {
//'select-param': 'prop1,prop2'
$fildsArray = explode(',', urldecode($value)); 
 */     
        return $response;
    }

}