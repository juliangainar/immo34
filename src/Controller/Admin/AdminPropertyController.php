<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ManagerRegistry;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;


class AdminPropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private PropertyRepository $repository;

    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $doctrine;


    public function __construct(PropertyRepository $repository, ManagerRegistry $doctrine)
    {
        $this->repository = $repository;
        $this->doctrine = $doctrine;
    }

    #[Route('/admin', name: 'admin.property.index')]
    public function index(): Response
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', [
            'properties' => $properties
        ]);
    }

    /**
     * @return Response
     */
    #[Route('/admin/property/create', name: 'admin.property.new')]
    public function addNew(Request $request) : Response{
        // on instancie une nouvelle propriete
        $property = new Property();
        // on crée un formulaire en lui passant la propriété
        $form = $this->createForm(PropertyType::class, $property);

        // on demande au formulaire de gerer la requete
        // il va comparer et definir les champs
        $form->handleRequest($request);
        // on verifie que tout se soi bien passé
        if($form->isSubmitted() && $form->isValid()){
            // on sauvegarde les changements au niveau de la base de données
            $entityManager = $this->doctrine->getManager();
            // on lui dit de persister la propriete
            $entityManager->persist($property);
            // puis on la sauvegarde dans la BDD
            $entityManager->flush();
            $this->addFlash('success', 'Bien ajouté avec succès.');
            return $this->redirectToRoute('admin.property.index');


        }
        return $this->render('admin/property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Property $property
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/property/{id}', name: 'admin.property.edit')]
    public function edit(Property $property, Request $request, CacheManager $cacheManager, UploaderHelper $helper) : Response
    {

        $form = $this->createForm(PropertyType::class, $property);
        // il va comparer et definir les champs
        $form->handleRequest($request);
        // on verifie que tout se soi bien passé
        if($form->isSubmitted() && $form->isValid()){
            if($property->getImageFile() instanceof UploadedFile){
                $cacheManager->remove($helper->asset($property, 'imageFile'));
            }
            // on sauvegarde les changements au niveau de la base de données
            $entityManager = $this->doctrine->getManager();
            $entityManager->flush();
            $this->addFlash('success', 'Bien modifié avec succès.');
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Property $property
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/delete/{id}', name: 'admin.property.delete')]
    public function delete(Property $property, Request $request) : Response{
        // on instancie l'entity manager afin de pouvouir faire des manipulations dans la BDD
        $entityManager = $this->doctrine->getManager();
        if($this->isCsrfTokenValid('delete'.$property->getId(), $request->get('_token'))){
            // on supprime le bien passé en parametre
            $entityManager->remove($property);
            // on sauvegarde au niveau de la base de donnees

            $entityManager->flush();
            $this->addFlash('success', 'Bien supprimé avec succès.');
        }
        // on redirige vers la page admin
        return $this->redirectToRoute('admin.property.index');
    }
}
