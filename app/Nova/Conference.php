<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

use App\Models\Country;
use App\Models\Category;

class Conference extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Conference';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Title')
                ->sortable()
                ->rules('required', 'min:2', 'max:255'),

            Date::make('Date')
                ->sortable()
                ->rules('required', 'after_or_equal:today'),

            Number::make('Latitude')
                ->rules('required')
                ->min(-90)
                ->max(90),

            Number::make('Longitude')
                ->rules('required')
                ->min(-180)
                ->max(180),

            BelongsTo::make('Country ID', 'country', 'App\Nova\Country')
                ->sortable()
                ->onlyOnIndex(),
            BelongsTo::make('Category ID', 'category', 'App\Nova\Category')
                ->sortable()
                ->onlyOnIndex(),

            BelongsTo::make('Country')
                ->display(function ($country) {
                    return $country->name;
                })
                ->onlyOnDetail(),
            BelongsTo::make('Category')
                ->display(function ($category) {
                    return $category->name;
                })
                ->onlyOnDetail(),

            Select::make('Country', 'country_id')
                ->options(function () {
                    return Country::all()
                        ->reduce(function ($carry, $item) {
                            $carry[$item->id] = $item->name;
                            return $carry;
                        }, []);
                })
                ->displayUsingLabels()
                ->rules('required')
                ->onlyOnForms(),
            Select::make('Category', 'category_id')
                ->options(function () {
                    return Category::all()
                        ->reduce(function ($carry, $item) {
                            $carry[$item->id] = $item->name;
                            return $carry;
                        }, []);
                })
                ->displayUsingLabels()
                ->nullable()
                ->onlyOnForms(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
