<?php

namespace App\Libs\Helpers;

class GitHashVersion
{
    public const MAJOR = 1;

    public const MINOR = 0;

    public const PATCH = 3;

    public static function get()
    {
        if (! config('version-by-git.show_versions')) {
            return null;
        }

        return \Illuminate\Support\Facades\Cache::remember('version_by_commit', 30 /*secs*/, function () {
            if (config('version-by-git.use_exec') && function_exists('exec')) {
                return self::viaExec();
            }

            return self::viaFile();
        });
    }

    /**
     * function viaExec
     *
     * @return string
     */
    public static function viaExec()
    {
        $commitHash = trim(exec('git log --pretty="%h" -n1 HEAD'));

        if (config('version-by-git.show_commit_date')) {
            $commitDate = new \DateTime(trim(exec('git log -n1 --pretty=%ci HEAD')));
            $formatedCommitDate = $commitDate->format('Y-m-d H:i:s');
        }

        $formatedCommitDate = isset($formatedCommitDate) ? "({$formatedCommitDate})" : '';

        $env = config('app.env', 'production');

        return sprintf("v%s.%s.%s-{$env}.%s %s", self::MAJOR, self::MINOR, self::PATCH, $commitHash, $formatedCommitDate);
    }

    /**
     * function viaFile
     *
     * @return string
     */
    public static function viaFile()
    {
        $branch = self::get_current_git_branch();

        if (config('version-by-git.show_commit_date')) {
            $commitDate = new \DateTime(trim(self::get_current_git_datetime($branch)));
            $formatedCommitDate = $commitDate->format('Y-m-d H:i:s');
        }

        $formatedCommitDate = isset($formatedCommitDate) ? "({$formatedCommitDate})" : '';
        $env = config('app.env', 'production');

        $commitHash = substr(file_get_contents(base_path(".git/refs/heads/{$branch}")), 0, 7);

        return sprintf("v%s.%s.%s-{$env}.%s %s", self::MAJOR, self::MINOR, self::PATCH, $commitHash, $formatedCommitDate);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function get_current_git_branch()
    {
        $file_name = sprintf(base_path('.git/HEAD'));

        if (! file_exists($file_name)) {
            return null;
        }

        $data = file_get_contents($file_name);
        $array = explode('/', $data);
        $array = array_reverse($array);

        return  trim(''.$array[0] ?? '');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function get_current_git_datetime($branch = 'master')
    {
        $file_name = sprintf(base_path('.git/refs/heads/%s'), $branch);
        $time = filemtime($file_name);
        if ($time != 0) {
            return date('Y-m-d H:i:s', $time);
        } else {
            return  'time=0';
        }
    }
}
