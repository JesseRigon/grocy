<?php

namespace Grocy\Controllers;

//cc:init#;Load Session Service
use Grocy\Services\SessionService;

class LoginController extends BaseController
{
	public function LoginPage(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, array $args)
	{
		return $this->renderPage($response, 'login');
	}

	public function Logout(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, array $args)
	{
		$this->getSessionService()->RemoveSession($_COOKIE[SessionService::SESSION_COOKIE_NAME]);
		return $response->withRedirect($this->AppContainer->get('UrlManager')->ConstructUrl('/'));
	}

	public function ProcessLogin(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, array $args)
	{
		$authMiddlewareClass = GROCY_AUTH_CLASS;
		if ($authMiddlewareClass::ProcessLogin($this->GetParsedAndFilteredRequestBody($request)))
		{
			return $response->withRedirect($this->AppContainer->get('UrlManager')->ConstructUrl('/'));
		}
		else
		{
			return $response->withRedirect($this->AppContainer->get('UrlManager')->ConstructUrl('/login?invalid=true'));
		}
	}
}
