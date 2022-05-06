<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{
    #[Route('/etudiant', name: 'app_etudiant')]
       public function index(ManagerRegistry $doctrine): Response
    {
        $manager = $doctrine->getManager();
        $repository = $doctrine->getRepository(Etudiant::class);
        $etudiants = $repository->findAll();
        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiants,
        ]);

    }
    #[Route('etudiant/edit/{id<\d+>?0}', name: 'etudiant.edit')]
    public function editetudiant(Etudiant $etudiant=null,ManagerRegistry $doctrine,Request $request): Response
    {   $entitymanager=$doctrine->getManager();
        $new=false;
        if(!$etudiant){
            $etudiant=new Etudiant();
            $new=true;
        }
        $form=$this->createForm(EtudiantType::class,$etudiant);

        $form->handleRequest($request);
        if($form->isSubmitted()){

            $entitymanager->persist($etudiant);
            $entitymanager->flush();
            if($new) {
                $this->addFlash('success', $etudiant->getNom() . ' a été ajouté avec succés');}
            else{$this->addFlash('success', $etudiant->getNom() . ' a été modifié avec succés');}
            return $this->redirectToRoute('app_etudiant');
        }
        else{//sinon
            //on affiche notre forumalre avec une message d'erreur
            return $this->render('etudiant/etudiantadd.html.twig',[
                'form'=>$form->createView(),
            ]); }
    }

    #[Route('/delete/{id<\d+>}', name: 'etudiant.delete')]
    public function deleteetudiant(ManagerRegistry $doctrine,Etudiant $etudiant=null ): Response
    {
        if ($etudiant){
            $entitymanager = $doctrine->getManager();
            $entitymanager->remove($etudiant);
            $entitymanager->flush();
            $this->addFlash('success','etudiant supprimée avec succés');
        }
        else{
            $this->addFlash('danger','pas de personne');
        }
        return $this->redirectToRoute('app_etudiant');
    }

}
