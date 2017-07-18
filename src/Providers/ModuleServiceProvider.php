<?php

namespace Sahakavatar\Console\Providers;

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
            ], 'backend_console' => [
                [
                    'title' => 'Theme',
                    'url' => '/admin/console/backend/theme',
                ],
                [
                    'title' => 'Layouts',
                    'url' => '/admin/console/backend/layouts',
                ],
                [
                    'title' => 'Units',
                    'url' => '/admin/console/backend/units',
                ],
                [
                    'title' => 'Views',
                    'url' => '/admin/console/backend/views',
                ],
            ],
            'backend_gears' => [
                [
                    'title' => 'Templates',
                    'url' => '/admin/console/backend/templates',
                    'icon' => 'fa fa-cub'
                ],
                [
                    'title' => 'Page Section',
                    'url' => '/admin/console/backend/page-section',
                    'icon' => 'fa fa-cub'
                ],
                [
                    'title' => 'Sections',
                    'url' => '/admin/console/backend/sections',
                    'icon' => 'fa fa-cub'
                ],
                [
                    'title' => 'Units',
                    'url' => '/admin/console/backend/units',
                    'icon' => 'fa fa-cub'
                ],
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
            ],'console_general' => [
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
