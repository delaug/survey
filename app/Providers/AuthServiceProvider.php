<?php

namespace App\Providers;

use App\Models\Field;
use App\Models\Question;
use App\Models\QuestionType;
use App\Models\Role;
use App\Models\Survey;
use App\Models\User;
use App\Policies\Admin\FieldPolicy;
use App\Policies\Admin\QuestionPolicy;
use App\Policies\Admin\QuestionTypePolicy;
use App\Policies\Admin\RolePolicy;
use App\Policies\Admin\SurveyPolicy;
use App\Policies\Admin\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Survey::class => SurveyPolicy::class,
        Question::class => QuestionPolicy::class,
        QuestionType::class => QuestionTypePolicy::class,
        Field::class => FieldPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
