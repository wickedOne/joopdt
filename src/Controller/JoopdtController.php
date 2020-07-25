<?php

declare(strict_types=1);

/*
 * This file is part of joopdt.nl.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\Story;
use App\Form\Type\StoryType;
use App\Service\UploadService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Joopdt Controller.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class JoopdtController extends AbstractController
{
    /**
     * @Route(path="/", name="app_index")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route(path="/story", name="app_story")
     *
     * @param \Symfony\Component\HttpFoundation\Request          $request
     * @param \App\Service\UploadService                         $uploadService
     * @param \Doctrine\ORM\EntityManagerInterface               $em
     * @param \Symfony\Contracts\Translation\TranslatorInterface $translator
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Symfony\Component\Form\Exception\OutOfBoundsException
     * @throws \Symfony\Component\Form\Exception\RuntimeException
     * @throws \Symfony\Component\HttpFoundation\File\Exception\UploadException
     */
    public function story(Request $request, UploadService $uploadService, EntityManagerInterface $em, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(StoryType::class, new Story(), []);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Story $story */
            $story = $form->getData();

            foreach ($form->get('attachments')->getData() as $attachment) {
                $file = $uploadService->upload($attachment);
                $story->addFile($file);
            }

            $em->persist($story);
            $em->flush();

            $this->addFlash('info', $translator->trans('story.submit.success'));
            $this->redirect($this->generateUrl('app_index'));
        }

        return $this->render('story.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
