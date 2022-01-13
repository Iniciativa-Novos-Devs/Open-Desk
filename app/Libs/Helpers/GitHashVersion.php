<?php

namespace App\Libs\Helpers;

class GitHashVersion
{
    const MAJOR = 1;
    const MINOR = 0;
    const PATCH = 3;

    public static function get()
    {
        if(!config('version-by-git.show_versions'))
        {
            return null;
        }

        $commitHash = trim(exec('git log --pretty="%h" -n1 HEAD'));

        if(config('version-by-git.show_commit_date'))
        {
            $commitDate = new \DateTime(trim(exec('git log -n1 --pretty=%ci HEAD')));
            $commitDate->setTimezone(new \DateTimeZone('UTC'));
            $formatedCommitDate = $commitDate->format('Y-m-d H:i:s');
        }

        $formatedCommitDate = isset($formatedCommitDate) ? "({$formatedCommitDate})" : '';

        $env = config('app.env', 'production');

        return sprintf("v%s.%s.%s-{$env}.%s %s", self::MAJOR, self::MINOR, self::PATCH, $commitHash, $formatedCommitDate);
    }
}
