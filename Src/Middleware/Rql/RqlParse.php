<?php
/**
 * Zaboy lib (http://zaboy.org/lib/)
 * 
 * @copyright  Zaboychenko Andrey
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace zaboy\middleware\Middleware\Rql;

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


/**
 * Send DataStores data as HTML
 *                                                this._targetContainsQueryString = this.target.lastIndexOf('?') >= 0;
 *                                                 https://github.com/SitePen/dstore/blob/21129125823a29c6c18533e7b5a31432cf6e5c56/src/Request.js
 * @category   DataStores
 * @package    DataStores
 */
class RqlParse
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
 
        $next($request, $response);
        $response->write(PHP_EOL . $request->getAttributes() . '</br>' . PHP_EOL);
        
        $lexer = new Lexer();
        $query = $request->getUri()->getQuery();
        $tokens = $lexer->tokenize($query);
        
        //$parser = Parser::createDefault();
        //file_put_contents('xxxx', print_r($parser->parse($tokens), true));

        $response->write('    <h2> RQL test</h2>' . PHP_EOL);              
$queryTokenParser = new TokenParserGroup();
$queryTokenParser
    ->addTokenParser(new GroupTokenParser($queryTokenParser))
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

$parser = new Parser(new ExpressionParser());
$parser->addTokenParser($queryTokenParser);
    
    $rql = $parser->parse($tokens);
        
        
        $response->write(PHP_EOL . var_dump($rql) . '</br>' . PHP_EOL);
        
        //$sort = $rql->getSort();
        return $response;        
    }
}