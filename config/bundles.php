<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => true],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class => ['all' => true],
    Symfony\Bundle\MakerBundle\MakerBundle::class => ['dev' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Twig\Extra\TwigExtraBundle\TwigExtraBundle::class => ['all' => true],
    SymfonyCasts\Bundle\VerifyEmail\SymfonyCastsVerifyEmailBundle::class => ['all' => true],
    Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class => ['dev' => true, 'test' => true],
    SymfonyCasts\Bundle\ResetPassword\SymfonyCastsResetPasswordBundle::class => ['all' => true],
    Knp\Bundle\MenuBundle\KnpMenuBundle::class => ['all' => true],
    Sonata\AdminBundle\SonataAdminBundle::class => ['all' => true],
    Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle::class => ['all' => true],
    Sonata\BlockBundle\SonataBlockBundle::class => ['all' => true],
    Sonata\Doctrine\Bridge\Symfony\SonataDoctrineBundle::class => ['all' => true],
    Sonata\Form\Bridge\Symfony\SonataFormBundle::class => ['all' => true],
    Sonata\Twig\Bridge\Symfony\SonataTwigBundle::class => ['all' => true],
    Gregwar\CaptchaBundle\GregwarCaptchaBundle::class => ['all' => true],
    Symfony\WebpackEncoreBundle\WebpackEncoreBundle::class => ['all' => true],
];
