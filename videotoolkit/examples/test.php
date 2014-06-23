<?php

    namespace PHPVideoToolkit;
    
    include_once './includes/bootstrap.php';


	$input_video = '/var/www/video/videotoolkit/examples/media/big_buck_bunny.webm';
	$vm = new VideoManipulation();
	//echo "<pre>".print_r($vm,true)."</pre>";
	
	//Snapshot
	//$res_snap = $vm->snapshot($input_video,'10','test.jpg');


	//Trim
	//$res_trim = $vm->trim($input_video,'10','15','test.mp4');


	//crop
	//$res_crop = $vm->crop($input_video,'200','300','200','300','test_crop.mp4');
	
	
	//Extract audio
	//$res_audio_extract = $vm->audio_extract($input_video,'test_audio.mp3');
	
	
	//Convert Format
	//$res_resizer = $vm->video_resizer_format($input_video,'200','300','test_resizer.mp4');
	
	
	echo $res_resizer;
	    
	
