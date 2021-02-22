<?php

namespace EG\Slug;

use Arr;
use EG\Slug\Repositories\Interfaces\SlugInterface;
use Str;

class SlugHelper
{
    public function registerModule($model, ?string $name = null): self
    {
        $supported = $this->supportedModels();
        if (!is_array($model)) {
            $supported[$model] = $name ? $name : $model;
        } else{
            foreach ($model as $item) {
                $supported[$item] = $name ? $name : $item;
            }
        }
        config(['packages.slug.general.supported' => $supported]);
        return $this;
    }

    public function supportedModels(): array
    {
        return config('packages.slug.general.supported', []);
    }

    public function setPrefix(string $model, ?string $prefix): self
    {
        $prefixes = config('packages.slug.general.prefixes', []);
        $prefixes[$model] = $prefix;

        config(['packages.slug.general.prefixes' => $prefixes]);
        return $this;
    }

    public function isSupportedModel(string $model): bool
    {
        return in_array($model, array_keys($this->supportedModels()));
    }

    public function disablePreview($model): self
    {
        if (!is_array($model)) {
            $model = [$model];
        }
        config([
            'packages.slug.general.disable_preview' => array_merge(config('packages.slug.general.disable_preview', []),
                $model),
        ]);
        return $this;
    }

    public function canPreview(string $model): bool
    {
        return !in_array($model, config('packages.slug.general.disable_preview', []));
    }

    public function getSlug(
        ?string $key,
        ?string $prefix = null,
        ?string $model = null
    )
    {
        $condition = [
            'key' => $key,
        ];

        if ($model) {
            $condition['reference_type'] = $model;
        }

        if ($prefix) {
            $condition['prefix'] = $prefix;
        }

        return app(SlugInterface::class)->getFirstBy($condition);
    }

    public function getPrefix(string $model, string $default = ''): ?string
    {
        $permalink = setting($this->getPermalinkSettingKey($model));

        if ($permalink !== null) {
            return $permalink;
        }

        $config = Arr::get(config('packages.slug.general.prefixes', []), $model);

        if ($config !== null) {
            return (string)$config;
        }

        return $default;
    }

    public function getPermalinkSettingKey(string $model): string
    {
        return 'permalink-' . Str::slug(str_replace('\\', '_', $model));
    }
}
