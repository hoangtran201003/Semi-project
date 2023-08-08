<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Pets;
use App\Entity\Product;
use App\Form\PetType;
use App\Form\ProductType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use function Symfony\Bundle\MakerBundle\Util\findAllNodes;
use function Symfony\Config\Monolog\persistent;

class PetsController extends AbstractController
{
    #[Route('/', name: 'app_pets')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $pet = $doctrine ->getRepository ('App\Entity\Pets')->findAll();
        return $this->render('pets/index.html.twig', [
            'pet'=> $pet
        ]);
    }

    #[Route('/pets/details/{id}', name:'app_PetsDetails')]
    public function detailAction(ManagerRegistry $doctrine, $id): Response
    {
        $pet = $doctrine ->getRepository ('App\Entity\Pets')->find($id);
        $category = $doctrine->getRepository(Category::class)->findAll();
        return $this->render('pets/details.html.twig', [
            'pet'=> $pet,
            'category' => $category
        ]);
    }

    #Route('/pets/delete/{id}', name: 'app_petsDelete')]
    public function deleteAction(ManagerRegistry $doctrine, $id): Response
    {
        $em = $doctrine -> getManager();
        $pet = $doctrine ->getRepository ('App\Entity\Pets')->find($id);
        $em ->remove($pet);
        $em -> flush();

        $this -> addFlash
        (
            'error',
        'Pets deleted'
        );
        return $this-> redirectToRoute('pets_list');

    }

    #[Route('/pets/create', name: 'app_petsCreate')]
    public function createAction(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger): Response
    {
        $pet = new Pets();
        $form = $this->createForm(PetType::class,$pet);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // uplpad file
            $productImage = $form->get('Image')->getData();
            if ($productImage) {
                $originalFilename = pathinfo($productImage->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $productImage->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $productImage->move(
                        $this->getParameter('productImages_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash(
                        'error',
                        'Cannot upload'
                    );// ... handle exception if something happens during file upload
                }
                $pet->setImage($newFilename);
            }else{
                $this->addFlash(
                    'error',
                    'Cannot upload'
                );// ... handle exception if something happens during file upload
            }
            $em = $doctrine->getManager();
            $em->persist($pet);
            $em->flush();

            $this->addFlash(
                'notice',
                'Product Added'
            );
            return $this->redirectToRoute('app_pets');
        }
        return $this-> renderForm ('pets/create.html.twig', ['form'=> $form]);
    }

    #[Route('/pets/edit/{id}', name: 'app_petsEdit')]
    public function editAction(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $pet = $entityManager->getRepository(Pets::class)->find($id);
        $form = $this->createForm(PetType::class, @$pet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // uplpad file
            $productImage = $form->get('Image')->getData();
            if ($productImage) {
                $originalFilename = pathinfo($productImage->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $productImage->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $productImage->move(
                        $this->getParameter('productImages_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash(
                        'error',
                        'Cannot upload'
                    );// ... handle exception if something happens during file upload
                }
                $pet->setImage($newFilename);
            }else{
                $this->addFlash(
                    'error',
                    'Cannot upload'
                );// ... handle exception if something happens during file upload
            }
            $em = $doctrine->getManager();
            $em->persist($pet);
            $em->flush();

            $this->addFlash(
                'notice',
                'Product Added'
            );
            return $this->redirectToRoute('app_pets');
        }
        return $this-> renderForm ('pets/edit.html.twig', ['form'=> $form]);
    }



}
