<?php

namespace App\Service\Product;

use App\Entity\Product;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class ProductImageUpdater
{

    public function __construct(
        private readonly FileUploader $fileUploader
    )
    {
    }

    public function handle(Product $product, ?UploadedFile $file): void
    {
        if ($file) {
            $newFilename = $this->fileUploader->upload($file);
            $product->setBrochureFilename($newFilename);
        }
    }
}