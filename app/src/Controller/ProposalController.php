<?php

namespace App\Controller;

use App\Entity\Proposal;
use App\Repository\PrestationRepository;
use App\Repository\ProposalRepository;
use App\Utils\Utils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/proposal')]
class ProposalController extends AbstractController
{
    #[Route('/new', name: 'app_create_proposal')]
    public function create(
        Request $request,
        PrestationRepository $prestationRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
        $prestation_id = $request->request->get('id');
        $presation =  $prestationRepository->find($prestation_id);
        $proposal = new Proposal();
        $proposal->setPrestation($presation)
            ->setClient($presation->getOwnerId())
            ->setProvider($this->getUser())
            ->setStatus(Utils::PROPOSAL_STATUS['CREATED']);
        $entityManager->persist($proposal);
        $entityManager->flush();
        return $this->redirectToRoute('app_dashboard');
    }

    #[Route('/', name: 'app_proposal_index')]
    public function index(ProposalRepository $proposalRepository) {

        $proposals = $proposalRepository->findAllActiveProposal($this->getUser());
        return $this->render('proposal/index.html.twig', [
            'proposals' => $proposals
        ]);
    }

    #[Route('/handle', name: 'app_proposal_handle')]
    public function handleProposal(
     Request $request,
     ProposalRepository $proposalRepository,
     EntityManagerInterface $entityManager
    )
    {
        $id = $request->request->get('id');
        $action = $request->request->get('action');
        $propal = $proposalRepository->find($id);

        if ($action === 'accept') {
            $propal->setStatus(Utils::PROPOSAL_STATUS['ACCEPTED']);
            $prestation = $propal->getPrestation();
            $prestation->setProviderId($this->getUser());
            $prestation->setStatus(Utils::PRESTATION_STATUS['WAITING']);
        } elseif ($action === 'refuse') {
            $propal->setStatus(Utils::PROPOSAL_STATUS['REFUSED']);
        }

        $entityManager->persist($propal);
        $entityManager->persist($prestation);
        $entityManager->flush();

        return $this->redirectToRoute('app_dashboard');
    }
}
