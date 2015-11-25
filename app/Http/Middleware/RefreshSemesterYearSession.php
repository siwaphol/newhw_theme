<?php

namespace App\Http\Middleware;

use App\Semesteryears;
use Closure;

class RefreshSemesterYearSession
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
        $q_semester_year = Semesteryears::where('use','1')->first();
        if($q_semester_year->semester !== \Session::get('semester') || $q_semester_year->year !== \Session::get('year')
            || !\Session::has('semester') || !\Session::has('year')){
            \Session::set('semester', $q_semester_year->semester);
            \Session::set('year', $q_semester_year->year);
        }
        return $next($request);
    }
}
