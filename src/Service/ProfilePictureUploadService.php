<?php

namespace App\Service;

use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;



class ProfilePictureUploadService
{
    protected $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;

    }

    public function uploadProfilePicture($avatar)
    {
        if ($avatar) {
            $newFileName = uniqid() . '.' . $avatar->guessExtension();
            try {
                $avatar->move(
                    $this->parameterBag->get('kernel.project_dir') . '/public/uploads',
                    $newFileName
                );
            } catch (FileException $e) {
                return new Response($e->getMessage());
            }

        return $newFileName;
        }     
    }
}
