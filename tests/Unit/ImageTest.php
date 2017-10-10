<?php

namespace Tests\Unit;

use App\Models\Collections\Image;

class ImageTest extends AssetTestCase
{

    protected $model = Image::class;

    protected $route = 'images';


    // /** @test */
    // public function it_deletes_a_single_image()
    // {

    //     $this->make(Image::class);

    //     $response = $this->deleteJson('api/v1/images/' .$this->ids[0]);
    //     $response->assertSuccessful();

    // }

    // /** @test */
    // public function it_deletes_multiple_images()
    // {

    //     $this->times(5)->make(Image::class);

    //     $response = $this->deleteJson('api/v1/images?ids=' .implode(',',array_slice($this->ids, 0, 3)));
    //     $response->assertSuccessful();

    // }

    // /** @test */
    // public function it_overwrites_an_existing_image()
    // {

    //     $this->make(Image::class);

    //     $response = $this->putJson('api/v1/images/' .$this->ids[0]);
    //     $response->assertSuccessful();

    // }

    // /** @test */
    // public function it_adds_a_new_image()
    // {

    //     $this->make(Image::class);

    //     $response = $this->postJson('api/v1/images');
    //     $response->assertSuccessful();

    // }

}
