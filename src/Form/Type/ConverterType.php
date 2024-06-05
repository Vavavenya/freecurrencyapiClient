<?php

namespace App\Form\Type;

use App\Enum\CurrencyEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ConverterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amount', TextType::class, [
                'attr' => [
                    'pattern' => '\d*'
                ]
            ])
            ->add('fromCurrency', ChoiceType::class, [
                'choices' => CurrencyEnum::getEnumValues(),
            ])
            ->add('toCurrency', ChoiceType::class, [
                'choices' => CurrencyEnum::getEnumValues(),
            ])
            ->add('convert', SubmitType::class);
    }
}
