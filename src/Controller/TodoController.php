<?php

namespace App\Controller;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/todo')]
class TodoController extends AbstractController
{
    #[Route('', name: 'app_todo')]
    public function index(Request $request): Response
    { //session_start()
        $session=$request->getSession();
        if($session->has('current_user'))
            return $this->redirectToRoute('app_user_todo',['user'=>$session->get('current_user')]);

//        else $session->set('nbvisit',1);
//        $session->set('nbvisit',$session->get('nbvisit')+1);
       
        return $this->render('todo/login.html.twig');
    }


    #[Route('/login', name: 'app_login_todo')]
    public function indexlogin(Request $request): Response
    {   $_POST=$request->request;
        $session=$request->getSession();
        if($_POST->get('nom').'°'.$_POST->get('pass')!='°'){
        if(!$session->has($_POST->get('nom').'°'.$_POST->get('pass')))
        {$session->set($_POST->get('nom').'°'.$_POST->get('pass'),array());
        }
        $session->set('current_user',$_POST->get('nom').'°'.$_POST->get('pass'));

        return $this->redirectToRoute('app_user_todo',['user'=>$session->get('current_user')]);}
        return $this->redirectToRoute('app_todo');
    }

    #[Route('/login/{user}', name: 'app_user_todo')]
    public function indexuser(Request $request, $user): Response
    {    $session=$request->getSession();
//        echo $session->get('current_user');
//        foreach($session->get($user) as $data) {
//            dd($data);
//        }
        if(!$session->has('current_user')||$user!=$session->get('current_user')){
            return $this->redirectToRoute('app_todo');
        }
        $position = strpos($user,'°');
        $name = substr($user,0,$position);
        return $this->render('todo/todolist.html.twig',['lasession'=>$session->get($user),'utilisateur'=>$user,'name'=>$name]);
    }
    #[Route('/login/{user}/+', name: 'app_+_todo')]
    public function indexajou(Request $request,$user): Response
    {    $session=$request->getSession();
        $_POST=$request->request;
        if(!$session->has('current_user')||$user!=$session->get('current_user')){
            return $this->redirectToRoute('app_todo');}
            $tab=$session->get($user);
            $taille=count($tab);
            $tab[$taille][0]=$_POST->get('titre');
            $tab[$taille][1]= $_POST->get('note');
            $session->set($user,$tab);

        return $this->redirectToRoute('app_user_todo',['user'=>$session->get('current_user')]);
    }









    #[Route('/delete/{nb}', name: 'app_delete_todo')]
    public function indexdelelete(Request $request,$nb): Response
    {  $session=$request->getSession();
        $tab=$session->get($session->get('current_user'));
        array_splice($tab,$nb,1);
        $session->set($session->get('current_user'),$tab);
        return $this->forward('App\Controller\TodoController::index');
    }
    #[Route('/delete_user', name: 'app_delete_user_todo')]
    public function indexdeleleteuser(Request $request): Response
    {  $session=$request->getSession();
        $session->remove($session->get('current_user'));
        $session->remove('current_user');
        return $this->forward('App\Controller\TodoController::index');
    }
    #[Route('/deconnecte', name: 'app_deconnecte')]
    public function indexdeconnecte(Request $request): Response
    {$session=$request->getSession();
        $session->remove('current_user');
        return $this->redirectToRoute('app_todo');


    }
}
