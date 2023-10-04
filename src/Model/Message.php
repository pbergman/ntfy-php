<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Model;

/**
 * @api https://docs.ntfy.sh/subscribe/api/#json-message-format
 */
class Message
{
    private string $id = '';
    private int $time = 0;
    private string $event = '';
    private string $topic = '';
    private ?string $message = null;
    private ?string $title = null;
    private ?array $tags = null;
    private ?int $priority = null;
    private ?string $clicked = null;
    private ?array $actions = null;
    private ?array $attachment = null;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getTime(): int
    {
        return $this->time;
    }

    public function setTime(int $time): self
    {
        $this->time = $time;
        return $this;
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function setEvent(string $event): self
    {
        $this->event = $event;
        return $this;
    }

    public function getTopic(): string
    {
        return $this->topic;
    }

    public function setTopic(string $topic): self
    {
        $this->topic = $topic;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(?array $tags): self
    {
        $this->tags = null;

        if (null !== $tags) {
            foreach ($tags as $tag) {
                $this->addTag($tag);
            }
        }

        return $this;
    }

    public function addTag(string $tag): self
    {
        $this->tags[] = $tag;
        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): self
    {
        $this->priority = $priority;
        return $this;
    }

    public function getClicked(): ?string
    {
        return $this->clicked;
    }

    public function setClicked(?string $clicked): self
    {
        $this->clicked = $clicked;
        return $this;
    }

    public function getActions(): ?array
    {
        return $this->actions;
    }

    public function setActions(?array $actions): self
    {
        $this->actions = null;
        if (null !== $actions) {
            foreach ($actions as $action) {
                $this->addAction($action);
            }
        }
        return $this;
    }

    public function addAction(AbstractActionButton $action): self
    {
        $this->actions[] = $action;
        return $this;
    }


    public function getAttachment(): ?array
    {
        return $this->attachment;
    }

    public function setAttachment(?array $attachment): self
    {
        $this->attachment = $attachment;
        return $this;
    }
}