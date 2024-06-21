<?php

namespace App\Exceptions;

 use Exception;
//use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Jenssegers\Agent\Facades\Agent;

class Handler extends ExceptionHandler {
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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    // public function report(Exception $exception) {
    //     parent::report($exception);
    // }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception) {
        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
                
             if (in_array('api', $exception->guards())){
                return \App\Http\Controllers\API\ApiController::error(trans('api_handler.invalid_auth_token'), 401);
            }
            if ($request->is('admin') || $request->is('admin/*')) {
                 return redirect()->guest(route('login'));
            }
            if ($request->is('customer') || $request->is('customer/*')) {
                 return redirect()->guest(route('customer.login'));
            }
            
            return redirect()->guest(route('provider.login'));   
//            return \App\Http\Controllers\API\ApiController::error('Invalid AUTH Token', 401);
       }
       else{
        if($this->isHttpException($exception)){
            // $device = Agent::device();
// dd($device,Agent::platform(),Agent::isDesktop(),Agent::isIphone(),Agent::isAndroidOS());
// if(Agent::isDesktop()!==true):
//     if(Agent::isAndroidOS()===true):
//         return redirect('android');
//     endif;
//     if(Agent::platform()==='iOS'):
//         return redirect('ios');
//     endif;
// endif;
            //dd($exception->getStatusCode());  
            if($exception->getStatusCode() == '404'){
                return response()->view('errors.404');
                   }
            elseif($exception->getStatusCode() == '500'){
                return response()->view('errors.500');
            }
            elseif($exception->getStatusCode() == '405'){
                return response()->view('errors.405');
            }
             elseif($exception->getStatusCode() == '400'){
                return response()->view('errors.400');
            }
            elseif($exception->getStatusCode() == '503'){
                return response()->view('errors.503');
            }
            elseif($exception->getStatusCode() == '301'){
                return response()->view('errors.301');
                }
        }
       }
        return parent::render($request, $exception);
    }


}
