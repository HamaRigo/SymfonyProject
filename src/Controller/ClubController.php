<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\ClubType;
use App\Repository\ClubRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends AbstractController
{
    /**
     * @Route("/club", name="club")
     */
    public function index(): Response
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);
    }
    /**
     * @Route("/listClub", name="listClub")
     */
    public function listClub(){
        $clubs=$this->getDoctrine()->getRepository(Club::class)->findAll();
        return $this->render("Club/listClub.html.twig",array("tabClub"=>$clubs->createView()));
    }
    /**
     * @Route("/showClub/{id}", name="showClub")
     */
    public function showClub($id){

        $club =$this->getDoctrine()->getRepository(Club::class)->find($id);
        return $this->render("Club/showClub.html.twig",array("club"=>$club->createView()));
    }
    /**
     * @Route("/deleteClub/{id}", name="deleteClub")
     */
    public function deleteClub($id){
        $club =$this->getDoctrine()->getRepository(Club::class)->find($id);
        $em=$this->getDoctrine()->getManager();
       $em->remove($club);
       $em->flush();
       return $this->redirectToRoute("listClub");
    }
    /**
     * @Route("/addClub/", name="addClub")
     */
    public function addClub(Request $request){
        $club=new Club();
        $form=$this->createForm(ClubType::class,$club);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute("listClub");

        }
        return $this->render("club/addClub.html.twig",array('formulaireClub'=>$form->createView()));
    }
    /**
     * @Route("/updateClub/{id}", name="updateClub")
     */
    public function updateClub(Request $request,ClubRepository $repository,$id){
        $club=$repository->find($id);
        $form=$this->createForm(ClubType::class,$club);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("listClub");
        }
        return $this->render("club/updateClub.html.twig",array('FormupdateClub'=>$form->createView()));
    }
}
