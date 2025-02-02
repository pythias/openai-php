<?php

declare(strict_types=1);

namespace OpenAI\Responses\Audio;

use OpenAI\Contracts\Response;
use OpenAI\Responses\Concerns\ArrayAccessible;

/**
 * @implements Response<array{task: ?string, language: ?string, duration: ?float, segments: array<int, array{id: int, seek: int, start: float, end: float, text: string, tokens: array<int, int>, temperature: float, avg_logprob: float, compression_ratio: float, no_speech_prob: float, transient: bool}>, text: string}>
 */
final class TranscriptionResponse implements Response {
    public ?string $task;
    public ?string $language;
    public ?float $duration;

    /**
     * @var array<int, TranscriptionResponseSegment>
     */
    public array $segments;
    public string $text;

    /**
     * @use ArrayAccessible<array{task: ?string, language: ?string, duration: ?float, segments: array<int, array{id: int, seek: int, start: float, end: float, text: string, tokens: array<int, int>, temperature: float, avg_logprob: float, compression_ratio: float, no_speech_prob: float, transient: bool}>, text: string}>
     */
    use ArrayAccessible;

    /**
     * @param array<int, TranscriptionResponseSegment> $segments
     */
    private function __construct(
        ?string $task,
        ?string $language,
        ?float $duration,
        array $segments,
        string $text
    ) {
        $this->task = $task;
        $this->language = $language;
        $this->duration = $duration;
        $this->segments = $segments;
        $this->text = $text;
    }

    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param array{task: ?string, language: ?string, duration: ?float, segments: array<int, array{id: int, seek: int, start: float, end: float, text: string, tokens: array<int, int>, temperature: float, avg_logprob: float, compression_ratio: float, no_speech_prob: float, transient: bool}>, text: string}|string $attributes
     */
    public static function from($attributes): self {
        if (is_string($attributes)) {
            $attributes = ['text' => $attributes];
        }

        $segments = isset($attributes['segments']) ? array_map(fn (array $result): TranscriptionResponseSegment => TranscriptionResponseSegment::from(
            $result
        ), $attributes['segments']) : [];

        return new self(
            $attributes['task'] ?? null,
            $attributes['language'] ?? null,
            $attributes['duration'] ?? null,
            $segments,
            $attributes['text'],
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array {
        return [
            'task' => $this->task,
            'language' => $this->language,
            'duration' => $this->duration,
            'segments' => array_map(
                static fn (TranscriptionResponseSegment $result): array => $result->toArray(),
                $this->segments,
            ),
            'text' => $this->text,
        ];
    }
}
