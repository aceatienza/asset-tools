<?php

use Mockery as m;       // imports and aliases
use Way\Tests\Factory;

class AssetTest extends TestCase {
    use \Way\Tests\ModelHelpers;

	public function __construct()
	{
        $this->mock = m::mock('Eloquent', 'Models\Asset')->makePartial();
    	// $this->collection = m::mock('Illuminate\Database\Eloquent\Collection')->shouldDeferMissing();
	}

    public function setUp()
    {
        parent::setUp();

        // $asset = Factory::make('Models\Asset'); // doesn't work
        // $this->attributes = Factory::asset(['id' => 1]);
        // $this->app->instance('Asset', $this->mock);

        // or should the asset be created in setup()?
        // $this->mock = m::mock('Models\Asset')->makePartial();
    }

    public function testBelongsToManyPortfolios()
    {
        $this->assertBelongsToMany('portfolios', 'Models\Asset');
    }

    public function testCanCreateThumbnail()
    {
        $this->mock->thumbname = null;
        $this->mock->path = 'foo';

        $mockImage = m::mock('Intervention\Image\Image');
        $mockImage->shouldReceive('grab')->once()
            ->with(300,200);
        $mockImage->shouldReceive('save')->once();

        $this->mock->createThumbnail(null, 'WAR.jpg', null, null, $mockImage);
        
        $this->assertEquals($this->mock->thumbname, 'thumb_WAR.jpg');  
    }

    public function testCanUpdateAttributes()
    {
        $imgInfo = [300, 200, 'mime' => 'image/jpg'];
        $fileName = 'Luffys.jpg';
        $relativePath = 'straw/hat';

        $this->mock->updateAttributes($imgInfo, $fileName, $relativePath);

        $this->assertEquals($this->mock->width, 300);
        $this->assertEquals($this->mock->height, 200);
        $this->assertEquals($this->mock->filename, 'Luffys.jpg');
        $this->assertEquals($this->mock->path, 'straw/hat');
        $this->assertEquals($this->mock->filetype, 'image/jpg');
    }

    public function testUploadFile()
    {
        $fileMock = m::mock('Symfony\Component\HttpFoundation\File\UploadedFile');  
        $fileMock->shouldReceive('getClientOriginalExtension')->once();
        $fileMock->shouldReceive('move')->once()->andReturn(True);

        $this->mock->shouldReceive('getFileInfo')->once();
        $this->mock->shouldReceive('updateAttributes')->once();
        $this->mock->shouldReceive('createThumbnail')->once();
        $this->mock->shouldReceive('save')->once();

        $this->assertTrue( $this->mock->uploadFile('foo', $fileMock) );
    }

}