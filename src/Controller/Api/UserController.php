<?php

namespace App\Controller\Api;

use App\DTO\Request\User\UpdateUserDTO;
use App\DTO\Responce\UserResponseDTO;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[Route('/v1/api/users')]
final class UserController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService,
    ) {}
    
    
    #[Route('/{publicId}', methods: ['GET'])]
    public function show(string $publicId, Request $request): JsonResponse
    {
        $user = $this->userService->getUserByPublicId($publicId);
        $this->denyAccessUnlessGranted('USER_VIEW', $user);
        $response = UserResponseDTO::fromEntity($user);
        return $this->json(['success' => true, 'data' => $response], 200, [], ['groups' => ['get']]);
    }
    
    #[Route('/{publicId}', name: 'user_update', methods: ['PUT'])]
    public function update(string $publicId, #[MapRequestPayload] UpdateUserDTO $dto): JsonResponse
    {
        $user = $this->userService->getUserByPublicId($publicId);
        $this->denyAccessUnlessGranted('USER_MANAGE', $user);
        
        $updated = $this->userService->update($publicId, $dto);
        
        $response = UserResponseDTO::fromEntity($updated);
        return $this->json(['success' => true, 'data' => $response], 200, [], ['groups' => ['put']]);
    }
    
    
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{publicId}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(string $publicId): JsonResponse
    {
        $this->userService->delete($publicId);
        return $this->json(['success' => true, 'data' => null]);
    }
    
}