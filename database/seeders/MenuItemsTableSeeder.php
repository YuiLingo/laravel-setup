<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $menu = Menu::where('name', 'admin')->firstOrFail();

        $menuItems = $this->getAdminMenuItems();

        foreach ($menuItems as $key => $menuItem) {

            $this->upsertMenuItem($menu->id, $menuItem, $key);
        }
    }

    /**
     * Upsert Menu Items
     */
    protected function upsertMenuItem($menuId, $menu, $order, $parentId = null) {

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menuId,
            'title'   => $menu['title'],

        ]);
        if ($menuItem->exists) {

            $menuItem->update([
                'url'     => $menu['url'],
                'route'   => $menu['route'],
                'target'     => $menu['target'],
                'icon_class' => $menu['icon_class'],
                'color'      => $menu['color'],
                'parent_id'  => $parentId,
                'order'      => $order,
            ]);

        } else {

            $menuItem->fill([
                'url'     => $menu['url'],
                'route'   => $menu['route'],
                'target'     => $menu['target'],
                'icon_class' => $menu['icon_class'],
                'color'      => $menu['color'],
                'parent_id'  => $parentId,
                'order'      => $order,
            ])->save();
        }

        /**
         * check and upsert Child Menu
         */
        if(!empty($menu['child']) && is_array($menu['child'])) {

            foreach($menu['child'] as $key => $childMenu) {

                $this->upsertMenuItem($menuId, $childMenu, $key, $menuItem->id);
            }
        }

    }

        /**
     * Menu Items
     */
    protected function getAdminMenuItems() {

        return [
            [
                'title'   => __('voyager::seeders.menu_items.dashboard'),
                'url'     => '',
                'route'   => 'voyager.dashboard',
                'target'     => '_self',
                'icon_class' => 'voyager-boat',
                'color'      => null,
                'parent_id'  => null,
            ],
            [
                'title'   => __('voyager::seeders.menu_items.media'),
                'url'     => '',
                'route'   => 'voyager.media.index',
                'target'     => '_self',
                'icon_class' => 'voyager-images',
                'color'      => null,
                'parent_id'  => null,
            ],
            [
                'title'   => 'User Manager',
                'url'     => '',
                'route'   => null,
                'target'     => '_self',
                'icon_class' => 'voyager-people',
                'color'      => '#000000',
                'parent_id'  => null,
                'child'      => [
                    [
                        'title'   => __('voyager::seeders.menu_items.users'),
                        'url'     => '',
                        'route'   => 'voyager.users.index',
                        'target'     => '_self',
                        'icon_class' => 'voyager-person',
                        'color'      => null,
                        'parent_id'  => null,
                    ],
                    [
                        'title'   => __('voyager::seeders.menu_items.roles'),
                        'url'     => '',
                        'route'   => 'voyager.roles.index',
                        'target'     => '_self',
                        'icon_class' => 'voyager-lock',
                        'color'      => null,
                        'parent_id'  => null,
                    ],
                ]
            ],
            [
                'title'   => 'Tools Manager',
                'url'     => '',
                'route'   => null,
                'target'     => '_self',
                'icon_class' => 'voyager-tools',
                'color'      => null,
                'parent_id'  => null,
                'child'      => [
                    [
                        'title'   => __('voyager::seeders.menu_items.menu_builder'),
                        'url'     => '',
                        'route'   => 'voyager.menus.index',
                        'target'     => '_self',
                        'icon_class' => 'voyager-list',
                        'color'      => null,
                        'parent_id'  => null,
                    ],
                    [
                        'title'   => __('voyager::seeders.menu_items.database'),
                        'url'     => '',
                        'route'   => 'voyager.database.index',
                        'target'     => '_self',
                        'icon_class' => 'voyager-data',
                        'color'      => null,
                        'parent_id'  => null,
                    ],
                    [
                        'title'   => __('voyager::seeders.menu_items.compass'),
                        'url'     => '',
                        'route'   => 'voyager.compass.index',
                        'target'     => '_self',
                        'icon_class' => 'voyager-compass',
                        'color'      => null,
                        'parent_id'  => null,
                    ],
                    [
                        'title'   => __('voyager::seeders.menu_items.bread'),
                        'url'     => '',
                        'route'   => 'voyager.bread.index',
                        'target'     => '_self',
                        'icon_class' => 'voyager-bread',
                        'color'      => null,
                        'parent_id'  => null,
                    ],
                    [
                        'title'   => __('voyager::seeders.menu_items.settings'),
                        'url'     => '',
                        'route'   => 'voyager.settings.index',
                        'target'     => '_self',
                        'icon_class' => 'voyager-settings',
                        'color'      => null,
                        'parent_id'  => null,
                    ],
                ]
            ],
        ];
    }
}
