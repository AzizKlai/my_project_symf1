<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Config\Twig\NumberFormatConfig;

#[Route('/personne')]
class PersonneController extends AbstractController
{   #[Route('/', name: 'personne.list')]
    public function index(ManagerRegistry $doctrine): Response
    {   $entitymanager=$doctrine->getManager();
        $entityrepository=$doctrine->getRepository(Personne::class);
        $personnes=$entityrepository->findAll();
        return $this->render('personne/personnelist.html.twig', [
            'personnes'=>$personnes,
            'ispaginated'=>false,
        ]);
    }

    #[Route('/alls/{page<\d+>?1}/{nbel<\d+>?9}', name: 'personne.alls')]
    public function alls(ManagerRegistry $doctrine,$page,$nbel): Response
    {   $entitymanager=$doctrine->getManager();
        $entityrepository=$doctrine->getRepository(Personne::class);
//        $personne=$entityrepository->findBy(['name'=>'aziz'],['age'=>'ASC'],2,2);
        $nbtotal=$entityrepository->count([]);
        if($page>ceil($nbtotal/$nbel)){$this->addFlash('danger','page not found'); }
        $personnes=$entityrepository->findBy([],['age'=>'ASC'],$nbel,($page-1)*$nbel);

        return $this->render('personne/personnelist.html.twig', [
            'personnes'=>$personnes, 'ispaginated'=>true,
            'nbpage'=>ceil($nbtotal/$nbel),
            'page'=>$page,
            'nbel'=>$nbel,
        ]);
    }

    #[Route('/alls/age/{ageMin<\d+>}/{ageMax<\d+>}', name: 'personne.alls.ageInterval')]
    public function personneAgeInterval(ManagerRegistry $doctrine,$ageMin,$ageMax): Response
    {
        $entityrepository=$doctrine->getRepository(Personne::class);
        $personnes=$entityrepository->getPersonneByAge($ageMin,$ageMax);
        $stats=$entityrepository->getStatPersonneByAge($ageMin,$ageMax);

        return $this->render('personne/personnelist.html.twig', [
            'personnes'=>$personnes,
            'ageMin'=>$ageMin,
            'ageMax'=>$ageMax,
             'stat'=>$stats[0],

        ]);
    }
    #[Route('/{id<\d+>}', name: 'personne.detail')]
    public function detail(ManagerRegistry $doctrine,Personne $personne): Response{
//        $entitymanager=$doctrine->getManager();
//        $entityrepository=$doctrine->getRepository(Personne::class);
//        $personne=$entityrepository->find($id);
        if(!$personne){
            $this->addFlash('danger',"aucune personne d'id ");
            return $this->redirectToRoute('personne.list');
        }
        return $this->render('personne/personnedetail.html.twig', [
            'personne'=>$personne,
        ]);
    }

    #[Route('/add/{firstname}/{name}/{age<\d+>}', name: 'personne.add')]
    public function addpersonne(ManagerRegistry $doctrine,$firstname,$name,$age): Response
    {   $entitymanager=$doctrine->getManager();
        $personne1=new Personne();
        $personne1->setFirstname($firstname);
        $personne1->setName($name);
        $personne1->setAge($age);
        $entitymanager->persist($personne1);
        //pour le commit
        $entitymanager->flush();
        $this->addFlash('success','personne ajoutée avec succés');
        return $this->redirectToRoute('personne.detail',['id'=>$personne1->getId()]);
    }
    #[Route('/edit/{id<\d+>?0}', name: 'personne.edit')]
    public function addpersonneform(Personne $personne=null,ManagerRegistry $doctrine,Request $request): Response
    {   $entitymanager=$doctrine->getManager();
        $new=false;
        if(!$personne){
            $personne=new Personne();
        }
       //$personne va etre l'image du formulaire
        $form=$this->createForm(PersonneType::class,$personne);
        $form->remove('createdAt');
        dump($request);

        // mon formulaire va aller traiter la requete
        $form->handleRequest($request);
        // est ce que le formulaire a été soumis
        if($form->isSubmitted()){
          //si oui
            // on va ajouter l'obget personne dan la base de données form->getData():an array
            $entitymanager->persist($personne);
            $entitymanager->flush();
            //rediiriger vers la liste des personne
            // afficher un message de succés
            if($new) {
                $this->addFlash('success', $personne->getFirstname() . ' a été ajouté avec succés');}
            else{$this->addFlash('success', $personne->getFirstname() . ' a été modifié avec succés');}
            return $this->redirectToRoute('personne.list');
        }
        else{//sinon
            //on affiche notre forumalre avec une message d'erreur
            return $this->render('personne/personneedit.html.twig',[
            'form'=>$form->createView(),
        ]); }
    }
    #[Route('/delete/{id<\d+>}', name: 'personne.delete')]
    public function delete(ManagerRegistry $doctrine,Personne $personne=null ): RedirectResponse
    {
        if ($personne){
            $entitymanager = $doctrine->getManager();
            $entitymanager->remove($personne);
            $entitymanager->flush();
            $this->addFlash('success','personne supprimée avec succés');
    }
        else{
            $this->addFlash('danger','pas de personne');
        }
        return $this->redirectToRoute('personne.list');
    }
    #[Route('/update/{id<\d+>}/{firstname}/{name}/{age}', name: 'personne.update')]
    public function update(ManagerRegistry $doctrine,Personne $personne=null,$name,$firstname,$age): RedirectResponse
    {
        if ($personne){
            $personne->setFirstname($firstname);
            $personne->setName($name);
            $personne->setAge($age);
            $entitymanager=$doctrine->getManager();
            $entitymanager->persist($personne);
            //pour le commit
            $entitymanager->flush();
            $this->addFlash('success','personne mis à jour avec succés');
        }
        else{
            $this->addFlash('danger','pas de personne');
        }


        return $this->redirectToRoute('personne.list');
    }

}
