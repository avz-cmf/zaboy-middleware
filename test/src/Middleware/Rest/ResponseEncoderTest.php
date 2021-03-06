<?php

namespace zaboy\test\middleware\Middleware\Rest;

use zaboy\middleware\Middleware\Rest\ResponseEncoder;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-01-29 at 18:23:51.
 */
class ResponseEncoderTest extends \PHPUnit_Framework_TestCase {

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
        $this->object = new ResponseEncoder();
        $this->response = new Response();
        $this->request = new ServerRequest([], [], '/foo');
        $this->next = function (ServerRequest $req, Response $resp) {
            return $resp;
        };
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    public function testResponseEncoder__invoke() {
        $rowset = [1=>'a', 2=>'b'];
        $request = $this->request->withAttribute('Response-Body', $rowset);
        $contentRangeHeader = 'items 0-0/1';
        $response = $this->response->withHeader('Content-Range', $contentRangeHeader);
        $response = $response->withStatus(555);    
        $response = $this->object
                ->__invoke($request, $response, $this->next); 
        
        $this->assertEquals(
                $response->getBody()->__toString(),
                '{"1":"a","2":"b"}'
        );
        $this->assertEquals(
                $response->getStatusCode(),
                555
        );
        $headers = $response->getHeaders();
        $this->assertEquals(
                $headers['Content-Range'][0],
                "items 0-0/1"
        );
        $this->assertEquals(
                $headers['content-type'][0],
                "application/json"
        );
    }
    
    

}
