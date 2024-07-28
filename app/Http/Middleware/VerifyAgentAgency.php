<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyAgentAgency
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        $agent = Auth::guard('agent')->user();
        $agenceId = $request->input('agence_id');

        if ($agent->agence_id != $agenceId) {
            return redirect()->back()->with('error', 'vous etes suspendu.');
        }

        return $next($request);
    }
}
