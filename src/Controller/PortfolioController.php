<?php

namespace App\Controller;

use App\Entity\Portfolio;
use App\Form\PortfolioType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
            $file = $form->get('cover')->getData();

            if ($file) {
                $new_filename = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move($this->getParameter('file_portfolio_img'), $new_filename);

                $portfolio->setCover($new_filename);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($portfolio);
            $em->flush();

            $this->addFlash('success', 'Project added!');

            return $this->redirectToRoute('admin.portfolio');
        }

        return $this->render('admin/portfolio/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit($id)
    {
        $portfolio = $this->getDoctrine()->getRepository(Portfolio::class)->find($id);

        if (!$portfolio) {
            $this->addFlash('error', 'Project not found!');

            return $this->redirectToRoute('admin.portfolio');
        }

        return $this->render('admin/portfolio/edit.html.twig', [
            'portfolio' => $portfolio
        ]);
    }
}
