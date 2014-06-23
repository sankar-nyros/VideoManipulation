<?php

    namespace PHPVideoToolkit;

    include_once './includes/bootstrap.php';
  
    try
    {
    	//$vid = $_POST['filepath'];              //Video file path
    	$video = new Video($example_video_path);
    	
    	
    	$time = (int)$_POST['time']-1;			//Time in seconds to take snapshot
    	$output_image_name = $_POST['name'];	//Output image name
  		
		//$video = new Video('/var/www/video/Videos/BigBuckBunny_320x180.mp4');
    	//$process = $video->extractFrame(new Timecode(61))->save('./output/test13.jpg', null, Media::OVERWRITE_EXISTING);	
    	
    	$process = $video->extractFrame(new Timecode($time))->save('./output/'.$output_image_name, null, Media::OVERWRITE_EXISTING);	
		$output = $process->getOutput();
		
		exit(json_encode(array('success' => true)));    
        
    }
    catch(FfmpegProcessOutputException $e)
    {
        echo(json_encode(array('success' => false,'Message' => $e->getMessage()))); 
    }
    catch(Exception $e)
    {
    	echo(json_encode(array('success' => false,'Message' => $e->getMessage())));
    }

