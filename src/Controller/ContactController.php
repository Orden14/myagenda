<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        $contacts = $contactRepository->findBy(
            [],
            ['nom' => 'ASC']
        );

        return $this->render('contact/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    #[Route('/contact/show/{id}', name: 'contact_show')]
    public function show(Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
    }

    #[Route('/contact/create', name: 'contact_new')]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request): Response
    {

        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $contact = new Contact();
        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($contact);
            $this->entityManager->flush();

            $this->addFlash(
                'succes',
                'Le contact ' . $contact->getPrenom() . ' ' . $contact->getNom() . ' a bien été créé'
            );

            return $this->redirectToRoute('app_index');
        }

        return $this->render('contact/manage.html.twig', [
            'contactForm' => $form->createView(),
            'action' => 'Créer'
        ]);
    }

    #[Route('/contact/edit/{id}', name: 'contact_edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $contact = $this->entityManager
            ->getRepository(contact::class)
            ->find((int) $request->get('id'))
        ;

        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash(
                'warning',
                'Le contact ' . $contact->getPrenom() . ' ' . $contact->getNom() . ' a bien été modifié'
            );
            
            return $this->redirectToRoute('app_index');
        }

        return $this->render('contact/manage.html.twig', [
            'contactForm' => $form->createView(),
            'action' => 'Modifier',
        ]);
    }

    #[Route('/contact/delete/{id}', name: 'contact_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $contact = $this->entityManager
            ->getRepository(Contact::class)
            ->find((int) $request->get('id'))
        ;

        $this->entityManager->remove($contact);
        $this->entityManager->flush();

        $this->addFlash(
            'warning',
            'Le contact ' . $contact->getPrenom() . ' ' . $contact->getNom() . ' a bien été modifié'
        );

        return $this->redirectToRoute('app_index');
    }
}