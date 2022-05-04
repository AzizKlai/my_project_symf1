<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    #[Route('/list', name: 'app_list')]
    public function index(Request $request): Response
    {  $session=$request->getSession();
       if(!$session->has('todods')){
           $todods = [
               'achat'=>'acheter clé usb',
               'cours'=>'Finaliser mon cours',
               'correction'=>'corriger mes examens'
           ];
           $session->set('todods',$todods);
           $this->addFlash('info',"la liste vient d'etre initialisée");
       }
        // afficher la liste de totdo
        // si la liste existe dans la session je l'affiche
        // sino je l'initialise
        return $this->render('list/index.html.twig',);
    }
    #[Route('/list/add/{name}/{content}',name: 'list.add')]
    public function addlist(Request $request,$name,$content='test'):RedirectResponse{
        $session=$request->getSession();
        // verifier l'exsitance de la liste
        if($session->has('todods')){
            // si oui
            $todods=$session->get('todods');
            //verirfier si le nom existe deja
            if(isset($todods[$name])){
                //si oui erreur
              $this->addFlash('danger','le todo existe deja');

            }
            else{// sinon l'ajouter
                $todods[$name]=$content;
                $this->addFlash('success',"le todo d'id $name est ajouté avec succés");
                $session->set('todods',$todods);

               }


        }
        else{ //sinon afficher erreur et rediriger vers controlleur index
            $this->addFlash('danger',"la liste n'est pas encore initialisée");
        }
        return $this->redirectToRoute('app_list');


    }
    #[Route('/list/update/{name}/{content?test}',name: 'list.update')]
    public function upadatelist(Request $request,$name,$content):RedirectResponse{
        $session=$request->getSession();
        // verifier l'exsitance de la liste
        if($session->has('todods')){
            // si oui
            $todods=$session->get('todods');
            //verirfier si le nom existe deja
            if(!isset($todods[$name])){
                //si non erreur
                $this->addFlash('danger',"le todo n'existe pas");
            }
            else{// si ou on le modifie
                $todods[$name]=$content;
                $this->addFlash('success',"le todo d'id $name est modifié avec succés");
                $session->set('todods',$todods);
            }
        }
        else{ //sinon afficher erreur et rediriger vers controlleur index
            $this->addFlash('danger',"la liste n'est pas encore initialisée");
        }
        return $this->redirectToRoute('app_list');
    }
    #[Route('/list/delete/{name}',name: 'list.delete',defaults: ['name'=>'dimanche'])]
    public function deletelist(Request $request,$name):RedirectResponse{
        $session=$request->getSession();
        // verifier l'exsitance de la liste
        if($session->has('todods')){
            // si oui
            $todods=$session->get('todods');
            //verirfier si le nom existe deja
            if(!isset($todods[$name])){
                //si non erreur
                $this->addFlash('danger',"le todo n'existe pas");
            }
            else{// si ou on le modifie
                unset($todods[$name]);
                $this->addFlash('success',"le todo d'id $name est supprimé avec succés");
                $session->set('todods',$todods);
            }
        }
        else{ //sinon afficher erreur et rediriger vers controlleur index
            $this->addFlash('danger',"la liste n'est pas encore initialisée");
        }
        return $this->redirectToRoute('app_list');
    }
    #[Route('/list/reset',name: 'list.reset')]
    public function resetlist(Request $request):RedirectResponse{
        $session=$request->getSession();
        $session->remove('todods');
        return $this->redirectToRoute('app_list');
    }
}
