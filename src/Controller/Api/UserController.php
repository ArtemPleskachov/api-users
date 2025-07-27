<?php

namespace App\Controller\Api;

use App\DTO\Request\UserRequestDTO;
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
        private readonly RequestValidatorService $validator
    ) {}
    
    #[Route('', name: 'user_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $dto = UserRequestDTO::fromJson($request->getContent());
        $this->validator->validate($dto);
        
        $user = $this->userService->create($dto);
        return $this->json(
            $user,
            JsonResponse::HTTP_CREATED
        );
    }
    
    #[Route('', name: 'user_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        return $this->json($this->userService->getAllUsers());
    }
    
    #[Route('/{publicId}', name: 'user_update', methods: ['PUT'])]
    public function update(string $publicId, Request $request): JsonResponse
    {
        $dto = UserRequestDTO::fromJson($request->getContent());
        $this->validator->validate($dto);
        
        return $this->json(
            $this->userService->updateUser($publicId, $dto)
        );
    }
    
    #[Route('/{publicId}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(string $publicId): JsonResponse
    {
        $this->userService->deleteUser($publicId);
        
        return $this->json(['status' => 'User deleted']);
    }
}
