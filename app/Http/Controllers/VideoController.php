<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use App\Services\VideoService;

class VideoController extends Controller
{
    //
    protected $videoservice;
 
	public function __construct(VideoService $videoservice)
	{
		$this->videoservice = $videoservice;
	}

    /**
     * Show add video page.
     *
	 * @param gym_id
     * @return \Illuminate\Contracts\Support\Renderable
     */
	public function addvideo($gym_id)
	{
		return view('addvideo', ['gym_id' => $gym_id]);
	}

    /**
     * Post video.
     *
	 * @param Illuminate\Http\Request
     * @return \Illuminate\Contracts\Support\Renderable
     */
	public function createVideo(Request $request)
	{	
		
		$video = $this->videoservice->create($request);
		$idd = $video ->gym_id;
		return redirect('/account/gymowner/gym/myvideos/'.$idd);
	}

    /**
     * Show update video page.
     *
	 * @param integer
     * @return \Illuminate\Contracts\Support\Renderable
     */
	public function update_video($id)
	{
		$video = $this->videoservice->read($id);
		return view('updatevideo', $video);
	}

    /**
     * Put update video.
     *
	 * @param integer
	 * @param Illuminate\Http\Request
     * @return \Illuminate\Contracts\Support\Renderable
     */
	public function updateVideo($id, Request $request)
	{
		$this->videoservice->update($request, $id);
		$idd = $this->videoservice->getGymId($id);
		return redirect('/account/gymowner/gym/myvideos/'.$idd);
	}

    /**
     * Delete video.
     *
	 * @param integer
     * @return \Illuminate\Contracts\Support\Renderable
     */
	public function deleteVideo($id)
	{	
		$idd = $this->videoservice->getGymId($id);
		$this->videoservice->delete($id);
		return redirect('/account/gymowner/gym/myvideos/'.$idd);
	}


    /**
     * Publish video.
     *
	 * @param integer
	 * @param Illuminate\Http\Request
     * @return \Illuminate\Contracts\Support\Renderable
     */
	public function publishVideo($id, Request $request)
	{
		$this->videoservice->publish($id);
		$idd = $this->videoservice->getGymId($id);
		return redirect('/account/gymowner/gym/myvideos/'.$idd);
	}

	/**
     * Get a video
     *
     * @param integer $video id
     * @return \Illuminate\Contracts\Support\Renderable
     */
	public function watch($id)
	{
		$data = $this->videoservice->read($id);
		return view('watchvideogym', ['data' => $data]);
	}
}
