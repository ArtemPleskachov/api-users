<?php

namespace App\Controller\Api;

use App\DTO\Request\UserRequestDTO;
use App\DTO\Responce\UserResponseDTO;
use App\Service\RequestValidatorService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/v1/api/users')]
final class UserController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService,
        private readonly RequestValidatorService $validator,
    ) {}
    
    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $dto = UserRequestDTO::fromJson($request->getContent());
        $this->validator->validate($dto);
        
        $user = $this->userService->create($dto);
        $response = UserResponseDTO::fromEntity($user);
        
        return $this->json(
            ['success' => true, 'data' => $response],
            JsonResponse::HTTP_CREATED,
            [],
            ['groups' => ['post']]
        );
    }
    
    #[Route('/{publicId}', methods: ['GET'])]
    public function show(string $publicId): JsonResponse
    {
        $user = $this->userService->getUserByPublicId($publicId);
        
        $response = UserResponseDTO::fromEntity($user);
        
        return $this->json(
            ['success' => true, 'data' => $response],
            JsonResponse::HTTP_OK,
            [],
            ['groups' => ['get']]
        );
    }
    
    #[Route('/{publicId}', name: 'user_update', methods: ['PUT'])]
    public function update(string $publicId, Request $request): JsonResponse
    {
        $dto = UserRequestDTO::fromJson($request->getContent());
        $this->validator->validate($dto);
        
        $user = $this->userService->updateUser($publicId, $dto);
        $response = UserResponseDTO::fromEntity($user);
        
        return $this->json(
            ['success' => true, 'data' => $response],
            JsonResponse::HTTP_OK,
            [],
            ['groups' => ['put']]
        );
    }
    
    #[Route('/{publicId}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(string $publicId): JsonResponse
    {
        $this->userService->deleteUser($publicId);
        
        return $this->json(['success' => true, 'data' => null]);
    }
}