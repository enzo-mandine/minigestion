<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use codeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use DeepCopy\Filter\Filter;
use Override;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->has('user')) {
            session()->set('redirect_url', (string) current_url(true));

            return redirect()->to('login')->with('warning', 'Merci de vous connecter pour accéder à cette page.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
