<?php

namespace App\Form;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;

readonly class FileTransformer implements DataTransformerInterface
{
    public function __construct(
        #[Autowire('%kernel.project_dir%/assets/images/')]
        private string $filePath
    )
    {
    }

    public function transform(mixed $fileName): File|string
    {
        if(null === $fileName) {
            return '';
        }

        return new File($this->filePath.$fileName);
    }

    public function reverseTransform(mixed $value)
    {
        return $value;
    }
}