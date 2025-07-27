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
        $this->checkToken($request);
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
    public function show(string $publicId, Request $request): JsonResponse
    {
        $this->checkToken($request, $publicId);
    
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
        $this->checkToken($request, $publicId);
    
        $dto = UserRequestDTO::fromJson($request->getContent());
        $this->validator->validate($dto);
        
        $user = $this->userService->update($publicId, $dto);
        $response = UserResponseDTO::fromEntity($user);
        
        return $this->json(
            ['success' => true, 'data' => $response],
            JsonResponse::HTTP_OK,
            [],
            ['groups' => ['put']]
        );
    }
    
    #[Route('/{publicId}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(Request $request, string $publicId): JsonResponse
    {
        $this->checkToken($request, $publicId);
        $this->userService->delete($publicId);
        
        return $this->json(['success' => true, 'data' => null]);
    }
    
    private function checkToken(Request $request, ?string $publicId = null): string
    {
        $authHeader = $request->headers->get('Authorization');
        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            throw $this->createAccessDeniedException('Missing or malformed Authorization header.');
        }
        
        $token = substr($authHeader, 7);

        $adminToken = $_ENV['SECRET_ADMIN_TOKEN'] ?? null;
        $userToken = $_ENV['SECRET_USER_TOKEN'] ?? null;
        $userPublicId = $_ENV['SECRET_USER_PUBLIC_ID'] ?? null;
    
        if ($token === $adminToken) {
            return 'admin';
        }
    
    
        if ($token === $userToken) {
    
            if ($publicId === null) {
                throw $this->createAccessDeniedException('POST not allowed for user role.');
            }
            
            if ($publicId !== $userPublicId) {
                throw $this->createAccessDeniedException('Access denied to other user\'s data.');
            }
    
            if ($request->getMethod() === 'DELETE') {
                throw $this->createAccessDeniedException('User is not allowed to delete even their own account.');
            }
            return 'user';
        }
    
        // Всі інші — відмовити
        throw $this->createAccessDeniedException('Invalid token.');
    }
}