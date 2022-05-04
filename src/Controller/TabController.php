<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabController extends AbstractController
{
    #[Route('/tab/{taille<\d+>?5}',name:'app_tab')]
//#[Route('/tab/{taille?5</d+>}',name:'app_tab')] ?5</d+> donne taille =?5</d+> et la considére comme 6
// ordre important <\d+>?5
    public function tab($taille){
        for($i=0;$i<$taille;$i++){
            $tab[]=rand(2,20);
        }
        return $this->render('/tab/index.html.twig', [
            'taille'=>$taille,
            'table' => $tab,
        ]);
    }
    #[Route('/tab/users',name:'tab.users')]
    public function tab2(){
        $users=[
            ['firstname'=>'aziz','name'=>'klai','age'=>20],
            ['firstname'=>'ala','name'=>'boyka','age'=>21],
            ['firstname'=>'hamza','name'=>'klai','age'=>22],
            ['firstname'=>'nizek','name'=>'nizar','age'=>23],
            ['firstname'=>'blead','name'=>'treat','age'=>25],
        ];
        return $this->render('/tab/users.html.twig',[
     'users'=>$users
        ]);
    }

}
