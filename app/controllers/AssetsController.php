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
        $form_opts = array(
                'url' => 'control/asset',
                'class'  => '',
                'name'   => 'newAsset',
                'files'  => true
        );
        $portfolio_list = Portfolio::lists('client_name', 'id');


        /***  AJAXIFY FROM HERE so that the page loads even if Vimeo isn't working ***/

        $vimeokey = DB::table('cms')->where('name', 'vimeo_key')->pluck('value');
        $vimeosecret = DB::table('cms')->where('name', 'vimeo_secret')->pluck('value');
        $vimeoid = DB::table('cms')->where('name', 'vimeo_id')->pluck('value');
        // dd($vimeokey, $vimeosecret, $vimeoid);

        $vimeo = new Vimeo($vimeokey, $vimeosecret);
        // dd($vimeo);

        $pageNo = 1;  // or set as separate toggle
        $perPage = 20;

        $vimeoVideos = $vimeo->call('vimeo.videos.getUploaded', array(
                                        'user_id'       => $vimeoid,
                                        'page'          => $pageNo,
                                        'per_page'      => $perPage,
                                        'full_response' => true
        )); 
        dd($vimeoVideos);

        $videoList = [];

        foreach ($vimeoVideos->videos->video as $video) {

            // $videoInfo['thumbnail'] = $video->thumbnails->thumbnail[1]->_content;  // 0 small == '75', 1 medium == '150', 2 large == '360'
            // $videoInfo['url'] = $video->urls->url[0]->_content;                     // video, use 1 for mobile
            // $videoList[$video->id] = $videoInfo;

            $videoList[$video->id] = array(
                    'title'     => $video->title,
                    'thumbnail' => $video->thumbnails->thumbnail[1]->_content,
                    'url'       => $video->urls->url[0]->_content
            );
        }

        return View::make('assets.create')
                    ->with('portfolio_list', $portfolio_list)
                    ->with('video_list', $videoList)
                    ->with('form_opts', $form_opts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        $validation = Validator::make($input, Asset::$rules);

        if ($validation->fails())
        {
            return Redirect::route('control.asset.create')
                ->withInput()
                ->withErrors($validation)
                ->with('message', 'There were validation errors.');
        } 

        $asset = Asset::create($input); 

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
        $asset->deleteFile();
        $asset->delete();

        return Redirect::route('control.asset.index');
    }

}