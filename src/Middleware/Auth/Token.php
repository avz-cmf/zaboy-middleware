<?php
/**
 * File contains Class TokenAuth
 * https://github.com/ma4eto/expressive-sandbox/blob/master/src/App/Middleware/TokenAuth.php
 * @since  08.09.2015
 * @author Eduard Posinitskii <eduard.posinitskii@veeam.com>
 */
namespace App\Middleware;
use App\Auth\AuthService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;
/**
 * Class TokenAuth
 *
 * @category Propartner
 * @package  App\Middleware
 * @author   Eduard Posinitskii <eduard.posinitskii@veeam.com>
 */
class TokenAuth implements MiddlewareInterface
{
    /**
     * @var AuthService
     */
    protected $authService;
    /**
     * TokenAuth constructor.
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    /**
     * Process an incoming request and/or response.
     *
     * Accepts a server-side request and a response instance, and does
     * something with them.
     *
     * If the response is not complete and/or further processing would not
     * interfere with the work done in the middleware, or if the middleware
     * wants to delegate to another process, it can use the `$out` callable
     * if present.
     *
     * If the middleware does not return a value, execution of the current
     * request is considered complete, and the response instance provided will
     * be considered the response to return.
     *
     * Alternately, the middleware may return a response instance.
     *
     * Often, middleware will `return $out();`, with the assumption that a
     * later middleware will return a response.
     *
     * @param Request       $request
     * @param Response      $response
     * @param null|callable $out
     *
     * @return null|Response
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $authHeader = $request->hasHeader('Authorization') ? $request->getHeaderLine('Authorization') : null;
        if (empty($authHeader)) {
            return $this->unauthorizedResponse($response);
        }
        if (false === strpos($authHeader, 'token')) {
            return $this->unauthorizedResponse($response);
        }
        list(, $token) = explode(' ', $authHeader);
        if (!isset($token)) {
            return $this->unauthorizedResponse($response);
        }
        if (!$this->authService->authorize($token)) {
            return $this->forbiddenResponse($response);
        }
        return $out($request, $response);
    }
    private function unauthorizedResponse(Response $response)
    {
        return $response->withStatus(401);
    }
    private function forbiddenResponse(Response $response)
    {
        return $response->withStatus(403);
    }
}