<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 11/11/2018
 * Time: 12:58 PM
 */

namespace Sarfraznawaz2005\EmailWatch;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Str;
use Swift_Mime_SimpleMessage;

class EmailWatch
{
    private $fs;
    private $path;

    /**
     * @param Filesystem $fs
     */
    public function __construct(Filesystem $fs)
    {
        $this->fs = $fs;
        $this->path = config('emailwatch.path');

        $this->createEmailDirectory();
    }

    /**
     * @param MessageSent $event
     */
    public function open(MessageSent $event)
    {
        $filePath = $this->getFilePath($event->message) . '.eml';

        $this->fs->put($filePath, $event->message->toString());

        if ($this->fs->exists($filePath)) {
            exec(escapeshellcmd($filePath));
        }

        $this->cleanOld();
    }

    /**
     * Create eml directory.
     */
    protected function createEmailDirectory()
    {
        if (!$this->fs->exists($this->path)) {
            $this->fs->makeDirectory($this->path);
            $this->fs->put($this->path . '/.gitignore', "*\n!.gitignore");
        }
    }

    /**
     * @param Swift_Mime_SimpleMessage $message
     * @return string
     */
    protected function getFilePath(Swift_Mime_SimpleMessage $message)
    {
        $to = str_replace(['@', '.'], ['_at_', '_'], array_keys($message->getTo())[0]);

        $subject = $message->getSubject();

        return $this->path . '/' . Str::slug($message->getDate()->getTimestamp() . '_' . $to . '_' . $subject, '_');
    }

    /**
     * Delete old eml files
     */
    private function cleanOld()
    {
        $oldFiles = array_filter($this->fs->files($this->path), function ($file) {
            return time() - $this->fs->lastModified($file) > config('emailwatch.keep_time');
        });

        if ($oldFiles) {
            $this->fs->delete($oldFiles);
        }
    }
}