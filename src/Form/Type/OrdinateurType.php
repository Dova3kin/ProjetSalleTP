<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Ordinateur;
use App\Entity\Salle;
use App\Repository\SalleRepository;

class OrdinateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numero', TextType::class)
            ->add('ip', TextType::class)
            ->add(
                'salle',
                EntityType::class,
                array(
                    'class' => Salle::class,
                    'query_builder' => function (SalleRepository $repo) {
                        return $repo->createQueryBuilder('s')
                            ->where('s.numero < 10');
                    }
                )
            );
    }
    /* Pour autoriser la saisie d’un champs vide pour la salle, vous pouvez rajouter
'required' => false dans le tableau qui est en dernier argument du dernier add
ci-dessus */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ordinateur::class,
        ));
    }
}
