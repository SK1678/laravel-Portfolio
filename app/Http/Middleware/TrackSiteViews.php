<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class TrackSiteViews
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Don't count AJAX requests or admin dashboard visits
        if (!$request->ajax() && !Str::startsWith($request->path(), ['admin', 'dashboard'])) {
            // 1. Log EVERY page load to site_analytics for the chart
            \DB::table('site_analytics')->insert([
                'type' => 'view',
                'created_at' => now(),
            ]);

            // 2. Log unique session for total stats and visitor types
            if (!session()->has('site_viewed')) {
                $returning = $request->hasCookie('has_visited');
                
                if ($returning) {
                    \DB::table('site_settings')->increment('returning_views');
                } else {
                    \DB::table('site_settings')->increment('first_time_views');
                    // Attach cookie for future visits (lasts 1 year)
                    cookie()->queue(cookie()->forever('has_visited', 'true'));
                }

                \DB::table('site_settings')->increment('total_site_views');
                session()->put('site_viewed', true);
            }
        }

        return $response;
    }
}
