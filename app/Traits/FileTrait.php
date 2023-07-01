<?php
namespace App\Traits;


trait FileTrait{

    function deleteFolder($folder)
    {

        $path=public_path('uploads/attachments/'.$folder);
        if (is_dir($path) === true)
        {
            $files = array_diff(scandir($path), array('.', '..'));
    
            foreach ($files as $file)
            {
                // dd($file);
                unlink($path.'/'.$file);
            //    $this->deleteFolder(realpath($path) . '/' . $file);
            }
    
             rmdir($path);
        }
    
        else if (is_file($path) === true)
        {
             unlink($path);
        }
    
       
    }

function deleteFile($folder,$file){
    $path=public_path('uploads/attachments/'.$folder.'/'.$file);
    if( file_exists($path) ) {
        unlink($path);
                }
}

}