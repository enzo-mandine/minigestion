<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ThrottleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $capacity = (int) ($arguments[0] ?? 5);
        $seconds  = (int) ($arguments[1] ?? MINUTE);

        $throttler = service('throttler');
        $key       = 'throttle_' . md5($request->getIPAddress() . '|' . $request->getUri()->getPath());

        if ($throttler->check($key, $capacity, $seconds) === false) {
            $attente = max(1, $throttler->getTokenTime());

            return redirect()->back()
                ->with('error', "Trop de tentatives. Réessayez dans {$attente} seconde(s).");
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
