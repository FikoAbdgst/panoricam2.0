<?php

namespace App\Console\Commands;

use App\Models\Frame;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateFrameTemplate extends Command
{
    protected $signature = 'frame:template {frameId : The ID of the frame}';
    protected $description = 'Create a template file for a specific frame';

    public function handle()
    {
        $frameId = $this->argument('frameId');
        $frame = Frame::findOrFail($frameId);

        $templatePath = resource_path('views/admin/frames/templates/' . $frame->slug . '.blade.php');

        // Check if template already exists
        if (File::exists($templatePath)) {
            if (!$this->confirm("Template for '{$frame->name}' already exists. Overwrite?")) {
                $this->info('Operation cancelled.');
                return;
            }
        }

        // Get the default template as a starting point
        $defaultTemplate = File::get(resource_path('views/admin/frames/templates/default.blade.php'));

        // Replace placeholders with frame-specific content
        $content = str_replace(
            ['class="default-frame"', 'Frame Template: Default'],
            ['class="' . $frame->slug . '-frame"', 'Frame Template: ' . $frame->name],
            $defaultTemplate
        );

        // Create the file
        File::put($templatePath, $content);

        $this->info("Template for '{$frame->name}' created at: " . $templatePath);
    }
}
