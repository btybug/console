<?php

namespace Btybug\Console\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/Lang', 'console');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'console');

        $tubs = [
            'structure_console' => [
                [
                    'title' => 'Pages',
                    'url' => '/admin/console/structure/pages',
                ],
                [
                    'title' => 'Menus',
                    'url' => '/admin/console/structure/menus',
                ],
                [
                    'title' => 'Classify',
                    'url' => '/admin/console/structure/classify',
                ],
                [
                    'title' => 'Urls',
                    'url' => '/admin/console/structure/urls',
                ],
                [
                    'title' => 'Settings',
                    'url' => '/admin/console/structure/settings',
                ],
                [
                    'title' => 'Tables',
                    'url' => '/admin/console/structure/tables',
                ],
                [
                    'title' => 'Master Forms',
                    'url' => '/admin/console/structure/forms',
                ],
                [
                    'title' => 'Edit Forms',
                    'url' => '/admin/console/structure/edit-forms',
                ],
                [
                    'title' => 'Fields',
                    'url' => '/admin/console/structure/fields',
                ]
            ],
            'backend_gears' => [
                [
                    'title' => 'General Fields',
                    'url' => '/admin/console/backend/general-fields',
                    'icon' => 'fa fa-cub'
                ],
                [
                    'title' => 'Special fields',
                    'url' => '/admin/console/backend/special-fields',
                    'icon' => 'fa fa-cub'
                ]
            ], 'console_general' => [
                [
                    'title' => 'Validations',
                    'url' => '/admin/console/general',
                ],
                [
                    'title' => 'Trigger & Events',
                    'url' => '/admin/console/general/trigger-events',
                ]
            ],
        ];

        \Eventy::action('my.tab', $tubs);

        \Eventy::action('add.validation', [
            'test' => 'Added from plugin'
        ]);

        //TODO; remove when finish all
//        \Btybug\Cms\Models\Routes::registerPages('sahak.avatar/console');
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
