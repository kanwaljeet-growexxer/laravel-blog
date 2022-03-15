<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$posts = [
    		[
    			'title'    => 'Test post title first',
                'description'  => 'Test post content first',
                'category' => 'Railway',
                'user_id' => 1
    		],
    		[
    			'title'    => 'Test post title second',
                'description'  => 'Test post content second',
                'category' => 'IT',
                'user_id' => 1
    		],
            [
    			'title'    => 'Test post title third',
                'description'  => 'Test post content third',
                'category' => 'Food',
                'user_id' => 1
    		],
            [
    			'title'    => 'Test post title',
                'description'  => 'Test post content',
                'category' => 'Railway',
                'user_id' => 1
    		],
    	];

    	foreach ($posts as $post) {
    		Post::create($post);
    	}
    }
}