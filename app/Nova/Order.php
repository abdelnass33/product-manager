<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class Order extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Order>
     */
    public static $model = \App\Models\Order::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'order_number';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'order_number',
        'customer.first_name',
        'customer.last_name',
        'customer.email',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Order Number')
                ->sortable()
                ->rules('required', 'max:255', 'unique:orders,order_number,{{resourceId}}'),

            BelongsTo::make('Customer')
                ->sortable()
                ->rules('required'),

            Currency::make('Total Amount')
                ->currency('USD')
                ->sortable()
                ->rules('required', 'numeric', 'min:0'),

            Select::make('Status')
                ->options([
                    'pending' => 'Pending',
                    'processing' => 'Processing',
                    'shipped' => 'Shipped',
                    'delivered' => 'Delivered',
                    'cancelled' => 'Cancelled',
                ])
                ->sortable()
                ->rules('required')
                ->default('pending'),

            Textarea::make('Shipping Address')
                ->rules('required')
                ->hideFromIndex(),

            Textarea::make('Notes')
                ->nullable()
                ->hideFromIndex(),
        ];
    }

    /**
     * Get the cards available for the resource.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array<int, \Laravel\Nova\Filters\Filter>
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array<int, \Laravel\Nova\Lenses\Lens>
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array<int, \Laravel\Nova\Actions\Action>
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }
}
