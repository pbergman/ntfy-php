<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Model;

/**
 * @api https://docs.ntfy.sh/subscribe/api/#list-of-all-parameters
 */
class SubscribeParameters implements ParametersInterface
{
    private ?bool $poll = null;
    private ?string $since = null;
    private ?bool $scheduled = null;
    private ?string $id = null;
    private ?string $message = null;
    private ?string $title = null;
    private ?array $priority = null;
    private ?array $tags = null;

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

    public function getPriority(): ?array
    {
        return $this->priority;
    }

    public function setPriority(?array $priorities): self
    {
        $this->priority = null;

        if (null !== $priorities) {
            foreach ($priorities as $priority) {
                $this->addPriority($priority);
            }
        }

        return $this;
    }

    public function addPriority(int $priority): self
    {
        $this->priority[] = $priority;
        return $this;
    }

    public function getPoll(): ?bool
    {
        return $this->poll;
    }

    public function setPoll(?bool $poll): self
    {
        $this->poll = $poll;
        return $this;
    }

    public function getSince(): ?bool
    {
        return $this->since;
    }

    public function setSince(?string $since): self
    {
        $this->since = $since;
        return $this;
    }

    public function getScheduled(): ?bool
    {
        return $this->scheduled;
    }

    public function setScheduled(?bool $scheduled): self
    {
        $this->scheduled = $scheduled;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;
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
}