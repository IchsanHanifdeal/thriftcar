<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

class DateFormatMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof \Illuminate\Http\Response) {
            $content = $response->getContent();
            $content = preg_replace_callback('/\d{4}-\d{2}-\d{2}/', function ($matches) {
                return Carbon::parse($matches[0])->format('d-m-Y');
            }, $content);

            $response->setContent($content);
        }

        return $response;
    }
}

