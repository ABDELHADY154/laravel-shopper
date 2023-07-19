<?php

declare(strict_types=1);

namespace Shopper\Events;

use Shopper\Core\Enum\OrderStatus;
use Shopper\Core\Models\Order;
use Shopper\Sidebar\AbstractAdminSidebar;
use Shopper\Sidebar\Contracts\Builder\Group;
use Shopper\Sidebar\Contracts\Builder\Item;
use Shopper\Sidebar\Contracts\Builder\Menu;

final class SalesSidebar extends AbstractAdminSidebar
{
    public function extendWith(Menu $menu): Menu
    {
        $count = Order::query()->where('status', OrderStatus::PENDING->value)->count();

        $menu->group(__('shopper::layout.sidebar.sales'), function (Group $group) use ($count): void {
            $group->weight(3);
            $group->setAuthorized();
            $group->setGroupItemsClass('space-y-1');
            $group->setHeadingClass('menu-heading text-xs leading-5 text-secondary-500 dark:text-secondary-400 uppercase tracking-wider mb-2 font-medium ml-3');

            $group->item(__('shopper::layout.sidebar.orders'), function (Item $item) use ($count): void {
                $item->weight(1);
                $item->setAuthorized($this->user->hasPermissionTo('browse_orders'));
                $item->setItemClass('group flex items-center rounded-lg py-2 px-3 text-sm font-medium');
                $item->setActiveClass('text-primary-600 bg-primary-50 dark:bg-primary-600/10');
                $item->setInactiveClass('text-secondary-700 dark:text-secondary-300 hover:text-secondary-900 dark:hover:text-white hover:bg-secondary-100 dark:hover:bg-secondary-700');

                if ($count > 0) {
                    $item->badge($count, 'inline-flex items-center rounded-full bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20');
                }

                $item->route('shopper.orders.index');
                $item->setIcon(
                    icon: '
                        <svg class="h-5 w-5 mr-2" fill="none" xmlns="http://www.w3.org/2000/svg" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M5.52 2.64 3.96 4.72c-.309.412-.463.618-.46.79a.5.5 0 0 0 .192.384C3.828 6 4.085 6 4.6 6h14.8c.515 0 .773 0 .908-.106a.5.5 0 0 0 .192-.384c.003-.172-.151-.378-.46-.79l-1.56-2.08m-12.96 0c.176-.235.264-.352.376-.437a1 1 0 0 1 .33-.165C6.36 2 6.505 2 6.8 2h10.4c.293 0 .44 0 .575.038a1 1 0 0 1 .33.165c.111.085.199.202.375.437m-12.96 0L3.64 5.147c-.237.316-.356.475-.44.649a2 2 0 0 0-.163.487C3 6.473 3 6.671 3 7.067V18.8c0 1.12 0 1.68.218 2.108a2 2 0 0 0 .874.874C4.52 22 5.08 22 6.2 22h11.6c1.12 0 1.68 0 2.108-.218a2 2 0 0 0 .874-.874C21 20.48 21 19.92 21 18.8V7.067c0-.396 0-.594-.037-.784a1.998 1.998 0 0 0-.163-.487c-.084-.174-.203-.333-.44-.65L18.48 2.64M16 10a4 4 0 1 1-8 0"/>
                        </svg>
                    ',
                    type: 'svg'
                );
            });
            $group->item(__('shopper::layout.sidebar.discounts'), function (Item $item): void {
                $item->weight(2);
                $item->setAuthorized($this->user->hasPermissionTo('browse_discounts'));
                $item->setItemClass('group flex items-center rounded-lg py-2 px-3 text-sm font-medium');
                $item->setActiveClass('text-primary-600 bg-primary-50 dark:bg-primary-600/10');
                $item->setInactiveClass('text-secondary-700 dark:text-secondary-300 hover:text-secondary-900 dark:hover:text-white hover:bg-secondary-100 dark:hover:bg-secondary-700');
                $item->route('shopper.discounts.index');
                $item->setIcon(
                    icon: '
                        <svg class="h-5 w-5 mr-2" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M9 9h.01M15 15h.01M16 8l-8 8m9.901-11.001a2.03 2.03 0 0 0 1.1 1.1l1.744.723a2.033 2.033 0 0 1 1.1 2.656l-.722 1.744a2.03 2.03 0 0 0 0 1.556l.722 1.744a2.033 2.033 0 0 1-1.1 2.656L19 17.901A2.033 2.033 0 0 0 17.9 19l-.723 1.745a2.032 2.032 0 0 1-2.656 1.1l-1.744-.722a2.032 2.032 0 0 0-1.555 0l-1.745.723a2.033 2.033 0 0 1-2.654-1.1L6.1 19.001A2.033 2.033 0 0 0 5 17.9l-1.744-.723a2.033 2.033 0 0 1-1.1-2.654l.721-1.744a2.033 2.033 0 0 0 0-1.556l-.722-1.746a2.033 2.033 0 0 1 1.1-2.657L5 6.098A2.03 2.03 0 0 0 6.1 5l.723-1.745a2.033 2.033 0 0 1 2.656-1.1l1.744.722a2.033 2.033 0 0 0 1.555-.001l1.746-.72a2.032 2.032 0 0 1 2.655 1.1l.723 1.746v-.003ZM9.5 9a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Zm6 6a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z"/>
                        </svg>
                    ',
                    type: 'svg'
                );
            });
        });

        return $menu;
    }
}