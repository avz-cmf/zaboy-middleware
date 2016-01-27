<?php
/**
 * Zaboy lib (http://zaboy.org/lib/)
 * 
 * @copyright  Zaboychenko Andrey
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace zaboy\middleware\Xiag;

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
class RQLParserGroup
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
        
        $this->parser = new Parser(new ExpressionParser());        
        $this->parser->addTokenParser($this->queryTokenParser);
    }        

    /**
     * 
     * @param string $rqlQuery '((a==true|b!=str)&c>=10&d=in=(1,value,null)&select(foo,bar)&limit(1,10))'
     * @return \Xiag\Rql\Parser\Query
     */
    public function parseRql($rqlQuery)
    {
        $tokens = $this->lexer->tokenize($rqlQuery);
        /* @var $rql \Xiag\Rql\Parser\Query */
        $rql = $this->parser->parse($tokens);

        return $rql;        
    }
}