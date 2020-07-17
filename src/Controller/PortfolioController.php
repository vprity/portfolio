<?php

namespace App\Controller;

use App\Entity\Option;
use App\Entity\Portfolio;
use App\Form\PortfolioType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/portfolio", name="admin.portfolio_")
 * @IsGranted("IS_AUTHENTICATED_ANONYMOUSLY")
 */
class PortfolioController extends AbstractController
{
    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request, FileUploader $file_uploader)
    {
        $portfolio = new Portfolio();

        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $option = new Option();

            $file = $form->get('cover')->getData();

            if ($file) {
                $new_filename = $file_uploader->upload($file);

                $portfolio->setCover($new_filename);
            }

            $portfolio->setOption($option);

            $em = $this->getDoctrine()->getManager();
            $em->persist($portfolio);
            $em->persist($option);
            $em->flush();

            $this->addFlash('success', 'Project added');

            return $this->redirectToRoute('admin.portfolio');
        }

        return $this->render('admin/portfolio/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request, Portfolio $portfolio, FileUploader $file_uploader)
    {
        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('cover')->getData();

            if ($file) {
                $file_uploader->remove($portfolio->getCover());

                $new_filename = $file_uploader->upload($file);

                $portfolio->setCover($new_filename);
            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Project edit');

            return $this->redirectToRoute('admin.portfolio');
        }

        return $this->render('admin/portfolio/edit.html.twig', [
            'form' => $form->createView(),
            'portfolio' => $portfolio
        ]);
    }

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function delete(Request $request, Portfolio $portfolio, FileUploader $file_uploader)
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            $this->addFlash('error', 'CSRF Token Invalid');

            return $this->redirectToRoute('admin.portfolio');
        }

        $portfolio_entity = new Portfolio();

        if ($portfolio->getCover() !== $portfolio_entity->getCover()) {
            $file_uploader->remove($portfolio->getCover());
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($portfolio);
        $em->flush();

        $this->addFlash('success', 'Project remove');

        return $this->redirectToRoute('admin.portfolio');
    }

    /**
     * @Route("/hidden/{id}", name="hidden")
     */
    public function hidden(Request $request, Portfolio $portfolio)
    {
        if (!$this->isCsrfTokenValid('hidden', $request->request->get('token'))) {
            $this->addFlash('error', 'CSRF Token Invalid');

            return $this->redirectToRoute('admin.portfolio');
        }

        if ($portfolio->getOption()->getIsHidden()) {
            $is_hidden = false;
            $flash_message = 'unlock';
        } else {
            $is_hidden = true;
            $flash_message = 'hidden';
        }

        $portfolio->getOption()->setIsHidden($is_hidden);

        $em = $this->getDoctrine()->getManager();
        $em->persist($portfolio);
        $em->flush();

        $this->addFlash('notice', 'Project ' . $portfolio->getName() . ' ' . $flash_message);

        return $this->redirectToRoute('admin.portfolio');
    }
}
