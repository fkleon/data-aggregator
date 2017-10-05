<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Collections\Artwork;
use App\Models\Collections\ArtworkDate;
use App\Models\Collections\Image;
use App\Models\Collections\Category;
use App\Models\Collections\Agent;
use App\Models\Collections\AgentType;
use App\Models\Collections\Artist;
use App\Models\Collections\Gallery;

class ArtworkTest extends ApiTestCase
{

    /** @test */
    public function it_fetches_all_artworks()
    {

        $resources = $this->it_fetches_all(Artwork::class, 'artworks');

        $this->assertArrayHasKeys($resources, ['lake_guid'], true);

    }

    /** @test */
    public function it_fetches_a_single_artwork()
    {

        $resource = $this->it_fetches_a_single(Artwork::class, 'artworks');

        $this->assertArrayHasKeys($resource, ['lake_guid']);

    }

    /** @test */
    public function it_fetches_multiple_artworks()
    {

        $resources = $this->it_fetches_multiple(Artwork::class, 'artworks');

        $this->assertArrayHasKeys($resources, ['lake_guid'], true);

    }

    /** @test */
    public function it_fetches_essential_artworks()
    {

        $this->make(Artwork::class, ['citi_id' => 185651]);
        $this->make(Artwork::class, ['citi_id' => 183077]);
        $this->make(Artwork::class, ['citi_id' => 151358]);
        $this->make(Artwork::class, ['citi_id' => 99539]);
        $this->make(Artwork::class, ['citi_id' => 189595]);
        $resources = $this->it_fetches_multiple(Artwork::class, 'artworks/essentials');

        $this->assertArrayHasKeys($resources, ['lake_guid'], true);

    }

    /** @test */
    public function it_400s_if_nonnumerid_nonuuid_is_passed()
    {

        $this->it_400s(Artwork::class, 'artworks');

    }

    /** @test */
    public function it_403s_if_limit_is_too_high()
    {

        $this->it_403s(Artwork::class, 'artworks');

    }

    /** @test */
    public function it_404s_if_not_found()
    {

        $this->it_404s(Artwork::class, 'artworks');

    }

    /** @test */
    public function it_405s_if_a_request_is_posted()
    {

        $this->it_405s(Artwork::class, 'artworks');

    }


    /** @test */
    public function it_fetches_images_for_an_artwork()
    {

        $artworkKey = $this->attach(Image::class, 4)->make(Artwork::class);

        $response = $this->getJson('api/v1/artworks/' .$artworkKey .'/images');
        $response->assertSuccessful();

        $images = $response->json()['data'];
        $this->assertCount(4, $images);

        foreach ($images as $image)
        {
            $this->assertArrayHasKeys($image, ['id', 'title', 'content']);
        }
    }

    /** @test */
    public function it_fetches_categories_for_an_artwork()
    {

        $artworkKey = $this->attach(Category::class, 4)->make(Artwork::class);

        $response = $this->getJson('api/v1/artworks/' .$artworkKey .'/categories');
        $response->assertSuccessful();

        $pubcats = $response->json()['data'];
        $this->assertCount(4, $pubcats);

        foreach ($pubcats as $pubcat)
        {
            $this->assertArrayHasKeys($pubcat, ['id', 'title', 'parent_id']);
        }
    }

    public function it_fetches_resources_for_an_artwork()
    {

        $artworkKey = $this->attach([Sound::class, Video::class, Text::class, Link::class], 4)->make(Artwork::class);

        $response = $this->getJson('api/v1/artworks/' .$artworkKey .'/resources');
        $response->assertSuccessful();

        $resources = $response->json()['data'];
        $this->assertCount(16, $resources);

        foreach ($resources as $resource)
        {
            $this->assertArrayHasKeys($resource, ['id', 'title']);
        }
    }

    /** @test */
    public function it_fetches_the_artists_for_an_artwork()
    {

        $artworkKey = $this->attach(Agent::class, 2, 'artists')->make(Artwork::class);

        $response = $this->getJson('api/v1/artworks/' .$artworkKey .'/artists');
        $response->assertSuccessful();

        $artists = $response->json()['data'];
        $this->assertCount(2, $artists);

        foreach ($artists as $artist)
        {
            $this->assertArrayHasKeys($artist, ['id', 'title']);
        }

    }

    /** @test */
    public function it_fetches_the_copyright_representatives_for_an_artwork()
    {

        $copyRepAgentType = $this->make(AgentType::class, ['title' => 'Copyright Representative']);
        $artworkKey = $this->attach(Agent::class, 2, 'copyrightRepresentatives', ['agent_type_citi_id' => $copyRepAgentType])->make(Artwork::class);

        $response = $this->getJson('api/v1/artworks/' .$artworkKey .'/copyrightRepresentatives');
        $response->assertSuccessful();

        $copyrightRepresentatives = $response->json()['data'];
        $this->assertCount(2, $copyrightRepresentatives);

        foreach ($copyrightRepresentatives as $copyrightRepresentative)
        {
            $this->assertArrayHasKeys($copyrightRepresentative, ['id', 'title']);
        }

    }


    /** @test */
    public function it_fetches_the_parts_for_an_artwork()
    {

        $artworkKey = $this->attach(Artwork::class, 2, 'parts')->make(Artwork::class);

        $response = $this->getJson('api/v1/artworks/' .$artworkKey .'/parts');
        $response->assertSuccessful();

        $parts = $response->json()['data'];
        $this->assertCount(2, $parts);

        foreach ($parts as $part)
        {
            $this->assertArrayHasKeys($part, ['id', 'title']);
        }

    }

    /** @test */
    public function it_fetches_the_sets_for_an_artwork()
    {

        $artworkKey = $this->attach(Artwork::class, 2, 'sets')->make(Artwork::class);

        $response = $this->getJson('api/v1/artworks/' .$artworkKey .'/sets');
        $response->assertSuccessful();

        $sets = $response->json()['data'];
        $this->assertCount(2, $sets);

        foreach ($sets as $set)
        {
            $this->assertArrayHasKeys($set, ['id', 'title']);
        }

    }

    /** @test */
    public function it_parses_dimension_properly()
    {

        $id = $this->make(Artwork::class, ['dimensions' => '472 x 345 mm']);
        $this->assertEquals([472,345], Artwork::find($id)->dimensions());

        $id = $this->make(Artwork::class, ['dimensions' => '184.2 x 148.9 cm (72 1/2 x 58 1/2 in.)']);
        $this->assertEquals([1842,1489], Artwork::find($id)->dimensions());

        $id = $this->make(Artwork::class, ['dimensions' => '452 x 661 mm (image); 461 x 669 mm (plate); 498 x 729 mm (sheet)']);
        $this->assertEquals([452,661], Artwork::find($id)->dimensions());

        $id = $this->make(Artwork::class, ['dimensions' => '291 x 201 mm (plate trimmed)']);
        $this->assertEquals([291,201], Artwork::find($id)->dimensions());

        $id = $this->make(Artwork::class, ['dimensions' => 'a (jar): 7.1 x 8.5 x 8.5 cm (2.82 x 3 .375 x 3.375 in)
b (lid): 2.1 x 4 x 4 cm (.83 x 1.61 x 1.60 in)
c (saucer): 2.5 x 13.3 x 13.3 cm (1 x 5.25 x 5.25 in)']);
        $this->assertEquals([71,85,85], Artwork::find($id)->dimensions());

        $id = $this->make(Artwork::class, ['dimensions' => '107.6 x 27.8 cm (42 3/8 x 11 in.)
Warp repeat: 72.2 cm (28 3/8 in.)']);
        $this->assertEquals([1076,278], Artwork::find($id)->dimensions());

        $id = $this->make(Artwork::class, ['dimensions' => 'Approx. 24 x 18.3 cm']);
        $this->assertEquals([240,183], Artwork::find($id)->dimensions());

        $id = $this->make(Artwork::class, ['dimensions' => 'H. 5.6 cm (2 3/16 in.); diam. 10.9 cm (4 15/16 in.)']);
        $this->assertEquals([56,109], Artwork::find($id)->dimensions());

    }

}
