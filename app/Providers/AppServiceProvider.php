<?php

namespace App\Providers;

use App\Constants\Status;
use App\Models\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $general        = Cache::get('GeneralSetting');
        $general        = gs();
        $activeTemplate = activeTemplate();

        $viewShare['general']            = $general;
        $viewShare['activeTemplate']     = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['emptyMessage']       = 'No data found';

        view()->share($viewShare);
        view()->composer('admin.partials.sidenav', function ($view) {
            $user = auth('admin')->user();
        });
        view()->composer('admin.partials.topnav', function ($view) {
        });
        view()->composer($activeTemplate . 'partials.header', function ($view) use ($activeTemplate) {
        });
        Paginator::useBootstrapFour();
    }
}
