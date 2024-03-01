<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController

{
    
    #[Route('/product', name: 'app_product')]
    public function index(EntitymanagerInterface $em, Request $r, SluggerInterface $slugger): Response
    
    {
        $un_product = new Product();
        $form = $this->createForm(ProductType::class, $un_product);

        $form->handleRequest($r);

        if($form->isSubmitted() && $form->isValid()){
            // $em = $this->getDoctrine()->getManager();
            $slug = $slugger->slug($un_product->getTitle());
            $un_product->setSlug($slug);
            $em->persist($un_product);
            $em->flush();
        }

        $products = $em->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView()
            
        ]);
    }
    

    #[Route('/product/{slug}', name: 'app_product_show')]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }



    #[Route('/product/edit/{slug}', name: 'app_product_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function edit(Request $r, Product $product, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($r);
    
        if ($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($product);
            $em->flush();
    
            return $this->redirectToRoute('app_product');
        }
    
        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }



    #[Route('/product/delete/{slug}', name: 'app_product_delete', methods: ['POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function delete(Request $r, Product $product, EntityManagerInterface $em): Response
    {
        // $this ->getUser()->getRoles();
        // $product = $em->getRepository(Product::class)->find($id);
       if ($this->isCsrfTokenValid('delete'. $product->getId(), $r->request->get('_token'))) {
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('app_product');
    }





}
