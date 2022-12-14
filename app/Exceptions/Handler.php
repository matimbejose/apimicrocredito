<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use Config;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];
    

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        // $this->reportable(function (Throwable $e) {
        //     if ($e instanceof \Illuminate\Database\QueryException) {
        //         dd(['error'=>Config::get('errorcodes.codes.db_connection_error')]);
        //        // return response()->json(['error'=>]);
        //     } 
            
        // });
    }

    // public function render() {
    //     if ($e instanceof \Illuminate\Database\QueryException) {
    //         dd($e->getMessage());
    //         //return response()->view('custom_view');
        // } elseif ($e instanceof \PDOException) {
        //     dd($e->getMessage());
        //     //return response()->view('custom_view');
        // }
    // }
}
