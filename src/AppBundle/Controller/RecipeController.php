<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Recipe;
use AppBundle\Form\RecipeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * Recipe controller.
 *
 *
 */
class RecipeController extends Controller
{

   
    /**
     * Lists all Recipe entities.
     *
     * @Route("/", name="recipe_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $recipes = $em->getRepository('AppBundle:Recipe')->findBy(

        ['isDraft'=>false],
        ['id'=>'DESC']
        );

        return $this->render('recipe/index.html.twig', array(
            'recipes' => $recipes,
        ));
    }

    /**
     * Lists all Recipe entities.
     *
     * @Route ("/drafts", name="draft")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function draftAction()
     {
         $em = $this->getDoctrine()->getManager();

         $recipes = $em->getRepository('AppBundle:Recipe')->findBy(

             ['isDraft'=>true],
             ['id'=>'DESC']
         );

         return $this->render('recipe/index.html.twig', array(
             'recipes' => $recipes,
         ));
     }
    
    /**
     * Creates a new Recipe entity.
     *
     * @Route("/new", name="recipe_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $recipe = new Recipe();

        $user = $this->getUser();
        $recipe->setOwner($user);
        $recipe->setName('Новый рецепт');

        $em = $this->getDoctrine()->getManager();
        $em->persist($recipe);
        $em->flush();

        $form = $this->createForm('AppBundle\Form\RecipeType', $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);
            $em->flush();

            return $this->redirectToRoute('recipe_show', array('id' => $recipe->getId()));
        }

        return $this->render('recipe/new.html.twig', array(
            'recipe' => $recipe,
            'form' => $form->createView(),
        ));

    }


    
    /**
     * Finds and displays a Recipe entity.
     *
     * @Route("/recipe/{id}", name="recipe_show")
     * @Method("GET")
     */
    public function showAction(Recipe $recipe)
    {
        $deleteForm = $this->createDeleteForm($recipe);

        return $this->render('recipe/show.html.twig', array(
            'recipe' => $recipe,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Recipe entity.
     *
     * @Route("/{id}/edit", name="recipe_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, Recipe $recipe)
    {
        $deleteForm = $this->createDeleteForm($recipe);
        $editForm = $this->createForm('AppBundle\Form\RecipeType', $recipe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);
            $em->flush();

            return $this->redirectToRoute('recipe_edit', array('id' => $recipe->getId()));
        }

        return $this->render('recipe/edit.html.twig', array(
            'recipe' => $recipe,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Recipe entity.
     *
     * @Route("/{id}", name="recipe_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Recipe $recipe)
    {
        $form = $this->createDeleteForm($recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($recipe);
            $em->flush();
        }

        return $this->redirectToRoute('recipe_index');
    }

    /**
     * Creates a form to delete a Recipe entity.
     *
     * @param Recipe $recipe The Recipe entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Recipe $recipe)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('recipe_delete', array('id' => $recipe->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


}

