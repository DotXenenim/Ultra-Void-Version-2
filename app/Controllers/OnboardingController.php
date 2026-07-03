<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\Repositories\FormRepository;
use App\Repositories\FormStepRepository;
use App\Repositories\StepRepository;
use App\Repositories\UserRepository;
use Framework\Request;
use Framework\Response;
use Framework\ResponseFactory;

class OnboardingController
{
    private const QUESTIONS = [
        1 => 'date_of_birth',
        2 => 'eu_status',
        3 => 'program_type',
        4 => 'has_admission',
        5 => 'accommodation',
        6 => 'employment',
        7 => 'already_have',
    ];

    public function __construct(
        private ResponseFactory $responseFactory,
        private UserRepository $userRepository,
        private StepRepository $stepRepository,
        private FormRepository $formRepository,
        private FormStepRepository $formStepRepository
    ) {
    }

    public function show(Request $request): Response
    {
        $user = $request->getAttribute('user');
        if (!$user instanceof User) {
            return $this->responseFactory->redirect('/login');
        }

        if ($this->formRepository->findByUserId($user->id) !== null) {
            return $this->responseFactory->redirect('/checklist');
        }

        $step = max(1, min((int)($request->get('step') ?? 1), count(self::QUESTIONS)));

        return $this->responseFactory->view('onboarding/question.html.twig', [
            'user'       => $user,
            'step'       => $step,
            'totalSteps' => count(self::QUESTIONS),
            'question'   => self::QUESTIONS[$step],
        ]);
    }

    public function save(Request $request): Response
    {
        $user = $request->getAttribute('user');
        if (!$user instanceof User) {
            return $this->responseFactory->redirect('/login');
        }

        $currentStep = (int)($request->get('current_step') ?? 1);
        $question    = self::QUESTIONS[$currentStep] ?? '';

        switch ($question) {
            case 'date_of_birth':
                $dob = $request->get('date_of_birth');
                if ($dob && $dob !== '') {
                    $user->date_of_birth = $dob;
                    $this->userRepository->update($user);
                }
                break;

            case 'eu_status':
                $val = $request->get('is_eu');
                if ($val !== null) {
                    $user->is_eu = $val === 'eu';
                    $this->userRepository->update($user);
                }
                break;

            case 'program_type':
                $val = $request->get('program_type');
                if ($val !== null) {
                    $user->program_type = $val;
                    $this->userRepository->update($user);
                }
                break;

            case 'has_admission':
                $val = $request->get('has_admission');
                if ($val !== null) {
                    $user->has_admission = $val === 'yes';
                    $this->userRepository->update($user);
                }
                break;

            case 'accommodation':
                $hasAccommodation = $request->get('has_accommodation');
                $housingType      = $request->get('housing_type');
                $user->housing_type = $hasAccommodation === 'no' ? 'none' : ($housingType ?? null);
                $this->userRepository->update($user);
                break;

            case 'employment':
                $val = $request->get('is_working');
                if ($val !== null) {
                    $user->is_working = $val === 'yes';
                    $this->userRepository->update($user);
                }
                break;

            case 'already_have':
                $alreadyHave = $request->getMany('already_have') ?? [];
                $steps       = $this->stepRepository->stepsForUser($user, $alreadyHave);
                $form        = $this->formRepository->insert($user->id);
                $this->formStepRepository->insertMany($form->id, $steps);
                return $this->responseFactory->redirect('/checklist');
        }

        $nextStep = $currentStep + 1;
        if ($nextStep > count(self::QUESTIONS)) {
            return $this->responseFactory->redirect('/checklist');
        }

        return $this->responseFactory->redirect('/onboarding?step=' . $nextStep);
    }
}
