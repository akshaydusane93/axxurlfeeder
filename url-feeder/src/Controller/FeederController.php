<?php
namespace App\Controller;

use App\Entity\Url;
use App\Repository\UrlRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class FeederController extends ApiController
{
    /**
    * @Route("/urls", methods="GET")
    */
    public function index(UrlRepository $urlRepository){
        $urls = $urlRepository->transformAll();

        return $this->respond($urls);
    }


    /**
    * @Route("/urls", methods="POST")
    */
    public function create(Request $request, UrlRepository $urlRepository, EntityManagerInterface $em)
    {
        

        $request = $this->transformJsonBody($request);
        // print_r($request);exit;

        /*if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        // validate the title
        if (! $request->get('title')) {
            return $this->respondValidationError('Please provide a title!');
        }*/

        // persist the new movie
        $url = new Url;
        $url->setUrltext($request->get('urltext'));
        $url->setDeleted(0);
        $em->persist($url);
        $em->flush();

        return $this->respondCreated($urlRepository->transform($url));
    }
}