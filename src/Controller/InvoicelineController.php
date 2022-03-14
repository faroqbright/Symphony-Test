<?php

namespace App\Controller;

use App\Entity\InvoiceLine;
use App\Form\InvoiceLineType;
use App\Repository\InvoiceLineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/invoiceline')]
class InvoicelineController extends AbstractController
{
    #[Route('/', name: 'app_invoiceline_index', methods: ['GET'])]
    public function index(InvoiceLineRepository $invoiceLineRepository): Response
    {
        return $this->render('invoiceline/index.html.twig', [
            'invoice_lines' => $invoiceLineRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_invoiceline_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InvoiceLineRepository $invoiceLineRepository): Response
    {
        $invoiceLine = new InvoiceLine();
        $form = $this->createForm(InvoiceLineType::class, $invoiceLine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoiceLineRepository->add($invoiceLine);
            return $this->redirectToRoute('app_invoiceline_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('invoiceline/new.html.twig', [
            'invoice_line' => $invoiceLine,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_invoiceline_show', methods: ['GET'])]
    public function show(InvoiceLine $invoiceLine): Response
    {
        return $this->render('invoiceline/show.html.twig', [
            'invoice_line' => $invoiceLine,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_invoiceline_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, InvoiceLine $invoiceLine, InvoiceLineRepository $invoiceLineRepository): Response
    {
        $form = $this->createForm(InvoiceLineType::class, $invoiceLine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoiceLineRepository->add($invoiceLine);
            return $this->redirectToRoute('app_invoiceline_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('invoiceline/edit.html.twig', [
            'invoice_line' => $invoiceLine,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_invoiceline_delete', methods: ['POST'])]
    public function delete(Request $request, InvoiceLine $invoiceLine, InvoiceLineRepository $invoiceLineRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$invoiceLine->getId(), $request->request->get('_token'))) {
            $invoiceLineRepository->remove($invoiceLine);
        }

        return $this->redirectToRoute('app_invoiceline_index', [], Response::HTTP_SEE_OTHER);
    }
}
