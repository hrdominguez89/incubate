<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
       'move-comunication',
       'move-categories-information',
       'move-categories-post',
       'move-categories-project',
       'move-categories',
       'move-categories-job',
       'move-categories-mentors',
       'move-categories-event',
       'move-members',
       'move-mentors',
       'move-dedicated',
       'move-states',
       'move-persons',
       'move-interests',
       'move-types',
       'move-post',
       'move-faq',
       'upload-image',
       'upload-thumb',
       'move-event',
       'move-menu',
       'move-menu-footer',
       'move-project',
       'move-widget',
       'saveContact',
       'saveMailchimp',
       'saveEmprendimiento',
       'posts-archives/*',
       'projects-archives/*',
       'event-archives/*'
    ];
}
