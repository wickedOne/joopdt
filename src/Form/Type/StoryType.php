<?php

declare(strict_types=1);

/*
 * This file is part of joopdt.nl.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form\Type;

use App\Entity\Story;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\EqualTo;

/**
 * Story Type.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class StoryType extends AbstractType
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'required' => true,
                'label' => 'form.story.email.label',
                'help' => 'form.story.email.help',
            ])
            ->add('name', TextType::class, [
                'label' => 'form.story.name.label',
                'required' => false,
                'attr' => [
                    'placeholder' => 'form.story.name.placeholder',
                ],
            ])
            ->add('title', TextType::class, [
                'label' => 'form.story.title.label',
                'required' => false,
            ])
            ->add('text', TextareaType::class, [
                'label' => 'form.story.text.label',
            ])
            ->add('attachments', FileType::class, [
                'multiple' => true,
                'required' => false,
                'mapped' => false,
                'label' => 'form.story.attachments.label',
            ])
            ->add('notify', CheckboxType::class, [
                'label' => 'form.story.notify.label',
                'required' => false,
            ])
            ->add('surname', TextType::class, [
                'label' => 'form.story.surname.label',
                'mapped' => false,
                'constraints' => [
                    new EqualTo(['value' => 'wesdijk', 'message' => 'form.story.surname.invalid']),
                ],
            ])
        ;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Story::class,
        ]);
    }
}
