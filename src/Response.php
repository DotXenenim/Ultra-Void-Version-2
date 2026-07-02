<?php

namespace Framework;

class Response
{
    public int $responseCode = 200;

    public string $body;

    public ?string $header;

    /** @var string[] */
    public array $headers = [];

    public function __construct(string $body = "", int $responseCode = 200, ?string $header = null)
    {
        $this->body = $body;
        $this->responseCode = $responseCode;
        $this->header = $header;
    }

    /**
     * Send the response to the client.
     */
    public function echo(): void
    {
        foreach ($this->headers as $headerLine) {
            header($headerLine);
        }
        if ($this->header !== null) {
            header($this->header);
        }
        http_response_code($this->responseCode);
        echo $this->body;
    }
}
