<?php

namespace App\TwigExtensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigFiltree extends AbstractExtension
{
public function getFilters()
{
    return [new TwigFilter('defaultImage',[$this,'defauuultImage']),];
}
public function defauuultImage($path){
//    if(strlen(trim($path))==0)
      if(!file_exists($path))
        $path="assets/todo_assets/images/footer-bg.png";

 return $path;
}
// pour verifier si le fichier est image :
//    function check_image_mime($tmpname){
//        $finfo = finfo_open(FILEINFO_MIME_TYPE);
//        $mtype = finfo_file($finfo, $tmpname);
//        if(strpos($mtype, 'image/') === 0){
//            echo "C'est une image";
//        } else {
//            echo "Ce n'est pas une image";
//        }
//        finfo_close($finfo);
//    }
}