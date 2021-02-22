<?php
namespace EG\Slug\Commands;

use Illuminate\Console\Command;
use EG\Slug\Repositories\Interfaces\SlugInterface;

class ChangeSlugPrefixCommand extends Command
{
    protected $signature = 'cms:slug:prefix {class : model class} {--prefix= : The prefix of slugs}';

    protected $description = 'Change/set prefix for slugs';

    public function handle()
    {
        $data = app(SlugInterface::class)->update(
            [
                'reference_type' => $this->argument('class'),
            ],
            [
                'prefix' => $this->option('prefix') ?? '',
            ]
        );

        $this->info('Processed ' . $data . ' item(s)!');

        return 0;
    }
}
