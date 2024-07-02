<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use App\Exceptions\InvalidOrderException;
// use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;
use Throwable;
use Exception;

class Handler extends ExceptionHandler {
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
        '_token'
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    // public function register(): void
    // {
    //     $this->reportable(function (Throwable $e) {
    //         //
    //     });
    // }

    public function render($request, Throwable $e) {
        if ($e instanceof TokenMismatchException && $request->getRequestUri() === '/kasir/logout'
            || $e instanceof TokenMismatchException && $request->getRequestUri() === '/admin/logout'  
            || $e instanceof TokenMismatchException && $request->getRequestUri() === '/marketing/logout' 
            || $e instanceof TokenMismatchException && $request->getRequestUri() === '/tenant/logout'    
        ) {
            return redirect('/');
        }

        return parent::render($request, $e);
    }


    public function register(): void {
        $this->renderable(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => $e->getMessage(),
                ]);
            }
        });
    }
}
