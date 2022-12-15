<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

use App\Models\User;
use App\Models\Country;

class Announcer extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\User';

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
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('type', '=', User::ANNOUNCER_TYPE);
    }

    /**
     * Get a fresh instance of the model represented by the resource.
     *
     * @return mixed
     */
    public static function newModel()
    {
        $model = static::$model;
        $instance = new $model;

        if ($instance->type == null) {
            $instance->type = User::ANNOUNCER_TYPE;
        }

        return $instance;
    }

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

            Text::make('First name', 'firstname')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Last name', 'lastname')
                ->sortable()
                ->rules('required', 'max:255'),

            Date::make('Birthdate')
                ->sortable()
                ->rules('required', 'before:today'),

            BelongsTo::make('Country ID', 'country', 'App\Nova\Country')
                ->sortable()
                ->onlyOnIndex(),

            BelongsTo::make('Country')
                ->display(function ($country) {
                    return $country->name;
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

            Text::make('Phone')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:255')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8', 'max:255')
                ->updateRules('nullable', 'string', 'min:8', 'max:255'),
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
