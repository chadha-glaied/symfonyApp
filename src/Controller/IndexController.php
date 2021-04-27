<?php
namespace App\Controller;
use App\Entity\Article;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class IndexController extends AbstractController
{
    /**
     * @Route("/actions",name="article_list")
     */
    public function home()
    {
        //récupérer tous les articles de la table article de la BD //et les mettre dans le tableau $articles
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        return $this->render('articles/index.html.twig', ['articles' => $articles]);
    }

    /**
     * @Route("/article/save")
     */
    public function save()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = new Article();
        $article->setTitle('Article3');
        $article->setContent("I'am article 3 !");
        $article->setImage("https://www.google.com/url?sa=i&url=https%3A%2F%2Fdeveloper.mozilla.org%2Ffr%2Fdocs%2FWeb%2FHTML%2FElement%2FImg&psig=AOvVaw3v7n1tSszSBmc4Il1jPkeU&ust=1615302830465000&source=images&cd=vfe&ved=0CAIQjRxqFwoTCKjD8I3-oO8CFQAAAAAdAAAAABAD");
        $article->setCreatedAt(new DateTime());
        $entityManager->persist($article);
        $entityManager->flush();
        return new Response('Article enregisté avec id' . $article->getId());
    }

    /**
     * @Route("/article/new", name="new_article")
     * Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $article = new Article();

        $form = $this->createFormBuilder($article)
            ->add('Title', TextType::class)
            ->add('Content', TextType::class)
            ->add('Image', TextType::class)
            ->add('CreatedAt', DateType::class)

            ->add('save', SubmitType::class, array(
                'label' => 'Créer'))
            ->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_list');
        }
        return $this->render('articles/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function show($id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)
            ->find($id);
        return $this->render('articles/show.html.twig',
            array('article' => $article));
    }

    /**
     * @Route("/article/edit/{id}", name="edit_article")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id)
    {
        $article = new Article();
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $form = $this->createFormBuilder($article)
            ->add('Title', TextType::class)
            ->add('Content', TextType::class)
            ->add('Image', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Modifier'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('article_list');
        }

        return $this->render('articles/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/article/delete/{id}",name="delete_article")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        $response = new Response();
        $response->send();
        return $this->redirectToRoute('article_list');


    }
}