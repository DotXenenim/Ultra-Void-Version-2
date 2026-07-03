<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\Repositories\FormRepository;
use App\Repositories\FormStepRepository;
use Framework\Request;
use Framework\Response;
use Framework\ResponseFactory;

class ChecklistController
{
    public function __construct(
        private ResponseFactory $responseFactory,
        private FormRepository $formRepository,
        private FormStepRepository $formStepRepository
    ) {
    }

    public function index(Request $request): Response
    {
        $user = $request->getAttribute('user');
        if (!$user instanceof User) {
            return $this->responseFactory->redirect('/login');
        }

        $form = $this->formRepository->findByUserId($user->id);
        if ($form === null) {
            return $this->responseFactory->redirect('/onboarding');
        }

        $steps   = $this->formStepRepository->findByFormId($form->id);
        $total   = count($steps);
        $done    = count(array_filter($steps, fn($s) => $s->completed));
        $percent = $total > 0 ? (int)(($done / $total) * 100) : 0;

        $activeIndex = 0;
        foreach ($steps as $i => $step) {
            if (!$step->completed) {
                $activeIndex = $i;
                break;
            }
            $activeIndex = $i;
        }

        return $this->responseFactory->view('checklist/index.html.twig', [
            'user'        => $user,
            'steps'       => $steps,
            'total'       => $total,
            'done'        => $done,
            'percent'     => $percent,
            'activeIndex' => $activeIndex,
        ]);
    }

    public function toggle(Request $request): Response
    {
        $user = $request->getAttribute('user');
        if (!$user instanceof User) {
            return $this->responseFactory->json(['error' => 'Not authenticated'], 401);
        }

        $formStepId = (int)($request->get('form_step_id') ?? 0);
        $completed  = $request->get('completed') === '1';

        $this->formStepRepository->toggle($formStepId, $completed);

        $form  = $this->formRepository->findByUserId($user->id);
        $steps = $form ? $this->formStepRepository->findByFormId($form->id) : [];
        $total = count($steps);
        $done  = count(array_filter($steps, fn($s) => $s->completed));

        return $this->responseFactory->json([
            'success' => true,
            'done'    => $done,
            'total'   => $total,
            'percent' => $total > 0 ? (int)(($done / $total) * 100) : 0,
        ]);
    }
}
