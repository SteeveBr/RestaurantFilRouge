<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Request, Response};
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


#[Route('api/category', name: 'app_api_category_')]
class CategoryController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private CategoryRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator) 
    {
    }
    #[Route(methods: 'POST')]
    public function new(Request $request): JsonResponse
    {
        $category = $this->serializer->deserialize($request->getContent(), type: Category::class, format: 'json');
        $category->setCreatedAt(new DateTimeImmutable());

        $this->manager->persist($category);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($category, format: 'json');
        $location = $this->urlGenerator->generate(
            'app_api_category_show',
            ['id' => $category->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id, Request $request): JsonResponse
    {
        $category = $this->repository->findOneby(['id' => $id]);
        if ($category) {
            $responseData = $this->serializer->serialize($category, format: 'json');
            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(data: null, status: Response::HTTP_NOT_FOUND);
    }

    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id, Request $request): JsonResponse
    {
        $category = $this->repository->findOneby(['id' => $id]);
        if ($category) {
            $category = $this->serializer->deserialize(
                $request->getContent(),
                type: Category::class,
                format: 'json',
                context: [AbstractNormalizer::OBJECT_TO_POPULATE => $category]
            );

    
            $category->setUpdatedAt(new DateTimeImmutable());

            $this->manager->flush();
              
            return new JsonResponse(data: null, status: Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(data: null, status: Response::HTTP_NOT_FOUND);
    }

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $category = $this->repository->findOneby(['id' => $id]);

        if ($category) {
            $this->manager->remove($category);
            $this->manager->flush();

            return new JsonResponse(data: null, status: Response::HTTP_NO_CONTENT);
        }
        
        return new JsonResponse(data: null, status: Response::HTTP_NOT_FOUND);
    }
}
