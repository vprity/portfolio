<?php

namespace App\Controller;

use App\Entity\Portfolio;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin.")
 * @IsGranted("IS_AUTHENTICATED_ANONYMOUSLY")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/portfolio", name="portfolio")
     */
    public function portfolio()
    {
        $portfolio_items = $this->getDoctrine()->getRepository(Portfolio::class)->findBy([], [
            'id' => 'DESC',
        ]);

        return $this->render('admin/portfolio.html.twig', [
            'portfolio_items' => $portfolio_items
        ]);
    }
}
