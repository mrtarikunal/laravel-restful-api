<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadRequest;
use Illuminate\Http\Request;

class UploadController extends Controller
{
   public function upload(UploadRequest $request)
   {
       if($request->file('uploadFile')->isValid())
           //isValid dosya başarılı bir şiklde sunucuya yüklendiğini ifade eder
       {
           $file = $request->file('uploadFile');

           // $path = $request->uploadFile->path();
           //bunu sunucu dosyayı geçici bir alana alıyor onun url almak için.yüksek boyutlu dosya yüklemelerinde lazım olabilr
           //ayrıca $request->file('uploadFile') = $request->uploadFile böyle bir kullanımda var

           $fileNameWithExtension = $file->getClientOriginalName();

          // $fileNameWithExtension2 = $request->userId . '-' . time() . $fileNameWithExtension;
          //alternatif dosya isimleri oluşturulabilir

          // $fileUrl= $file->storeAs('uploads/images', $fileNameWithExtension, 'local');
          //storage klasörüne kaydetmek için bunu kullnyrz. uploads/images ile app altında alt klasörler olustrr
           //3. local paraemtresi uploads ve altındaki images klasörlerini storage klasörü altındaki
           //app klasörü altında oluştrr. bu klasörlere tarayıcıdan doğrudan ulaşamayız. eğer bunu local değilde public yaprsak
           // o zaman uploads ve altındaki images klasörü storage klasörü altındaki app içindeki public klasörü içinde oluşur.
           // bu kalsöre dışardan  direk ulaşım vardır
           //php artisan storage:link komutu uygulamamız lazım. bu komutla normal public altında storage klasörünün bir kopyasını oluştrr. ama sadece storage app public in

            if ($file->move(public_path('/uploads/'), $fileNameWithExtension))
            //public klasörü altında uploads klaörü olştrr ve oraya yükler
          {
               $fileUrl = url('/uploads/'. $fileNameWithExtension);
               return response()->json(['url' => $fileUrl]);

              //return response()->json(['url' => asset("storage/$fileUrl")]);
              //eğer storage a kaydedersek böyle kullanrz public için. burda göreceli yolu alır

             // return response()->json(['url' => \Storage::url($fileUrl)]);
              // eğer stotage kayıtta s3 kullanırsak böyle yaprz.burda tam yolu alır.
          }
       }

   }
}
