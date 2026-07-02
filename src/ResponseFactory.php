<?php

namespace Framework;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ResponseFactory
{
    private \Twig\Environment $twig;

    public function __construct(bool $debugMode, string $viewsPath)
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../' . $viewsPath);
        $twig = new \Twig\Environment($loader, [
            'debug' => $debugMode
        ]);
        if ($debugMode) {
            $twig->addExtension(new \Twig\Extension\DebugExtension());
        }
        $this->twig = $twig;
    }

    /**
     * @param string $view
     * @param array<mixed> $context
     * @return Response
     */
    public function view(string $view, array $context = []): Response
    {
        $response = new Response();

        try {
            $response->responseCode = 200;
            $response->body = $this->twig->render($view, $context);
            return $response;
        } catch (\Exception $e) {
            $response->responseCode = 500;
            $response->body = $e->getMessage();
            return $response;
        }
    }

    public function notFound(): Response
    {
        $response = new Response();
        try {
            $response->responseCode = 404;
            $response->body = $this->twig->render('404.html.twig');
            return $response;
        } catch (\Exception $e) {
            $response->responseCode = 500;
            $response->body = $e->getMessage();
            return $response;
        }
    }

    public function internalError(): Response
    {
        $response = new Response();
        try {
            $response->responseCode = 500;
            $response->body = $this->twig->render('500.html.twig');
            return $response;
        } catch (\Exception $e) {
            $response->responseCode = 500;
            $response->body = $e->getMessage();
            return $response;
        }
    }

    public function forbidden(): Response
    {
        $response = new Response();
        try {
            $response->responseCode = 403;
            $response->body = $this->twig->render('403.html.twig');
            return $response;
        } catch (\Exception $e) {
            $response->responseCode = 500;
            $response->body = $e->getMessage();
            return $response;
        }
    }
    public function unAuthorized(): Response
    {
        $response = new Response();
        try {
            $response->responseCode = 401;
            $response->body = $this->twig->render('401.html.twig');
            return $response;
        } catch (\Exception $e) {
            $response->responseCode = 500;
            $response->body = $e->getMessage();
            return $response;
        }
    }

    /**
     * Takes a twig template, context for the twig template and returns an HTML string
     * @param string $view file
     * @param mixed[] $context context for variables in twig
     * @return string HTML string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $view, array $context): string
    {
        return $this->twig->render($view, $context);
    }

    public function redirect(string $url): Response
    {
        $response = new Response();
        $response->responseCode = 302;
        $response->header = "Location: " . $url;
        return $response;
    }
    public function json(mixed $data, int $statusCode = 200): Response
    {
        $response = new Response();
        $response->responseCode = $statusCode;
        $response->body = json_encode($data) ? json_encode($data) : '';
        $response->header = "Content-Type: application/json";
        return $response;
    }
}
