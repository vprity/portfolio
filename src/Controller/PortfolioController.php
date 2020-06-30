<?php

namespace App\Controller;

use App\Entity\Portfolio;
use App\Form\PortfolioType;
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
    public function new(Request $request)
    {
        $portfolio = new Portfolio();

        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            $this->addFlash('success', 'Project added!');

            return $this->redirectToRoute('admin.portfolio');
        }

        return $this->render('admin/portfolio/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
