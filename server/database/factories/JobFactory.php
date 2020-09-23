<?php

namespace Database\Factories;

use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Models\User;
use Carbon\Carbon;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = [
            Carbon::now()->addDays(Arr::random([10, 5, 8, 12, 20, 30, 35, 40])), 
            Carbon::now()->subDays(Arr::random([10, 5, 8, 12, 20, 30, 35, 40, 45, 60]))
        ];

        // $employer = User::where('is_employer', true)->inRandomOrder()->get()->toArray();
        $employer = User::where('is_employer', true)->inRandomOrder()->pluck('id')->toArray();
        return [
            'user_id'       => function() use ($employer) {
                
                return Arr::random($employer);
            },
            'name'          => $this->faker->unique()->name,
            'description'   => $this->faker->sentence(500),
            'salary'        => $this->faker->numberBetween(0, 120000),
            'apply_before'  => function()  use ($date) {
                return Arr::random($date);
            },
            'tags'          => function(){
                $tags = [
                    'php,aws,laravel,vuejs',
                    'javascript,vuejs,vuex,nuxt',
                    'javascript,react,redux,next',
                    'php,laravel,react,aws',
                    'python,django,react,jwt',
                    'python,flask,vuejs',
                    'nodejs,express,react,next,redux',
                    'php,laravel,livewire,alphinejs,vuejs',
                    'ruby,ruby on rails,react,redux'
                ];
                return Arr::random($tags);
            }
        ];
    }
}
