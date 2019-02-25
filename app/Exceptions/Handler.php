<?php

namespace Corp\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Corp\Repositories\MenusRepository;
use Corp\Menu;
use Corp\Http\Controllers\SiteController;

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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if($this->isHttpException($exception)) {
            $statusCode = $exception->getStatusCode();
            
            switch($statusCode) {
                case '404':
                    
                    $obj = new SiteController(new MenusRepository(new Menu));
                    $navigation = view(config('settings.theme').'.navigation')->with('menu',$obj->getMenu())->render();
                    
                    \Log::alert('Not found - '. $request->url());
        
                    return response()->view(config('settings.theme').'.404',['bar'=> 'no','title'=>'Not found', 'navigation'=>$navigation]);
            }
        }
        return parent::render($request, $exception);
    }
}
