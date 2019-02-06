<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Entity\Telephone;

class TelephoneController extends Controller
{
    public function add($marque, $type, $taille)
    {
      $tel = new Telephone();
      $tel->setMarque($marque);
      $tel->setType($type);
      $tel->setTaille($taille);
      $em = $this->getDoctrine()->getManager();
      $em->persist($tel);
      $em->flush();
      $tel->getId();

      return $this->render('telephoneadd.html.twig', array(
        "marque" => $marque,
        "type" => $type,
        "taille" => $taille,
      ));
    }

    public function modify($id, $marque, $type, $taille)
    {
      $tel = $this->getDoctrine()->getRepository(Telephone::class)->find($id);
      $tel->setMarque($marque);
      $tel->setType($type);
      $tel->setTaille($taille);
      $em = $this->getDoctrine()->getManager();
      $em->persist($tel);
      $em->flush();
      $tel->getId();

      return $this->render('telephonemodify.html.twig', array(
        "id" => $id,
        "marque" => $marque,
        "type" => $type,
        "taille" => $taille,
      ));
    }

    public function remove($id)
    {
      $tel = $this->getDoctrine()->getRepository(Telephone::class)->find($id);
      $em = $this->getDoctrine()->getManager();
      $em->remove($tel);
      $em->flush();
      $tel->getId();

      return $this->render('telephoneremove.html.twig', array(
        "id" => $id,
      ));
    }

    public function index()
    {
      $repo = $this->getDoctrine()
          ->getRepository(Telephone::class);
      // par exemple, ici je récupère le téléphone avec l'id 1
      $tels = $repo->findAll();

      return $this->render('telephone.html.twig', array(
        "tels" => $tels,
      ));
    }

    public function request()
    {
      $repo = $this->getDoctrine()
          ->getRepository(Telephone::class);
      $tels = $repo->findBiggerSizeThan(5.5);
      return $this->render('telephonerequest.html.twig', array(
        "tels" => $tels,
      ));
    }

    public function search($chercher)
    {
      $repo = $this->getDoctrine()
          ->getRepository(Telephone::class);
      $tels = $repo->findMarque($chercher);

      return $this->render('telephonesearch.html.twig', array(
        "tels" => $tels,
        "chercher" => $chercher,
      ));
    }

    public function requestqb()
    {
      $repo = $this->getDoctrine()
          ->getRepository(Telephone::class);
      $tels = $repo->findBiggerSizeThan(5.5);
      return $this->render('telephonerequest.html.twig', array(
        "tels" => $tels,
      ));
    }
}

?>
