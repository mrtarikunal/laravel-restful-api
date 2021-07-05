<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ApiLogger
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
        return $next($request);
    }

    public function terminate(Request $request, Response $response)
        //istek tamamlandığında çalışan fonksiyon
    {
        if (env('API_LOGGER', true))
        //env içinde API_LOGGER diye bir değer tanımlıyrz. o değeri true yapınca loglama açılıyor
            //false olduğunda loglama yapmıyor
        {
            $startTime = LARAVEL_START;//url ilk istek zamanı
            $endTime = microtime(true);//url açıldığı an
            $log = '[' . date('Y-m-d H:i:s') . ']';//tarih ve saat
            $log .= '[' . ($endTime-$startTime)*100 . 'ms]';//isteğin ne kadar sürede yapılduğı
            $log .= '[' . $request->ip(). ']';//istek yapanın ip adresi
            $log .= '[' . $request->method(). ']';//isteğin hangi metodla yapıldığı
            $log .= '[' . $request->fullUrl(). ']';//istek yapılan adres

            //Log::info($log);
            //laravel log dosyası içine katdettk

            $fileName = 'api_logger_' . date('Y-m-d'). '.log';
            \File::append(storage_path('logs' . DIRECTORY_SEPARATOR . $fileName), $log. "\n");
            //$fileName ile dosya adını oluştrdk. sonra strogae içindeki logs içine bu dosyayı oluşturup içine logu yazdrdk
            //"\n" alt satıra geçiriyor


        }

    }
}
