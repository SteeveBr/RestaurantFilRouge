<?php

namespace App\Controller;

use App\Entity\Food;
use App\Repository\FoodRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Request, Response};
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('api/food', name: 'app_api_food_')]
class FoodController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private FoodRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator) 
    {
    }
    #[Route(methods: 'POST')]
    public function new(Request $request): JsonResponse
    {
        $food = $this->serializer->deserialize($request->getContent(), type: Food::class, format: 'json');
        $food->setCreatedAt(new DateTimeImmutable());

        $this->manager->persist($food);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($food, format: 'json');
        $location = $this->urlGenerator->generate(
            'app_api_food_show',
            ['id' => $food->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id, Request $request): JsonResponse
    {
        $food = $this->repository->findOneby(['id' => $id]);

        if ($food) {
            $responseData = $this->serializer->serialize($food, format: 'json');
            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(data: null, status: Response::HTTP_NOT_FOUND);
    }

    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id, Request $request): JsonResponse
    {
        $food = $this->repository->findOneby(['id' => $id]);

        if ($food) {
            $food = $this->serializer->deserialize(
                $request->getContent(),
                type: Food::class,
                format: 'json',
                context: [AbstractNormalizer::OBJECT_TO_POPULATE => $food]
            );

    
            $food->setUpdatedAt(new DateTimeImmutable());

            $this->manager->flush();
              
            return new JsonResponse(data: null, status: Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(data: null, status: Response::HTTP_NOT_FOUND);
    }

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $food = $this->repository->findOneby(['id' => $id]);

        if ($food) {
            $this->manager->remove($food);
            $this->manager->flush();

            return new JsonResponse(data: null, status: Response::HTTP_NO_CONTENT);
        }
        
        return new JsonResponse(data: null, status: Response::HTTP_NOT_FOUND);
    }
}
