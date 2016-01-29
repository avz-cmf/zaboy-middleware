<?php

namespace zaboy\test\middleware\Middleware\Rest;

use zaboy\middleware\Middleware\Rest\ResourceResolver;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-01-29 at 18:23:51.
 */
class ResourceResolverTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Returner
     */
    protected $object;
    
    /*
     * @var Zend\Diactoros\Response
     */
    protected $response;
    
    /*
     * @var Zend\Diactoros\ServerRequest;
     */
    protected $request;
    
    /*
     * @var \Callable
     */
    protected $next;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new ResourceResolver();
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

    public function testReturner__invoke() {
        $this->request = new ServerRequest([], [], '/foo');        
        $returned = $this->object
                ->__invoke($this->request, $this->response, $this->next);        
        $this->assertSame(
                $returned->getAttribute('Resource-Name'),
                'foo'
        );
        $this->assertSame(
                $returned->getAttribute('id'),
                null
        );
        $this->request = new ServerRequest([], [], '/foo?a=3');        
        $returned = $this->object
                ->__invoke($this->request, $this->response, $this->next);        
        $this->assertSame(
                $returned->getAttribute('Resource-Name'),
                'foo'
        );
        $this->assertSame(
                $returned->getAttribute('id'),
                null
        );
        $this->request = new ServerRequest([], [], 'foo/');        
        $returned = $this->object
                ->__invoke($this->request, $this->response, $this->next);        
        $this->assertSame(
                $returned->getAttribute('Resource-Name'),
                'foo'
        );
        $this->assertSame(
                $returned->getAttribute('id'),
                null
        );
        $this->request = new ServerRequest([], [], '/foo/1662');        
        $returned = $this->object
                ->__invoke($this->request, $this->response, $this->next);        
        $this->assertSame(
                $returned->getAttribute('Resource-Name'),
                'foo'
        );
        $this->assertSame(
                $returned->getAttribute('id'),
                '1662'
        );
        $this->request = new ServerRequest([], [], '/foo/1t3?F=r');        
        $returned = $this->object
                ->__invoke($this->request, $this->response, $this->next);        
        $this->assertSame(
                $returned->getAttribute('Resource-Name'),
                'foo'
        );
        $this->assertSame(
                $returned->getAttribute('id'),
                '1t3'
        );

        $this->request = new ServerRequest([], [], 'foo/d_f-g1?');        
        $returned = $this->object
                ->__invoke($this->request, $this->response, $this->next);        
        $this->assertSame(
                $returned->getAttribute('Resource-Name'),
                'foo'
        );
         $this->assertSame(
                $returned->getAttribute('id'),
                'd_f-g1'
        );
    }  
} 
