<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Model;

/**
 * @api https://docs.ntfy.sh/publish/#list-of-all-parameters
 */
class PublishParameters implements ParametersInterface
{
    private ?string $message;
    private ?string $title = null;
    private ?array $tags = null;
    private ?int $priority = null;
    private ?array $actions = null;
    private ?string $click = null;
    private ?string $attach = null;
    private ?bool $markdown = null;
    private ?string $icon = null;
    private ?string $filename = null;
    private ?string $delay = null;
    private ?string $email = null;
    private ?string $call = null;
    private ?bool $cache = null;
    private ?bool $firebase = null;
    private ?bool $unifiedPush = null;
    private ?string $pollId = null;

    public function __construct(?string $message = null, ?string $title = null)
    {
        $this->message = $message;
        $this->title = $title;
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

    public function getClick(): ?string
    {
        return $this->click;
    }

    public function setClick(?string $click): self
    {
        $this->click = $click;
        return $this;
    }

    public function getAttach(): ?string
    {
        return $this->attach;
    }

    public function setAttach(?string $attach): self
    {
        $this->attach = $attach;
        return $this;
    }

    public function getMarkdown(): ?bool
    {
        return $this->markdown;
    }

    public function setMarkdown(?bool $markdown): self
    {
        $this->markdown = $markdown;
        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;
        return $this;
    }

    public function getDelay(): ?string
    {
        return $this->delay;
    }

    public function setDelay(?string $delay): self
    {
        $this->delay = $delay;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getCall(): ?string
    {
        return $this->call;
    }

    public function setCall(?string $call): self
    {
        $this->call = $call;
        return $this;
    }

    public function getCache(): ?bool
    {
        return $this->cache;
    }

    public function setCache(?bool $cache): self
    {
        $this->cache = $cache;
        return $this;
    }

    public function getFirebase(): ?bool
    {
        return $this->firebase;
    }

    public function setFirebase(?bool $firebase): self
    {
        $this->firebase = $firebase;
        return $this;
    }

    public function getUnifiedPush(): ?bool
    {
        return $this->unifiedPush;
    }

    public function setUnifiedPush(?bool $unifiedPush): self
    {
        $this->unifiedPush = $unifiedPush;
        return $this;
    }

    public function getPollId(): ?string
    {
        return $this->pollId;
    }

    public function setPollId(?string $pollId): self
    {
        $this->pollId = $pollId;
        return $this;
    }
}
