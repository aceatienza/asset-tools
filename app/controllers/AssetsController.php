<?php

use Dukt\Vimeo;
use Models\Asset;

class AssetsController extends BaseController {

    /**
     * Asset Repository
     *
     * @var Asset
     */
    protected $asset;

    public function __construct(Asset $asset)
    {
        $this->asset = $asset;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $assets = $this->asset->all();
        return View::make('assets.index', compact('assets'))
            ->with('assets', $assets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // TODO: complete the form for when js is not enabled
        // if($id = Input::get('id')) {
        //     dd($id);
        // }
        // OR
        // if( $query = Request::server('QUERY_STRING') ) {
        //     parse_str($query, $output);
        //     dd($output);
        // }

        $portfolio_list = Portfolio::lists('client_name', 'id');

        /** TODO: create a separate page to add a Vimeo video in case js in inactive **/

        /***  REFACTOR INTO own class FROM HERE so that the page loads even if Vimeo isn't working? ***/

        $vimeokey = DB::table('cms')->where('name', 'vimeo_key')->pluck('value');
        $vimeosecret = DB::table('cms')->where('name', 'vimeo_secret')->pluck('value');
        $vimeoid = DB::table('cms')->where('name', 'vimeo_id')->pluck('value');
        $videoList = [];
        // dd($vimeokey, $vimeosecret, $vimeoid);

        $cacheFolder = storage_path().'/cache';

        $vimeo = new Vimeo($vimeokey, $vimeosecret);
        $vimeo->enableCache(Vimeo::CACHE_FILE, $cacheFolder, 300);  // Vimeo best-practice

        // try to reach Vimeo
        try {
            $pageNo = 1;  // or set as separate toggle
            $perPage = 20;

            $vimeoVideos = $vimeo->call('vimeo.videos.getUploaded', array(
                                            'user_id'       => $vimeoid,
                                            'page'          => $pageNo,
                                            'per_page'      => $perPage,
                                            'full_response' => true
            )); 
        }
        catch (VimeoAPIException $e) {
            echo "Encountered a Vimeo API error -- code {$e->getCode()} - {$e->getMessage()}";
        }

        if(isset($vimeoVideos)) {
            foreach ($vimeoVideos->videos->video as $video) {
                $videoList[$video->id] = array(
                        'title'     => $video->title,
                        'thumbnail' => $video->thumbnails->thumbnail[1]->_content,
                        'url'       => $video->urls->url[0]->_content
                );
            }        
        }

        return View::make('assets.create')
                    ->with('portfolio_list', $portfolio_list)
                    ->with('video_list', $videoList);
    }

    /**
    *   Show the form to add a Vimeo video
    *   @return  Response
    */
    public function addVimeo()
    {
        /***  REFACTOR INTO own class FROM HERE so that the page loads even if Vimeo isn't working? ***/

        $vimeokey = DB::table('cms')->where('name', 'vimeo_key')->pluck('value');
        $vimeosecret = DB::table('cms')->where('name', 'vimeo_secret')->pluck('value');
        $vimeoid = DB::table('cms')->where('name', 'vimeo_id')->pluck('value');
        $videoList = [];
        // dd($vimeokey, $vimeosecret, $vimeoid);

        $cacheFolder = storage_path().'/cache';

        $vimeo = new Vimeo($vimeokey, $vimeosecret);
        $vimeo->enableCache(Vimeo::CACHE_FILE, $cacheFolder, 300);  // Vimeo best-practice

        // try to reach Vimeo
        try {
            $pageNo = 1;  // or set as separate toggle
            $perPage = 20;

            $vimeoVideos = $vimeo->call('vimeo.videos.getUploaded', array(
                                            'user_id'       => $vimeoid,
                                            'page'          => $pageNo,
                                            'per_page'      => $perPage,
                                            'full_response' => true
            )); 
        }
        catch (VimeoAPIException $e) {
            echo "Encountered a Vimeo API error -- code {$e->getCode()} - {$e->getMessage()}";
        }

        if(isset($vimeoVideos)) {
            foreach ($vimeoVideos->videos->video as $video) {
                $videoList[$video->id] = array(
                        'title'     => $video->title,
                        'thumbnail' => $video->thumbnails->thumbnail[1]->_content,
                        'url'       => $video->urls->url[0]->_content
                );
            }        
        }

        return View::make('assets.vimeo')->with('video_list', $videoList);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return  Response
     */
    public function store()
    {
        $input = Input::all();
        // dd($input);

        $validation = Validator::make($input, Asset::$rules);

        if ($validation->fails())
        {
            return Redirect::route('control.asset.create')
                ->withInput()
                ->withErrors($validation)
                ->with('message', 'There were validation errors.');
        } 

        $asset = Asset::create($input); 
        // dd($asset);

        if(Input::hasFile('image')) {
            // dd(Input::all()); // WORKS
            $relativePath = '/images/' . $asset->id;
            
            // $file = Input::get('image'); // BROKEN
            $file = $input['image'];

            // $this->asset->$file = Input::get('image'); // Undefined var file even when setting it1
            $upload_success = $asset->uploadFile($relativePath, $file);

            if( $upload_success ) {
                return Redirect::route('control.asset.edit', array($asset->id));
        //         // return Response::json('success', 200);
        //     // } else {
        //         // return Response::json('error', 400);
            }
        }

        return Redirect::route('control.asset.edit', array($asset->id)); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $asset = $this->asset->find($id);
        $portfolio_list = Portfolio::lists('client_name', 'id');

        if (is_null($asset))
        {
            return Redirect::route('control.asset.index');
        }

        return View::make('assets.edit', compact('asset'))
                    ->with('portfolio_list', $portfolio_list);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $input = array_except(Input::all(), '_method');
        $validation = Validator::make($input, Asset::$rules);

        if ($validation->passes())
        {
            $asset = $this->asset->find($id);
            $asset->portfolios()->attach($input['Portfolios']);
            $asset->update($input);

            return Redirect::route('control.asset.edit', array($id));
        }

        return Redirect::route('control.asset.edit', $id)
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $asset = $this->asset->find($id);
        if(isset($asset->path) && $asset->path != null){
            $asset->deleteFile();
        }
        $asset->delete();

        return Redirect::route('control.asset.index');
    }

}