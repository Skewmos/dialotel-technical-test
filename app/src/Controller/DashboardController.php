<?php

namespace App\Controller;

use AllowDynamicProperties;
use App\Repository\PrestationRepository;
use App\Utils\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[AllowDynamicProperties]
class DashboardController extends AbstractController
{
    public function __construct(PrestationRepository $prestationRepository)
    {
        $this->prestationRepository = $prestationRepository;
    }
    #[Route('/', name: 'app_dashboard')]
    public function index(): Response
    {
        $prestations  = $this->prestationRepository->findBy(['owner'=> $this->getUser()]);
        $numberOfPrestations = sizeof($prestations);
        $the_latest_services_posted_online =$this->prestationRepository->findBy(['status' => Utils::PRESTATION_STATUS['WAITING']]);

        return $this->render('dashboard/index.html.twig', [
            $numberOfPrestations,
            'the_latest_services_posted_online' => $the_latest_services_posted_online
        ]);
    }
}
