<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/first/{section}', name: 'app_first')]
    public function index(Request $request,$section=' aziz pardefaut'): Response
    {   //die('je suis la requelte die');
        //return new Response('<html><body>Bonjour tout  le monde !</body></html>');
        return $this->render('first/index.html.twig', [
            'controller_name' => 'FirstController'.$section,
            'path'=>'assets/todo_assets/images/slider-img.png',
        ]);
    }
//    #[Route('/hello/{fistname}/{name}', name: 'app.sayhello')]
    public function sayhello($name,$firstname){
     return $this->render('first/sayhello.html.twig',[
         'firstname'=>$firstname,
         'name'=>$name,
     ]);
    }

    #[Route('/second', name: 'app_second')]
    public function second(Request $request): Response
    {   //die('je suis la requelte die');
        $ran=rand(0,10);
        echo $ran;
        if($ran <1) {

            return new Response('<html><body>Bonjour tout  le monde <br><h1>this is the second page</h1></body></html>');
        }
        if($ran <9) {

            return $this->redirectToRoute('app_first',['section'=>$ran]);
        }
        dd($request);
        return $this->forward('App\Controller\FirstController::index');
    }
    #[Route('/multi/{int1}/{int2<\d+>}', name: 'app_multiplication',requirements: ['int1'=>'\d+'])]
    public function multiplication($int1,$int2): Response{
        $resultat=$int1*$int2;
        return(new Response("<h1> $resultat <h1>"));
    }


}
