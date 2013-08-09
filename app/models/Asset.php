<?php

namespace Models;

use Eloquent;
use Intervention\Image\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Asset extends Eloquent {

	protected $fillable  = array('active', 'order', 'filetype',
		'filesize', 'path', 'width', 'height', 'name',
    'vimeo_id', 'vimeo_title', 'vimeo_url', 'vimeo_thumbnail');
	protected $guarded   = array('');
	public static $rules = array(
		 // 'file' => 'image|max:10000',
	);

	public function portfolios()
	{
		return $this->belongsToMany('Portfolio');
	}		

	/**
	*	Upload file
	*	@param  UploadedFile  	$file  			File from Input
	*	@param  string  		$relativePath  	New path for Asset
	*	@return boolean  True if successfully uploaded
	* 	@see 	getFileInfo()
	* 	@see 	updateAttributes()
	* 	@see 	createThumbnail()
	*/
	public function uploadFile($relativePath, UploadedFile $file=null, $fileName=null)
	{
		$this->file = $file;

        $fileName = $fileName ?: sha1(time()).'.'.$this->file->getClientOriginalExtension(); 
        $destinationPath = public_path() . $relativePath; // mock or change public_path to test?

        $upload_success = $this->file->move($destinationPath, $fileName);

        if($upload_success) {
    		$newPath = $destinationPath . '/' . $fileName;  // for creation of thumbnail

        	$imgInfo = $this->getFileInfo($newPath);
        	$this->updateAttributes($imgInfo, $fileName, $relativePath); // can you get relativepath from full path?
			$this->createThumbnail($newPath, $fileName); 

			$this->save();

        	return True;	
        } else {
        	// return error message about file upload
        	return False;
        }
  	}

  	/**
  	*	@param  Array  $imgInfo        Array from getimagesize
  	*	@param  string  $filename 	   New name of file
  	*	@param  string  $relativePath  Relative path to file
  	*	@see 	getFileInfo()
  	*/
  	public function updateAttributes($imgInfo=null, $fileName=null, $relativePath=null)
  	{
	    $this->width = $imgInfo[0];
    	$this->height = $imgInfo[1];
    	$this->filename = $fileName;
    	$this->path = $relativePath;
    	$this->filetype = $imgInfo['mime'];
  	}

  	/**
  	*	@param 	string  $newPath  	Path to uploaded file
  	* 	@return  array  from getimagesize()
  	*/
  	public function getFileInfo($newPath=null)
  	{
  		return getimagesize($newPath);
  	}

  	/**
  	*	Create thumbnail from uploaded image.
  	*	@param	string  $newPath  path to file
  	* 	@param  string  $fileName  New file name
  	*/
  	public function createThumbnail($newPath = null, $fileName=null, $width=null, $height=null, \Intervention\Image\Image $img=null)
  	{
  		$img = $img ?: Image::make($newPath); // if there's an img, do nothing, else create a new one
  		$width = $width ?: 300;  // default to 300px width
  		$height = $height ?: 200;  // default to 200px height

		// Crop and resize when creating a thumbnail, 60% quality
		$thumbName = 'thumb_'.$fileName;
        $img->grab($width, $height);
        $img->save(public_path() . '/' . $this->path .'/'.$thumbName, 60);

        $this->thumbname = $thumbName;
  	}

  	/**
  	*	Add this Asset to a Portfolio
  	*/
  	public function addToPortfolio($portfolio_id)
  	{
  		$this->portfolios()->sync($portfolio_id);
  	}

  	/**
  	*	Remove files and folders if any
  	* Is this necessary? if the resource is being deleted, shouldn't you just rmdir?
  	*/
  	public function deleteFile()
  	{

  		if(file_exists(public_path() . '/' . $this->path .'/'. $this->filename)) {
  			$dirPath = public_path() . $this->path;

  			unlink($dirPath .'/'. $this->filename);

  			if(file_exists($dirPath .'/'. $this->thumbname)) 
  				unlink($dirPath .'/'. $this->thumbname); 

  			rmdir($dirPath);
  		}
  	}

}