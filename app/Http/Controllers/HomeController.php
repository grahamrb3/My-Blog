<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Requests\Request;
use App\Model\Link;
use App\Model\Music;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {}

   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //return view('home');
    }

    public function showName(Request $request) {
        $name = "Laravel";
        if ($request->input("name")) {
            $names = explode(" ", $request->input("name"));
            for( $i = 0; $i < count($names); $i++) {
                $names[$i] = ucfirst($names[$i]);
            }
            $name = implode(" ", $names);
        }
        $query = Link::where("owner", "=", $name);
        $links = $query->get();
        foreach($links as $link) {
            if ($link->owner === "Sam") {
                $link->link = route($link->link);
            }
        }
        $imageRequest = $this->resolveImage($request->input("imageNum"));
        $image = $this->getImage($imageRequest);
        $trackRequest = $request->input("trackNum");
        $trackRequest = $this->resolveTrack($request->input("trackNum"));
        $track = $this->getTrack($trackRequest);
        //EXIF: Model, ExposureTime, FocalLength, COMPUTED ApertureFNumber, and ISOSpeedRatings
        //$exifInfo = exif_read_data("/home/pi/blog/public/img/germany.jpg");
        return view('welcome')
            ->with(['name' => $name,
            'links' => $links,
            'image' => $image, //This will resolve to img/<pic>
            'track' => $track,
            'trackNum' => $trackRequest,
            'imageNum' => $imageRequest,]);
    }

    private function getImage($imageNumber) {
        $imageNumber = (int)$imageNumber;
        $files = glob("/home/pi/blog/public/img/*");
        if ($files) {
            return "img/".basename($files[$imageNumber]);
        }
    }

    private function resolveImage($imageNumber) {
        $maxImage = 0;
        if (!isset($imageNumber)) {
            return 0;
        }
        $imageNumber = (int)$imageNumber;
        $files = glob("/home/pi/blog/public/img/*");
        if ($files) {
            $maxImage = count($files);
        }
        if ($imageNumber < 0) {
            $imageNumber = $maxImage - 1;
        }
        else if ($imageNumber == $maxImage) {
            $imageNumber = 0;
        }
        return $imageNumber;
    }

    private function resolveTrack($trackNum) {
        $max = Music::count();
        if (!isset($trackNum)) {
            $trackNum = 1;
        }
        if ($trackNum === "0") {
            $trackNum = $max;
        }
        if ($trackNum > $max) {
            $trackNum = 1;
        }
        if ($trackNum < 1) {
            $trackNum = $max;
        }
        return $trackNum;
    }

    private function getTrack($trackNum) {
        return Music::where("id", "=", $trackNum)->get()[0];
    }
}
