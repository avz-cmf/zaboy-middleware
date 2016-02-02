<?php

namespace zaboy\middleware\Middleware\Rest\Rql;

use zaboy\middleware\Middleware\Rest\Rql\RqlParser;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Xiag\Rql\Parser\Query;
use Xiag\Rql\Parser\Node\Query\LogicOperator\AndNode;
use Xiag\Rql\Parser\Node\Query\ScalarOperator\EqNode;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-01-29 at 21:20:24.
 */
class RqlParserTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var RqlParser
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new RqlParser;
        $this->response = new Response();
        $this->next = function (ServerRequest $req, Response $resp) {
            return $req;
        };
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }
    /**
     * @covers zaboy\middleware\Middleware\Rest\Rql\RqlParser::__invoke
     * @todo   Implement test__invoke().
     */
    public function testRqlParser__Empty() {
        $this->request = new ServerRequest([], [], '');        
        $returned = $this->object
                ->__invoke($this->request, $this->response, $this->next); 
        var_dump( $returned->getAttribute('Rql-Query-Object')->getQuery());
        $this->assertSame(
                get_class($returned->getAttribute('Rql-Query-Object')),
                'Xiag\Rql\Parser\Query'
        );
        $this->assertSame(
                $returned->getAttribute('Rql-Query-Object')->getQuery(),
                null
        ); 
    }
    
    /**
     * @covers zaboy\middleware\Middleware\Rest\Rql\RqlParser::__invoke
     * @todo   Implement test__invoke().
     */
    public function testRqlParser__invoke() {
        $this->request = new ServerRequest([], [], '/foo?b=4&A=2&select(A)&sort(-b,+A)&limit(3,2)');        
        $returned = $this->object
                ->__invoke($this->request, $this->response, $this->next); 
        var_dump( $returned->getAttribute('Rql-Query-Object')->getQuery());
        $this->assertSame(
                get_class($returned->getAttribute('Rql-Query-Object')),
                'Xiag\Rql\Parser\Query'
        );
        $this->assertSame(
                get_class($returned->getAttribute('Rql-Query-Object')->getQuery()),
                'Xiag\Rql\Parser\Node\Query\LogicOperator\AndNode'
        ); 
        $this->assertSame(
                get_class($returned->getAttribute('Rql-Query-Object')
                    ->getQuery()
                    ->getQueries()[0]
                ),
                'Xiag\Rql\Parser\Node\Query\ScalarOperator\EqNode'
        );
        $this->assertSame(
                $returned->getAttribute('Rql-Query-Object')
                    ->getQuery()
                    ->getQueries()[0]
                    ->getField()
                ,
                'b'
        );
         $this->assertSame(
                $returned->getAttribute('Rql-Query-Object')
                    ->getQuery()
                    ->getQueries()[1]
                    ->getValue()  
                ,
                (int) '2'
        );
        $this->assertSame(
                $returned->getAttribute('Rql-Query-Object')
                    ->getSelect()
                    ->getFields()
                ,
                ['A']
        );
        $this->assertSame(
                $returned->getAttribute('Rql-Query-Object')
                    ->getSort()
                    ->getFields()
                ,
                ['b'=>-1, 'A'=>1]
        );
         $this->assertSame(
                $returned->getAttribute('Rql-Query-Object')
                    ->getLimit()
                    ->getLimit()
                ,
                3
        );
         $this->assertSame(
                $returned->getAttribute('Rql-Query-Object')
                    ->getLimit()
                    ->getOffset()
                ,
                2
                 
        );    
    }

}