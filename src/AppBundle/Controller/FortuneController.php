<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Category;
use AppBundle\Entity\FortuneCookie;

class FortuneController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction(Request $request)
    {
        $categoryRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Category');

        $search = $request->query->get('q');
        if ($search) {
            $categories = $categoryRepository->search($search);
        } else {
            $categories = $categoryRepository->findAllOrdered();
        }


        return $this->render('fortune/homepage.html.twig',[
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/category/{id}", name="category_show")
     */
    public function showCategoryAction($id)
    {
        $categoryRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Category');

        $category = $categoryRepository->findWithFortunesJoin($id);

        if (!$category) {
            throw $this->createNotFoundException();
        }


        $fortunesPrinted = $this->getDoctrine()
        ->getRepository("AppBundle\Entity\Fortunecookie")
        ->countNumberPrintedForCategory($category);
        var_dump($fortunesPrinted);

        return $this->render('fortune/showCategory.html.twig',[
            'category' => $category,
            'fortunePrintted' => $fortunesPrinted
        ]);
    }
}
