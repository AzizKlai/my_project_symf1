<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Entity\Pfe;
use App\Form\PfeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/entreprise')]
class EntrepriseController extends AbstractController
{
    #[Route('/list', name: 'entreprise.list')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $manager = $doctrine->getManager();
        $repository = $doctrine->getRepository(Entreprise::class);
        $entreprises = $repository->findAll();
        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $entreprises,
        ]);
    }

    #[Route('/detail/{id<\d+>}', name: 'entreprise.detail')]
    public function detail(ManagerRegistry $doctrine, Entreprise $entreprise = null): Response
    {
        if (!$entreprise) {
            $this->addFlash('danger', "aucune entreprise de cet id ");
            return $this->redirectToRoute('entreprise.list');
        }
        return $this->render('entreprise/entreprisedetail.html.twig', [
            'entreprise' => $entreprise,
        ]);
    }

    #[Route('/detail/{ide<\d+>}/pfe/edit/{id<\d+>?0}', name: 'pfe.edit')]
    public function editpfe( ManagerRegistry $doctrine,$ide, Request $request,Pfe $pfe = null): Response
    {   $entitymanager=$doctrine->getManager();
       $entityrepository=$doctrine->getRepository(Entreprise::class);
       $entreprise=$entityrepository->find($ide);
        if(!$entreprise)
    { $this->addFlash('danger',"cette entreprise n'existe pas");
        return $this->redirectToRoute('entreprise.list');
    }
        else{

        $new = false;
        if (!$pfe) {
            $pfe = new Pfe();
            $new = true;
        }
        //$personne va etre l'image du formulaire
        $form = $this->createForm(PfeType::class, $pfe);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $entitymanager->persist($pfe);

            if ($new) {
                $this->addFlash('success', $pfe->getName() . ' a été ajouté avec succés');
                $entreprise->addPfe($pfe);
            } else {
                $this->addFlash('success', $pfe->getName() . ' a été modifié avec succés');
            }
            $entitymanager->flush();
            return $this->redirectToRoute('entreprise.detail',['id'=>$ide]);
        } else {//sinon
            //on affiche notre forumalre avec une message d'erreur
            return $this->render('entreprise/pfeedit.html.twig', [
                'form' => $form->createView(),
            ]);
        }}
    }
    #[Route('/detail/{ide<\d+>}/pfe/delete/{id<\d+>?0}', name: 'pfe.delete')]
    public function deletepfe( ManagerRegistry $doctrine,$ide, Request $request,Pfe $pfe = null): Response
    {   $entitymanager=$doctrine->getManager();
        $entityrepository=$doctrine->getRepository(Entreprise::class);
        $entreprise=$entityrepository->find($ide);
        if(!$entreprise)
        {  $this->addFlash('danger',"cette entreprise n'existe pas");
            return $this->redirectToRoute('entreprise.list');
        }

        if ($pfe) {
            $entreprise->removePfe($pfe);
            $entitymanager->remove($pfe);
            $this->addFlash('success', $pfe->getName() . ' a été supprimé avec succés');

            $entitymanager->flush();
        }
            return $this->redirectToRoute('entreprise.detail',['id'=>$ide]);

    }
}
