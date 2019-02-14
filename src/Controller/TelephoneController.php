<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Entity\Telephone;

use Symfony\Component\HttpFoundation\Request;

use App\Form\TelephoneType;

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

  /* public function modify($id, $marque, $type, $taille)
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
    } */

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
      $tels = $repo->findBiggerSizeThanQb(5.5);
      return $this->render('telephonerequest.html.twig', array(
        "tels" => $tels,
      ));
    }

    public function advancedsearch($marque, $type)
    {
      $repo = $this->getDoctrine()
          ->getRepository(Telephone::class);
      $tels = $repo->findAdvanced($marque, $type);

      return $this->render('telephoneadvancedsearch.html.twig', array(
        "tels" => $tels,
        "marque" => $marque,
        "type" => $type,
      ));
    }

    public function new(Request $request)
    {
    // Nous créons une entité Telephone
    $tel = new Telephone();

    // Nous créons un formulaire A PARTIR DE $tel
    // ce qui permettra à Symfony d'hydrater (remplir) cette entité une fois que le formulaire sera validé...
    // Nous précisons ici que nous voulons utiliser `TelephoneType` et hydrater $tel
    $form = $this->createForm(TelephoneType::class, $tel);

        $form->handleRequest($request);

    // Si nous venons de valider le formulaire et s'il est valide (problèmes de type, etc)
        if ($form->isSubmitted() && $form->isValid()) {
        // nous enregistrons directement l'objet $tel !
        // En effet, il a été hydraté grâce au paramètre donné à la méthode createFormBuilder !
        $em = $this->getDoctrine()->getManager();
        $em->persist($tel);
        $em->flush();

        // nous redirigeons l'utilisateur vers la route /telephone/
        // nous utilisons ici l'identifiant de la route, créé dans le fichier yaml
        // (il est peut-être différent pour vous, adaptez en conséquence)
        // extrèmement pratique : si nous devons changer l'url en elle-même,
        // nous n'avons pas à changer nos contrôleurs, mais juste les fichiers de configurations yaml
        return $this->redirectToRoute('telephone_index');
    }

    // renvoie classique à Twig...
    return $this->render('new.html.twig', array(
        // en renvoyant l'objet qui va bien à partir de la méthode createView
        'form' => $form->createView(),
    ));
    }

    public function modify(Request $request, $id)
    {
    // Nous créons une entité Telephone
    $tel = $this->getDoctrine()->getRepository(Telephone::class)->find($id);

    // Nous créons un formulaire A PARTIR DE $tel
    // ce qui permettra à Symfony d'hydrater (remplir) cette entité une fois que le formulaire sera validé...
    // Nous précisons ici que nous voulons utiliser `TelephoneType` et hydrater $tel

    $form = $this->createForm(TelephoneType::class, $tel);

    $form->handleRequest($request);

    // Si nous venons de valider le formulaire et s'il est valide (problèmes de type, etc)
        if ($form->isSubmitted() && $form->isValid()) {
        // nous enregistrons directement l'objet $tel !
        // En effet, il a été hydraté grâce au paramètre donné à la méthode createFormBuilder !
        $em = $this->getDoctrine()->getManager();
        $em->persist($tel);
        $em->flush();
        $tel->getId();

        // nous redirigeons l'utilisateur vers la route /telephone/
        // nous utilisons ici l'identifiant de la route, créé dans le fichier yaml
        // (il est peut-être différent pour vous, adaptez en conséquence)
        // extrèmement pratique : si nous devons changer l'url en elle-même,
        // nous n'avons pas à changer nos contrôleurs, mais juste les fichiers de configurations yaml
        return $this->redirectToRoute('telephone_index');
    }

    // renvoie classique à Twig...
    return $this->render('modify.html.twig', array(
        // en renvoyant l'objet qui va bien à partir de la méthode createView
        "id" => $id,
        'form' => $form->createView(),
    ));
    }
}

?>
