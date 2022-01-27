<?php
namespace App\Repositories\Candidate;
use Illuminate\Support\ServiceProvider;

class CandidateRepoServiceProvider extends ServiceProvider{
    public function boot(){}

    public function register(){
        $this->app->bind('App\Repositories\Candidate\CandidateInterface',
        'App\Repositories\Candidate\CandidateRepository');
    }
}
