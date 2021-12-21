<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    // declaration de la variable repository (fichier ou l'on traite les requetes de recherche)
    /**
     * @var PropertyRepository
     * */
    private $repository;

    /**
     * @var Doctrine
     * */
    private $doctrine;

    // declaration du constructeur en lui passant son repository
    public function __construct(PropertyRepository $repository, ManagerRegistry $doctrine)
    {
        $this->repository = $repository;
        $this->doctrine = $doctrine;
    }

    // REQUETE POUR INSERTION DE BIENS

    // ManagerRegistry $doctrine comme parametre de la fonction
//        // instantiation du nouveau bien
//        $property = new \App\Entity\Property();
//        // on rempli les caracteristiques du bien
//        $property->setTitle('Apartement 3 pièces')
//            ->setPrice(200000)
//            ->setRooms(3)
//            ->setBedrooms(1)
//            ->setSurface(21)
//            ->setDescription('Apartement face mer. Lumineux et à très bon prix. Foncez !')
//            ->setFloor(4)
//            ->setHeat(1) // definir dans la classe Property dans un tableau
//            ->setCity('Monpellier')
//            ->setAdress('1581 Route de Mende')
//            ->setPostalCode('34090');
//            // la date, le sold et le heat sont gérés dans la classe Property
//        // on instancie le manager (entityManager) de Doctrine, qui se chargé de gerer et sauvegarder les informations dans la base de données
//        $entityManager = $doctrine->getManager();
//        // on dit a Doctrine que nous allons (eventuellement) sauvegarder $property (pour l'instant pas d'ajout au niveau de la BDD)
//        $entityManager->persist($property);
//        // porter les changements dans l'entity manager dans la BDD (execution des INSERT...)
//        $entityManager->flush();

    // RETOUR DES BIENS NON VEDUS
//        $property = $this->repository->findAllVisible();
//        $property[0]->setSold(true);
//        $entityManager = $this->doctrine->getManager();
//        $entityManager->flush();
//        dump($property);

    #[Route('/biens', name: 'property.index')]
    public function index() : Response
    {

        return $this->render('property/propertyIndex.html.twig',
        [
            'current_menu' => 'property.index'

        ]);

    }
    /**
     *
     * @return Response
     * */

    #[Route('/biens/{slug}-{id}', name: 'property.show', requirements: ['slug' => '[a-z0-9\-]*'])]
    public function show($slug, $id) : Response{
        $property = $this->repository->find($id);
        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current-menu' => 'properties'
        ]);

    }
}