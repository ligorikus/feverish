<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Mediators\UserMediator;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegistrationController extends Controller
{
    /**
     * @var UserMediator
     */
    private UserMediator $userMediator;

    /**
     * @param UserMediator $userMediator
     */
    public function __construct(UserMediator $userMediator)
    {
        $this->userMediator = $userMediator;
    }

    /**
     * @param RegistrationRequest $request
     * @return JsonResponse
     */
    public function register(RegistrationRequest $request): JsonResponse
    {
        $user = $this->userMediator->service->create(User::class, $request->all());
        return $this->respondWithSuccess($this->userMediator->fractalManager->item(
            $user, $this->userMediator->transformer
        ));
    }
}
