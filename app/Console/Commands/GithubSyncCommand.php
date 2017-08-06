<?php

namespace App\Console\Commands;

use App\Models\Github;
use Illuminate\Console\Command;

class GithubSyncCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'github:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronise Github Issues';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $currentGithubData = Github::get();
        do {
            if (!isset($data['links']['next'][0])) {
                $data = \App\Libraries\Helpers::fetch("https://api.github.com/repos/".env('REPERSITORY_TO_WATCH')."/issues?labels=" . urlencode(env('LABEL_TO_VOTE')) . "&sort=created&direction=asc&per_page=100&state=all&access_token=".env('ACCESS_TOKEN'));
            } else {
                $data = \App\Libraries\Helpers::fetch($data['links']['next'][0]);
            }

            if ($data['responseCode'] <> 200) {
                throw new \Exception("Github sync command fail", $data['responseCode']);
            }

            \DB::beginTransaction();
            foreach ($data['response'] as $git) {
                $curGit = $currentGithubData->where('id', $git->id)->first();
                if (!$curGit || $curGit->title <> $git->title || $curGit->state <> $git->state || $curGit->comments <> $git->comments) {
                    Github::findOrNew($git->id)->fill([
                        'id'         => $git->id,
                        'title'      => $git->title,
                        'html_url'   => $git->html_url,
                        'state'      => $git->state,
                        'comments'   => $git->comments,
                        'created_at' => date('Y-m-d H:i:s', strtotime($git->created_at)),
                    ])->save();
                }
            }
            \DB::commit();
        } while (isset($data['links']['last'][0]));



        return true;
    }
}
