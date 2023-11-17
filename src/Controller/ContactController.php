<?php

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {}

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $contactRepository = $this->entityManager->getRepository(Contact::class);
        $contacts = $contactRepository->findAll();

        return $this->render('contact/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    #[Route('/contact/show/{id}', name: 'contact_show')]
    public function show(Request $request): void
    {

    }

    #[Route('/contact/create', name: 'contact_new')]
    public function create():void
    {
        
    }

    #[Route('/contact/edit/{id}', name: 'contact_edit')]
    public function edit(Request $request): void
    {

    }

    #[Route('/contact/delete/{id}', name: 'contact_delete')]
    public function delete(Request $request):void
    {

    }
}