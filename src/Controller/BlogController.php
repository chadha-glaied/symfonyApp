<?php
namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     * @param ArticleRepository $repo
     * @return Response
     */
    public function index( ArticleRepository $repo)
    {
        $articles =$repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' =>$articles
        ]);

    }
    /*
    /**
     * @Route("/", name="home")
     /
    public function home():Response{
        return $this->render('blog/home.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
    */

    /**
     * @Route("/blog/{id}", name="blog_show")
     * @param $id
     * @return Response
     */
    public function show (Article $article){
        return $this->render('blog/show.html.twig', [
            'article' => $article,
        ]);
    }
}
