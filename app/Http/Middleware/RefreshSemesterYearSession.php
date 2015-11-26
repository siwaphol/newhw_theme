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
        // Default semester and year in case of there is no data in database to prevent some exception
        if(is_null($q_semester_year)){
            $q_semester_year = new Semesteryears;
            $q_semester_year->semester = '1';
            $q_semester_year->year = '2557';
            $q_semester_year->use = '1';
        }

        if( !\Session::has('semester') || !\Session::has('year') ||
            $q_semester_year->semester !== \Session::get('semester') || $q_semester_year->year !== \Session::get('year')){
            \Session::set('semester', $q_semester_year->semester);
            \Session::set('year', $q_semester_year->year);
        }
        return $next($request);
    }
}
